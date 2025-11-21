<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class IndexController extends Controller
{
    public function index()
    {
        $products   = Product::inRandomOrder()->take(6)->get();
        $categories = Category::all();
        return view('index', compact('categories', 'products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        $products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(6)
            ->get();

        return view('product', compact('product', 'products'));
    }
}