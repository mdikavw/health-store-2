<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::create($validate);

        return redirect()->route('user.cart', ['user' => Auth::user(), 'product' => Product::find($validate['product_id'])])->with('success', $cartItem->product->name . ' added successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cartItem = CartItem::find($request->id);
        if (!$cartItem)
        {
            return redirect()->route('user.cart', ['user' => Auth::user()])
                ->with('error', 'Cart item not found.');
        }
        $cartItem->delete();

        return redirect()->route('user.cart', ['user' => Auth::user()])->with('success', $cartItem->product->name . ' deleted successfully');
    }
}
