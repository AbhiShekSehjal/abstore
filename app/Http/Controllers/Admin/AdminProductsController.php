<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminProductsController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $categories = Category::all();
            $products = Product::all();



            return view('admin.products', compact('categories', 'products'));
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;

        $discountValue = ($request->price * $request->discount) / 100;
        $calaculatedValue = $request->price + $discountValue;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'sale_price' => $calaculatedValue,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')
            ->with('success', 'Product added successfully');
    }
}
