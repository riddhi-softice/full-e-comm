<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favourite;

class CommonController extends Controller
{
    public function addToFavourite(Request $request, $productId)
    {
        $uid = auth()->id();
        $cartItem = Favourite::where('user_id', $uid)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Favourite::create([
                'user_id' => $uid,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }
        return redirect()->back()->with('success', 'Product added to Favourite!');
    }
}