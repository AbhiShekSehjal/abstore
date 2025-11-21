<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminIndexController extends Controller
{
    public function index()
    {
        $products   = Product::all();
        $categories = Category::all();
        $orders     = Order::all();
        $users     = User::all();
        return view('admin.index', compact('products', 'categories', 'orders', 'users'));
    }
}