<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $orders = Order::all();
            $settings = Setting::first();

            return view('myOrders', compact('orders', 'settings'));
        } else {
            return redirect()->route('LoginPage');
        }
    }
}
