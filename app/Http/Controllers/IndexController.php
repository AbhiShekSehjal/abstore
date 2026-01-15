<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use App\Models\Category;
use App\Models\Product;

class IndexController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $products   = Product::inRandomOrder()->take(6)->get();
            $categories = Category::all();

            $settings = Setting::first();

            return view('index', compact('categories', 'products', 'settings'));
        } else {
            return redirect()->route('LoginPage');
        }
    }

    // public function show($id)
    // {
    //     $product = Product::findOrFail($id);

    //     $products = Product::where('category_id', $product->category_id)
    //         ->where('id', '!=', $product->id)
    //         ->take(6)
    //         ->get();

    //     return view('product', compact('product', 'products'));
    // }

}