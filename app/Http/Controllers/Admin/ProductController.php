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
use App\Models\Brand;
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
        $brand = Brand::latest()->get();
        return view('admin.products.create',compact(['category','attribute','brand']));
    }

    public function getSubcategories($cat_id)
    {
        $subcategories = SubCategory::where('cat_id', $cat_id)->latest()->get();
        return response()->json($subcategories);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd("stop");
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string',
            'price'            => 'required|numeric|min:0',
            'reseller_price'   => 'required|numeric|min:0',
            'long_desc'        => 'required|string',
            'shipping_info'    => 'required|string',
            'cat_id'           => 'required|integer|exists:categories,id',
            'sub_cat_id'       => 'required|integer|exists:sub_categories,id',
            'brand_id'       => 'required|integer|exists:brands,id',
            'images'           => 'required|array|min:1',
            'images.*'         => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            // Validate attribute values
            'attributes'       => 'required|array|min:1',
            'attributes.*'     => 'required|array',
            'attributes.*.*.value' => 'required|string',
            'attributes.*.*.price' => 'required|numeric|min:0',
        ], [
            // Custom error messages
            'name.required'             => 'Product name is required.',
            'description.required'      => 'Short description is required.',
            'price.required'            => 'Sale price is required.',
            'reseller_price.required'   => 'Product price is required.',
            'long_desc.required'        => 'Long description is required.',
            'shipping_info.required'    => 'Shipping info is required.',
            'cat_id.required'           => 'Category is required.',
            'sub_cat_id.required'       => 'Subcategory is required.',
            'brand_id.required'         => 'Brand is required.',
            'images.required'           => 'Please upload at least one product image.',
            'images.*.image'            => 'Each uploaded file must be an image.',
            'images.*.mimes'            => 'Images must be in jpeg, png, jpg, or webp format.',
            'images.*.max'              => 'Each image must not exceed 2MB.',
            'attributes.required'       => 'At least one attribute is required.',
            'attributes.*.required'     => 'Each attribute must have values.',
            'attributes.*.*.value.required' => 'Attribute value is required.',
            'attributes.*.*.price.required' => 'Attribute price is required.',
        ]);
        // dd($validated['name']);
        
        $product = Product::create([
            'name' => $validated['name'],
            'cat_id' => $validated['cat_id'],
            'brand_id' => $validated['brand_id'] ?? 0,
            'sub_cat_id' => $validated['sub_cat_id'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'reseller_price' => $validated['reseller_price'] ?? null,
            'long_desc' => $validated['long_desc'] ?? null,
            'shipping_info' => $validated['shipping_info'] ?? null,
        ]);
     
        // ATTRIBUTE ONLY VALUE STORE
        // $attributes = $request->input('attributes');
        // foreach ($attributes as $attributeId => $values) {
        //     foreach ($values as $value) {
        //         AttributeValue::create([
        //             'product_id' => $product->id,
        //             'attribute_id' => $attributeId,
        //             'value' => $value,
        //             'price' => $value,
        //         ]);
        //     }
        // }
        
        // ATTRIBUTE VALUE AND PRICE STORE
        $attributes = $request->input('attributes');
        foreach ($attributes as $attributeId => $items) {
            foreach ($items as $item) {
                AttributeValue::create([
                    'product_id'    => $product->id,
                    'attribute_id'  => $attributeId,
                    'value'         => $item['value'],
                    'price'         => $item['price'],
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
        $category = Category::latest()->get();
        $subcategories = SubCategory::where('cat_id', $product->cat_id)->latest()->get();
        $brand = Brand::latest()->get();
        $attribute = Attribute::latest()->get();
        $attributeValues = AttributeValue::where('product_id', $product->id)
                        ->get()->groupBy('attribute_id')
                        ->map(function ($group) {
                            return $group->map(function ($item) {
                                return [
                                    'value' => $item->value,
                                    'price' => $item->price,
                                ];
                            })->toArray();
                        });
        
        return view('admin.products.edit', compact('product','category','brand','attribute','subcategories','attributeValues'));
    }
    
    public function show($id)
    {
        $product = Product::with(['images','category','subCategory','brand','attributeValues.attribute'])->find($id);
        return view('admin.products.show', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'reseller_price' => $request->reseller_price,
            'cat_id' => $request->cat_id,
            'sub_cat_id' => $request->sub_cat_id,
            'brand_id' => $request->brand_id ?? 0,
            // 'additional_info' => $request->additional_info,
            'long_desc' => $request->long_desc,
            'shipping_info' => $request->shipping_info,
        ]);

        // ATTRIBUTE VALUE AND PRICE STORE
        $attributes = $request->input('attributes');
        if($attributes){
            AttributeValue::where('product_id',$product->id)->delete();

            foreach ($attributes as $attributeId => $items) {
                foreach ($items as $item) {
                    AttributeValue::create([
                        'product_id'    => $product->id,
                        'attribute_id'  => $attributeId,
                        'value'         => $item['value'],
                        'price'         => $item['price'],
                    ]);
                }
            }
        }
              
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
                    ->resize(1500, null, function ($c) {
                        $c->aspectRatio();
                        $c->upsize();
                    }) // optional resize
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