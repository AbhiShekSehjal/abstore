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
}