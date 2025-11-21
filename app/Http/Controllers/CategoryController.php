<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show($id)
    {

        $category = Category::findOrFail($id);

        $items = Product::where('category_id', $id)->get();

        return view('category', compact('category', 'items'));

    }
}