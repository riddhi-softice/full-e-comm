<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use DB;

class ProductController extends Controller
{
    public function new()
    {
        // Step 1: Detect user's country
        $ip = request()->ip();
        $country = 'Unknown';

        try {
            $response = Http::timeout(1)->get("http://ip-api.com/json/{$ip}?fields=status,country");
            if ($response->ok() && $response['status'] === 'success') {
                $country = $response['country'];
            }
        } catch (\Exception $e) {
            // Optional: log or ignore
        }
        $isIndia = strtolower($country) === 'india';

        // Step 2: Get USD conversion rate from common_settings
        $usdRate = DB::table('common_settings')->where('setting_key', 'USD_price')->value('setting_value');
        $usdRate = floatval($usdRate); // Ensure it's numeric

        // Get products and modify price if not in India
        // Step 3: Fetch products and apply price conversion if needed
        $products = Product::with('images')->latest()->take(8)->get()->map(function ($product) use ($isIndia, $usdRate) {
            $product->display_price = $isIndia ? $product->price : $product->price * $usdRate;
            return $product;
        });
        
        $data['all_products'] = $products;
        $data['country'] = $country; // Optional: show country on frontend

        return view('web.index', compact('data'));
    }

    public function home_page()
    { 
        // Step 1: Detect user's country
        $ip = request()->ip();
        $country = 'Unknown';
        try {
            $response = Http::timeout(1)->get("http://ip-api.com/json/{$ip}?fields=status,country");
            if ($response->ok() && $response['status'] === 'success') {
                $country = $response['country'];
            }
        } catch (\Exception $e) {
            // Optional: log or ignore
        }
        // dd($country);
        $isIndia = strtolower($country) === 'india';

        // Step 2: Get USD conversion rate from common_settings
        $usdRate = DB::table('common_settings')->where('setting_key', 'USD_price')->value('setting_value');
        $usdRate = floatval($usdRate); // Ensure it's numeric

        // Get products and modify price if not in India
        // Step 3: Fetch products and apply price conversion if needed
        $products = Product::with('images')->latest()->take(8)->get()->map(function ($product) use ($isIndia, $usdRate) {
            $product->display_price = $isIndia ? $product->price * $usdRate : $product->price;
            return $product;
        });

        $data['brands'] = DB::table('brands')->get(); 
        $data['categories'] = Category::with(['products.images'])->get();
        $data['all_products'] = $products;
        $data['country'] = $country; // Optional: show country on frontend

        return view('web.index', compact('data'));
        // $data['all_products'] = Product::with('images')->latest()->take(8)->get();
        // return view('web.index', compact('data'));
    }
  
    public function more_product()
    {
        // Step 1: Detect user's country
        $ip = request()->ip();
        $country = 'Unknown';
        try {
            $response = Http::timeout(1)->get("http://ip-api.com/json/{$ip}?fields=status,country");
            if ($response->ok() && $response['status'] === 'success') {
                $country = $response['country'];
            }
        } catch (\Exception $e) {
            // Optional: log or ignore
        }
        // dd($country);
        $isIndia = strtolower($country) === 'india';

        // Step 2: Get USD conversion rate from common_settings
        $usdRate = DB::table('common_settings')->where('setting_key', 'USD_price')->value('setting_value');
        $usdRate = floatval($usdRate); // Ensure it's numeric

        // Get products and modify price if not in India
        // Step 3: Fetch products and apply price conversion if needed
        $products = Product::with('images')
                    ->latest()->paginate(12)
                    ->through(function ($product) use ($isIndia, $usdRate) {
                        $product->display_price = $isIndia ? $product->price * $usdRate : $product->price;
                        return $product;
                    });

        $data['all_products'] = $products;
        $data['country'] = $country; // Optional: show country on frontend

        return view('web.more_product', compact('data'));
        // $data['all_products'] = Product::with('images')->latest()->paginate(12); 
        // return view('web.more_product', compact('data'));
    }
  
    public function details_page($id)
    { 
        // Step 1: Detect user's country
        $ip = request()->ip();
        $country = 'Unknown';
        try {
            $response = Http::timeout(1)->get("http://ip-api.com/json/{$ip}?fields=status,country");
            if ($response->ok() && $response['status'] === 'success') {
                $country = $response['country'];
            }
        } catch (\Exception $e) {
        }
        $isIndia = strtolower($country) === 'india';

        // Step 2: Get USD conversion rate from common_settings
        $usdRate = DB::table('common_settings')->where('setting_key', 'USD_price')->value('setting_value');
        $usdRate = floatval($usdRate); // Ensure it's numeric

        // $product = Product::with(['images'])->findOrFail($id);
        $product = Product::with(['images','category', 'attributeValues.attribute','reviews.user', 'relatedProducts.firstImage', 'relatedProducts.reviews' => function ($q) {
            $q->select('id', 'product_id', 'rating');
        }])->withCount('reviews')->withAvg('reviews', 'rating')->findOrFail($id);

        $product->rating = round($product->reviews_avg_rating ?? 0, 1);
        $product->display_price = $isIndia ? $product->price * $usdRate : $product->price;
        $product->reseller_display_price = $isIndia ? $product->reseller_price * $usdRate : $product->reseller_price;

        $attributeGroups = [];
        foreach ($product->attributeValues as $attVal) {
            $attributeGroups[$attVal->attribute->name][] = $attVal->value;
        }
        // dd($attributeGroups);
        return view('web.product_detail', compact('product','country','attributeGroups'));
    }

}