<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isAdmin = Auth::user()->role->name === 'admin';

        if ($isAdmin)
        {
            return view('admin.categories.index', ['categories' => Category::withCount('products')->get()]);
        }
        return;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
            'icon' => 'nullable|string',
            'description' => 'required|string'
        ]);

        Category::create([
            'name' => $validate['name'],
            'icon' => $validate['icon'],
            'description' => $validate['description'],
            'slug' => Str::slug($validate['name'], '-')
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully');
    }

    /**
     * Menampilkan kategori dan produk terkait.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        $products = $category->products;
        return view('categories.show', ['category' => $category, 'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:255',
            'icon' => 'required|string',
            'description' => 'required|string'
        ]);

        $category->name = $validate['name'];
        $category->icon = $validate['icon'];
        $category->description = $validate['description'];
        $category->save();

        return redirect()->route('admin.category.edit', ['category' => $category])->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully');
    }
}
