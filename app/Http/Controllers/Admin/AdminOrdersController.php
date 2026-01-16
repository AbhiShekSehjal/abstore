<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrdersController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

            $orders = Order::all();
            $orderItems = OrderItem::all();

            return view('admin.orders', compact('orders', 'orderItems'));
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }
}
