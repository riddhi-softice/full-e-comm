<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCart()
    {
        $uid = auth()->id();
        $cartItems = CartItem::with('product.firstImage')->where('user_id', $uid)->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        return view('web.product_cart', compact('cartItems', 'subtotal'));
    }
    
    public function addToCart(Request $request, $productId)
    {
        $uid = auth()->id();
        $cartItem = CartItem::where('user_id', $uid)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'user_id' => $uid,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function updateCart(Request $request)
    {
        $uid = auth()->id();
        foreach ($request->quantities as $id => $qty) {
            CartItem::where('id', $id)->where('user_id',$uid)->update(['quantity' => max(1, (int)$qty)]);
        }
        return response()->json(['success' => true, 'message' => 'Cart updated successfully.']);
        // return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function removeItem($id)
    {
        $uid = auth()->id();
        $cartItem = CartItem::where('id', $id)->where('user_id', $uid)->first();
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
        }
        return redirect()->route('cart.index')->with('error', 'Item not found.');
    }

}
