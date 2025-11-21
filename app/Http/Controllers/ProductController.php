<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products   = Product::all();
        $Categories = Category::all();
        return view('products', compact('products', 'Categories'));
    }
}