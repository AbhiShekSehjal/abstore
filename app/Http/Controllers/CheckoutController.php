<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Razorpay\Api\Api;

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
            'payment_method' => 'required|in:cod',
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
            'payment_method' => 'Only Cash on Delivery is allowed via this form. Use Razorpay for online payments.',
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

        // Only allow COD through form submission
        if ($validated['payment_method'] !== 'cod') {
            return redirect()->route('checkout.index')
                ->with('error', 'Online payments must be processed through Razorpay. Please select Cash on Delivery or use online payment option.');
        }

        // Update order with address and payment information (COD only)
        $order->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'payment_method' => 'cod',
            'order_status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        // Decrease product stock for each item in the order
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->decrement('stock', $item->quantity);
            }
        }

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


    public function createPayment(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $order = Order::findOrFail($request->order_id);

            if ($order->user_id !== Auth::id()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            // Validate address details
            $validated = $request->validate([
                'name' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s]+$/',
                'phone' => 'required|digits:10|numeric',
                'email' => 'required|email|max:255',
                'address' => 'required|string|min:10|max:500',
                'city' => 'required|string|min:2|max:100',
                'state' => 'required|string|min:2|max:100',
                'pincode' => 'required|digits:6|numeric',
            ]);

            // Ensure order has items
            $order->load('items');
            if (!$order->items || $order->items->count() === 0) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }

            // Get the total amount (calculate if not set)
            $totalAmount = $order->getTotalAmount();

            if ($totalAmount <= 0) {
                return response()->json(['error' => 'Invalid order amount'], 400);
            }

            // Update order with address information and total
            $order->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'payment_method' => 'online',
                'total' => $totalAmount,
            ]);

            // Create Razorpay order
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            if (!config('services.razorpay.key') || !config('services.razorpay.secret')) {
                return response()->json(['error' => 'Razorpay credentials not configured'], 500);
            }

            $razorpayOrder = $api->order->create([
                'receipt' => 'order_' . $order->id . '_' . time(),
                'amount'  => (int)($totalAmount * 100), // Amount in paisa
                'currency' => 'INR',
                'notes' => [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id
                ]
            ]);

            return response()->json([
                'order_id' => $razorpayOrder['id'],
                'key'      => config('services.razorpay.key'),
                'amount'   => $totalAmount
            ]);
        } catch (\Exception $e) {
            Log::error('Payment creation error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Payment Error: ' . $e->getMessage()], 400);
        }
    }


    public function paymentSuccess(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('LoginPage');
        }

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            // Verify payment signature
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            // Signature verified, update order status
            $order = Order::find($request->order_id);
            
            if (!$order || $order->user_id !== Auth::id()) {
                return redirect()->route('orders.track')
                    ->with('error', 'Order not found');
            }

            $order->update([
                'payment_status' => 'paid',
                'order_status'   => 'confirmed',
            ]);

            // Decrease product stock for each item in the order
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            return redirect()->route('orders.track')
                ->with('success', 'Payment successful! Your order has been confirmed.');
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            // Signature verification failed
            return redirect()->route('checkout.index')
                ->with('error', 'Payment verification failed. Please try again.');
        } catch (\Exception $e) {
            return redirect()->route('checkout.index')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
