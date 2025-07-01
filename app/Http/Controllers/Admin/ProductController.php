<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('firstImage')->orderBy('id','desc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $category = Category::latest()->get();
        $attribute = Attribute::latest()->get();
        return view('admin.products.create',compact(['category','attribute']));
    }

    public function getSubcategories($cat_id)
    {
        $subcategories = SubCategory::where('cat_id', $cat_id)->get();
        return response()->json($subcategories);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd("stop");
        $validated = $request->validate([
            'name' => 'required',
            'cat_id' => 'required',
            'sub_cat_id' => 'required',
            'description' => 'nullable|string',
            'price' => 'required',
            'reseller_price' => 'nullable',
            'long_desc' => 'nullable|string',
            // 'additional_info' => 'nullable|string',
            'shipping_info' => 'nullable|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp', // each file must be an image
        ]);
        // dd($validated['name']);
        
        $product = Product::create([
            'name' => $validated['name'],
            'cat_id' => $validated['cat_id'],
            'sub_cat_id' => $validated['sub_cat_id'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'reseller_price' => $validated['reseller_price'] ?? null,
            'long_desc' => $validated['long_desc'] ?? null,
            'shipping_info' => $validated['shipping_info'] ?? null,
        ]);
     
        $attributes = $request->input('attributes');
        foreach ($attributes as $attributeId => $values) {
            foreach ($values as $value) {
                AttributeValue::create([
                    'product_id' => $product->id,
                    'attribute_id' => $attributeId,
                    'value' => $value,
                ]);
            }
        }
    
        $imageData = [];
        foreach ($request->file('images') as $index => $image) {
          
            $originalSizeBytes = $image->getSize(); // bytes
            $originalSizeKB = $originalSizeBytes / 1024;
            //  Auto quality logic based on size
            $quality = 40;
            $imagePath = public_path('assets/images/demos/demo-2/products');
            $filenameBase = time() . '_' . rand(1000, 9999);
            $outputExtension = 'webp'; // Convert to WebP
            $outputFilename = $filenameBase . '.' . $outputExtension;
            $outputFullPath = $imagePath . '/' . $outputFilename;

            //  Compress + Convert to WebP
            $compressed = Image::make($image->getRealPath())
                ->resize(1500, null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })
                ->encode('webp', $quality); // compress & convert

            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0755, true);
            }
            $compressed->save($outputFullPath);
            
            $imageData[] = [
                'product_id' => $product->id,
                'path' => $outputFilename,
                'is_primary' => $index === 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert
        ProductImage::insert($imageData);
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::with('images')->find($id);
        return view('admin.products.edit', compact('product'));
    }
    
    public function show($id)
    {
        $product = Product::with('images')->find($id);
        return view('admin.products.show', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'reseller_price' => $request->reseller_price,
            'long_desc' => $request->long_desc,
            // 'additional_info' => $request->additional_info,
            'shipping_info' => $request->shipping_info,
        ]);

        if ($request->hasFile('images')) {
            // REMOVE IMAGE 
            $images = ProductImage::where('product_id', $product->id)->get();
            foreach ($images as $image) {
                $this->deleteImage($image->path);
                $image->delete(); // delete record
            }

            foreach ($request->file('images') as $index => $image) {              

                $originalSizeBytes = $image->getSize(); // bytes
                $originalSizeKB = $originalSizeBytes / 1024;

                //  Auto quality logic based on size
                $quality = 40;
                $imagePath = public_path('assets/images/demos/demo-2/products');
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
                
                $imageData[] = [
                    'product_id' => $product->id,
                    'path' => $outputFilename,
                    'is_primary' => $index === 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                // $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                // $image->move(public_path('assets/images/demos/demo-2/products'), $imageName);

                // ProductImage::create([
                //     'product_id' => $product->id,
                //     'path' => $imageName,
                //     'is_primary' => $index === 0,
                // ]);
            }
            // Bulk insert
            ProductImage::insert($imageData);
        }
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy_products($id)
    {
        $product = Product::where('id',$id)->first();
        
        $images = ProductImage::where('product_id', $id)->get();
        foreach ($images as $image) {
            $this->deleteImage($image->path);
            $image->delete(); // delete record
        }
        $product->delete();

        return response()->json(['message' => 'Item deleted successfully'], 200);
        // return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function removeImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $this->deleteImage($image->path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    protected function deleteImage($filename)
    {
        $path = 'public/assets/images/demos/demo-2/products/' . $filename;
        if (File::exists($path)) {
            File::delete($path);
        }
    }

}