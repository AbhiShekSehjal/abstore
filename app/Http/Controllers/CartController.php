<?php

namespace App\Http\Controllers;

use App\Models\admin\Setting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $settings = Setting::first();
            $products   = Product::inRandomOrder()->take(6)->get();
            $order = Order::where('user_id', Auth::id())
                ->where('order_status', 'cart')
                ->with('items.product')
                ->first();

            return view('cart', compact('settings', 'order', 'products'));
        } else {
            return redirect()->route('LoginPage');
        }
    }

    public function add($id)
    {
        if (! Auth::check()) {
            return redirect()->route('LoginPage');
        }

        $product = Product::findOrFail($id);

        // order_status
        $order = Order::where('user_id', Auth::id())
            ->where('order_status', 'cart')
            ->first();

        if (! $order) {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'order_status'   => 'cart',
                'payment_status' => 'pending',
                'total'          => 0,
            ]);
        }

        // Add / update item
        $item = OrderItem::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => 1,
                'price'      => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    public function increase(Request $request)
    {
        $item = OrderItem::findOrFail($request->item_id);
        $item->quantity += 1;
        $item->save();

        return response()->json([
            'quantity' => $item->quantity,
            'item_total' => $item->quantity * $item->price
        ]);
    }

    public function decrease(Request $request)
    {
        $item = OrderItem::findOrFail($request->item_id);

        if ($item->quantity > 1) {
            $item->quantity -= 1;
            $item->save();
        }

        return response()->json([
            'quantity' => $item->quantity,
            'item_total' => $item->quantity * $item->price
        ]);
    }

    public function remove(Request $request)
    {
        $item = OrderItem::findOrFail($request->item_id);
        $item->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
