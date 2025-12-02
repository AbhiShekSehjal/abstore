<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $products   = Product::all();
            $Categories = Category::all();
            return view('products', compact('products', 'Categories'));
        } else {
            return redirect()->route('LoginPage');
        }
    }
}