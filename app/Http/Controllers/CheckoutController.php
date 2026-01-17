<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use App\Models\Order;
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

            return view('checkout', compact('settings', 'order'));
        } else {
            return redirect()->route('LoginPage');
        }
    }
}
