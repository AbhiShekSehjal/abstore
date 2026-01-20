<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCategoriesController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            // Get search query and sort option
            $search = $request->input('search', '');
            $sort = $request->input('sort', 'name_asc');
            
            // Build the query
            $query = Category::query();
            
            // Apply search filter
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            }
            
            // Apply sorting
            switch ($sort) {
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default: // name_asc
                    $query->orderBy('name', 'asc');
            }
            
            // Paginate with 10 categories per page
            $categories = $query->paginate(10);

            return view('admin.categories', compact('categories', 'search', 'sort'));
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

    public function update(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $category = Category::findOrFail($request->category_id);

        $updateData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];

        // Handle image upload
        if ($request->hasFile('category_image')) {
            // Delete old image if it exists
            if ($category->category_image && Storage::disk('public')->exists($category->category_image)) {
                Storage::disk('public')->delete($category->category_image);
            }

            // Store new image
            $updateData['category_image'] = $request->file('category_image')->store('categories', 'public');
        }

        $category->update($updateData);

        return redirect()->route('admin.categories')
            ->with('success', 'Category updated successfully');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $category = Category::findOrFail($request->category_id);
        
        // Delete the category image if it exists
        if ($category->category_image && Storage::disk('public')->exists($category->category_image)) {
            Storage::disk('public')->delete($category->category_image);
        }

        $category->delete();

        return redirect()->route('admin.categories')
            ->with('success', 'Category deleted successfully');
    }
}
