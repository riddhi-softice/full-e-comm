<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    { 
        return view('admin.brands.create');
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required',
        ]);
        
        $imageName = "";
        if ($request->file('logo')) {   
            
            $image = $request->file('logo');   
            // $destinationPath = public_path('assets/images/brands');
            // $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            // $image->move($destinationPath, $imageName); 

            $originalSizeBytes = $image->getSize(); // bytes
            $originalSizeKB = $originalSizeBytes / 1024;
            //  Auto quality logic based on size
            $quality = 40;
            $imagePath = public_path('assets/images/brands');
            $filenameBase = time() . '_' . rand(1000, 9999);
            $outputExtension = 'webp'; // Convert to WebP
            $outputFilename = $filenameBase . '.' . $outputExtension;
            $outputFullPath = $imagePath . '/' . $outputFilename;

            //  Compress + Convert to WebP
            $compressed = Image::make($image->getRealPath())
                // ->orientate()
                ->resize(1500, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                }); // optional resize
                // ->encode('webp', $quality); // compress & convert

            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0755, true);
            }
            $compressed->save($outputFullPath);
        }
        $brand = Brand::create([
            'name' => $request->name,
            'logo' => $imageName
        ]);
        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }
    
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $input['name'] = $request->name;
        $brand->update($input);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy_brands(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }

}