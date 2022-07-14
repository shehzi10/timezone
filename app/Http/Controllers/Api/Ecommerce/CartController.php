<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CartItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user = Auth::user();
        $cart_id = "";

        $previous_data = CartItems::where('user_id', $user->id)->get()->toArray();

        if (empty($previous_data)) {
            $cart_id = rand(00000, 99999);
        } else {
            $cart_id = $previous_data[0]['cart_id'];
        }

        $data = [
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'quantity'  =>  $request->qty,
            'cart_id'   =>  $cart_id
        ];

        CartItems::create($data);

        $current_data = cartData($user);
        return apiresponse(true, 'item add to cart successfully', $current_data);
    }

    public function updateCart(Request $request)
    {
        $user = Auth::user();

        $previous_data = CartItems::where(['user_id' => $user->id, 'product_id' => $request->product_id])->first();

        if ($request->qty > 0) {
            $previous_data->quantity = $request->qty;
            $previous_data->save();
        } else {
            CartItems::where(['user_id' => $user->id, 'product_id' => $request->product_id])->delete();
        }

        $current_data = cartData($user);
        return apiresponse(true, 'cart updated successfully', $current_data);
    }

    public function removeFromCart(Request $request)
    {
        $user = Auth::user();

        CartItems::where(['user_id' => $user->id, 'product_id' => $request->product_id])->delete();

        $current_data = cartData($user);
        return apiresponse(true, 'cart updated successfully', $current_data);
    }
}
