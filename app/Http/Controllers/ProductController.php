<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isAdmin = Auth::user()->role->name === 'admin';

        if ($isAdmin)
        {
            return view('admin.products.index', ['products' => Product::with('category')->get()]);
        }
        else
        {
            return view('products.index', [
                'categories' => Category::all(),
                'products' => Product::all()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:4096'
        ]);

        $slug = Str::slug($validate['name'], '-');

        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists())
        {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $product = Product::create([
            'name' => $validate['name'],
            'price' => $validate['price'],
            'category_id' => $validate['category_id'],
            'stock' => $validate['stock'],
            'description' => $validate['description'],
            'slug' => $slug,
            'image_url' => ''
        ]);

        if ($request->hasFile('image'))
        {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image_url = Storage::url($imagePath);
        }

        $product->save();

        return redirect()->route('admin.product.edit', ['product' => $product])->with('success', 'Product created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:4096'
        ]);

        if ($request->hasFile('image'))
        {
            if ($product->image_url)
            {
                $oldImagePath = str_replace('/storage/', '', $product->image_url);

                if (Storage::disk('public')->exists($oldImagePath))
                {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $product->image_url = Storage::url($imagePath);
        }
        $product->name = $validate['name'];
        $product->price = $validate['price'];
        $product->category_id = $validate['category_id'];
        $product->stock = $validate['stock'];
        $product->description = $validate['description'];
        $product->save();

        return redirect()->route('admin.product.edit', ['product' => $product])->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image_url)
        {
            $imagePath = str_replace('/storage/', '', $product->image_url);
            if (Storage::disk('public')->exists($imagePath))
            {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }
}
