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
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
        ]);
    
        $outputFilename = '';
            if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $originalSizeBytes = $image->getSize();
            $originalSizeKB = $originalSizeBytes / 1024;
    
            // Dynamic quality based on size (optional)
            $quality = 40; // Default quality for WebP
    
            $imagePath = public_path('assets/images/brands');
            $filenameBase = time() . '_' . rand(1000, 9999);
            $outputExtension = 'webp';
            $outputFilename = $filenameBase . '.' . $outputExtension;
            $outputFullPath = $imagePath . '/' . $outputFilename;
    
            // Make directory if it doesn't exist
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0755, true);
            }
    
            // Process and save the image as WebP
            Image::make($image->getRealPath())
                ->resize(1500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', $quality)
                ->save($outputFullPath);
        }
    
        // Save to database
        Brand::create([
            'name' => $request->name,
            'logo' => $outputFilename,
        ]);
        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }
    
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $outputFilename = '';
        if ($request->hasFile('logo')) {

            // REMOVE IMAGE 
            $this->deleteImage($brand->logo);

            $image = $request->file('logo');
            $originalSizeBytes = $image->getSize();
            $originalSizeKB = $originalSizeBytes / 1024;
            // Dynamic quality based on size (optional)
            $quality = 40; // Default quality for WebP
            $imagePath = public_path('assets/images/brands');
            $filenameBase = time() . '_' . rand(1000, 9999);
            $outputExtension = 'webp';
            $outputFilename = $filenameBase . '.' . $outputExtension;
            $outputFullPath = $imagePath . '/' . $outputFilename;
            // Make directory if it doesn't exist
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0755, true);
            }
            // Process and save the image as WebP
            Image::make($image->getRealPath())
                    ->resize(1500, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('webp', $quality)
                    ->save($outputFullPath);
        }
        $input['name'] = $request->name;
        $brand->update($input);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy_brands(Brand $brand)
    {
        // REMOVE IMAGE 
        $this->deleteImage($brand->logo);
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }

    protected function deleteImage($filename)
    {
        $path = 'public/assets/images/brands/' . $filename;
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}