<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function show($id)
    {
        if (Auth::check()) {
            $category = Category::findOrFail($id);

            $items = Product::where('category_id', $id)->get();

            return view('category', compact('category', 'items'));
        } else {
            return redirect()->route('LoginPage');
        }
    }
}