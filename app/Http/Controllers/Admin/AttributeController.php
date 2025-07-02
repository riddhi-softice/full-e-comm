<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::latest()->get();
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    { 
        return view('admin.attributes.create');
    }
   
    public function store(Request $request)
    {
        // Validate name and generate slug
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute = Attribute::create([
            'name' => $request->name,
        ]);

        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully.');
    }
    
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $input['name'] = $request->name;
        $attribute->update($input);

        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy_attributes(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully.');
    }
    
}