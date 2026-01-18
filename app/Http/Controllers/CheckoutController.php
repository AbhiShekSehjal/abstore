<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $settings = Setting::first();

            $order = Order::where('user_id', Auth::id())
                ->where('order_status', 'cart')
                ->with('items.product')
                ->first();

            if (!$order) {
                return redirect()->route('cart.index')
                    ->with('error', 'Your cart is empty');
            }

            // Get the last completed order to pre-fill address information
            $lastOrder = Order::where('user_id', Auth::id())
                ->whereIn('order_status', ['pending', 'confirmed', 'shipped', 'delivered'])
                ->orderByDesc('created_at')
                ->first();

            return view('checkout', compact('settings', 'order', 'lastOrder'));
        } else {
            return redirect()->route('LoginPage');
        }
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('LoginPage');
        }

        // Validate all required fields with strict rules for Indian addresses
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|digits:10|numeric',
            'email' => 'required|email|max:255',
            'address' => 'required|string|min:10|max:500',
            'city' => 'required|string|min:2|max:100',
            'state' => 'required|string|min:2|max:100',
            'pincode' => 'required|digits:6|numeric',
            'payment_method' => 'required|in:cod,online',
        ], [
            'name.regex' => 'Full name should contain only letters and spaces.',
            'name.min' => 'Full name must be at least 2 characters.',
            'phone.digits' => 'Mobile number must be exactly 10 digits.',
            'phone.numeric' => 'Mobile number should contain only numbers.',
            'address.min' => 'Please enter a complete address with at least 10 characters.',
            'pincode.digits' => 'PIN code must be exactly 6 digits.',
            'pincode.numeric' => 'PIN code should contain only numbers.',
            'city.min' => 'City name should be at least 2 characters.',
            'state.min' => 'State name should be at least 2 characters.',
        ]);

        // Get the cart order
        $order = Order::where('user_id', Auth::id())
            ->where('order_status', 'cart')
            ->with('items.product')
            ->first();

        if (!$order) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        // Update order with address and payment information
        $order->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'payment_method' => $validated['payment_method'],
            'order_status' => 'confirmed',
            'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending',
        ]);

        // Redirect to orders page with success message
        return redirect()->route('orders.track')
            ->with('success', 'Order placed successfully! You can now track your order.');
    }

    public function updateAddress(Request $request, $orderId)
    {
        if (!Auth::check()) {
            return redirect()->route('LoginPage');
        }

        // Find the order and verify it belongs to the authenticated user
        $order = Order::find($orderId);

        if (!$order || $order->user_id !== Auth::id()) {
            return redirect()->route('orders.track')
                ->with('error', 'Unauthorized access');
        }

        // Check if order can be edited (only pending or confirmed)
        if (!in_array($order->order_status, ['pending', 'confirmed'])) {
            return redirect()->route('orders.track')
                ->with('error', 'This order cannot be edited. It has already been shipped.');
        }

        // Validate all required fields
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|digits:10|numeric',
            'email' => 'required|email|max:255',
            'address' => 'required|string|min:10|max:500',
            'city' => 'required|string|min:2|max:100',
            'state' => 'required|string|min:2|max:100',
            'pincode' => 'required|digits:6|numeric',
        ], [
            'name.regex' => 'Full name should contain only letters and spaces.',
            'name.min' => 'Full name must be at least 2 characters.',
            'phone.digits' => 'Mobile number must be exactly 10 digits.',
            'phone.numeric' => 'Mobile number should contain only numbers.',
            'address.min' => 'Please enter a complete address with at least 10 characters.',
            'pincode.digits' => 'PIN code must be exactly 6 digits.',
            'pincode.numeric' => 'PIN code should contain only numbers.',
            'city.min' => 'City name should be at least 2 characters.',
            'state.min' => 'State name should be at least 2 characters.',
        ]);

        // Update the order with new address information
        $order->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
        ]);

        return redirect()->route('orders.track')
            ->with('success', 'Address updated successfully!');
    }

    public function buyNow($productId)
    {
        // Redirect to login if user not authenticated
        if (!Auth::check()) {
            return redirect()->route('LoginPage')
                ->with('info', 'Please login to continue');
        }

        // Find the product
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->route('products')
                ->with('error', 'Product not found');
        }

        // Get or create a cart order for this user
        $order = Order::where('user_id', Auth::id())
            ->where('order_status', 'cart')
            ->first();

        if (!$order) {
            // Create a new cart order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => 0,
                'order_status' => 'cart',
                'payment_status' => 'pending',
            ]);
        } else {
            // Clear existing cart items for Buy Now (single product checkout)
            $order->items()->delete();
        }

        // Add the product to the cart
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        // Redirect to checkout
        return redirect()->route('checkout.index')
            ->with('success', 'Product added! Complete your purchase');
    }
}
