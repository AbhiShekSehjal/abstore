<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminIndexController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $products   = Product::all();
            $categories = Category::all();
            $orders     = Order::all();
            $users      = User::all();
            return view('admin.index', compact('products', 'categories', 'orders', 'users'));
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }
}