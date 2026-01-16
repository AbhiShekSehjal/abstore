<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminCategoriesController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $categories = Category::all();

            return view('admin.categories', compact('categories'));
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('category_image')) {
            $imagePath = $request->file('category_image')
                ->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_image' => $imagePath,
        ]);

        return redirect()->route('admin.categories')
            ->with('success', 'Category added successfully');
    }
}
