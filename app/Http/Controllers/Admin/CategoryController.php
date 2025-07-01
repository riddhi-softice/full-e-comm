<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('subcategories')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    { 
        return view('admin.categories.create');
    }
   
    public function store(Request $request)
    {
        // Validate name and generate slug
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->name);

        // Ensure slug is unique
        $existingSlugCount = Category::where('slug', $slug)->count();
        $originalSlug = $slug;
        $i = 1;
        while ($existingSlugCount > 0) {
            $slug = $originalSlug . '-' . $i;
            $existingSlugCount = Category::where('slug', $slug)->count();
            $i++;
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $slug = Str::slug($request->name);

        // Ensure slug is unique
        $existingSlugCount = Category::where('slug', $slug)->count();
        $originalSlug = $slug;
        $i = 1;
        while ($existingSlugCount > 0) {
            $slug = $originalSlug . '-' . $i;
            $existingSlugCount = Category::where('slug', $slug)->count();
            $i++;
        }
        
        $input['name'] = $request->name;
        $input['slug'] =  $slug;
        $category->update($input);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy_categories(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

}