<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $Categories = Category::all();

        $query = Product::query();

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Price filter
        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }

        // Sorting
        if ($request->sort == 'low_price') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'high_price') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort == 'stock') {
            $query->orderBy('stock', 'desc'); 
        } elseif ($request->sort == 'discount') {
            $query->orderBy('discount', 'desc'); 
        }

        if ($request->filled('search')) {
        $search = $request->search;
        $query->where('name', 'like', "%{$search}%");
    }

        $products = $query->get();

        return view('products', compact('products', 'Categories'));
    }

}