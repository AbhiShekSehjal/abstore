<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductsController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $categories = Category::all();
            
            // Get search query and sort option
            $search = $request->input('search', '');
            $sort = $request->input('sort', 'name_asc');
            
            // Build the query
            $query = Product::query();
            
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
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'stock_asc':
                    $query->orderBy('stock', 'asc');
                    break;
                case 'stock_desc':
                    $query->orderBy('stock', 'desc');
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
            
            // Paginate with 10 products per page
            $products = $query->paginate(10);

            return view('admin.products', compact('categories', 'products', 'search', 'sort'));
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
            'hoverProductImage' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        $hoverImagePath = null;

        $discountValue = ($request->price * $request->discount) / 100;
        $calaculatedValue = $request->price - $discountValue;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('products', 'public');
        }

        if ($request->hasFile('hoverProductImage')) {
            $hoverImagePath = $request->file('hoverProductImage')
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
            'hoverProductImage' => $hoverImagePath,
        ]);

        return redirect()->route('admin.products')
            ->with('success', 'Product added successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hoverProductImage' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product = Product::findOrFail($request->product_id);

        $discountValue = ($request->price * $request->discount) / 100;
        $calculatedValue = $request->price - $discountValue;

        $updateData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'sale_price' => $calculatedValue,
            'stock' => $request->stock,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Store new image
            $updateData['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle hover image upload
        if ($request->hasFile('hoverProductImage')) {
            // Delete old hover image if it exists
            if ($product->hoverProductImage && Storage::disk('public')->exists($product->hoverProductImage)) {
                Storage::disk('public')->delete($product->hoverProductImage);
            }

            // Store new hover image
            $updateData['hoverProductImage'] = $request->file('hoverProductImage')->store('products', 'public');
        }

        $product->update($updateData);

        return redirect()->route('admin.products')
            ->with('success', 'Product updated successfully');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Delete the product image if it exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Product deleted successfully');
    }
}
