<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id'       =>  'required',
            'product_id'    =>  'required',
        ]);
        if ($validator->fails()) {
            return apiresponse(false, implode("\n", $validator->errors()->all()));
        }
        $check = Wishlist::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->get()->toArray();
        if (!empty($check)) {
            Wishlist::where('id', $check->id)->delete();
            return apiresponse(true, 'Product removed from wishlist successfully');
        } else {
            $wishlist = new Wishlist();

            $wishlist->user_id      =       auth()->user()->id;
            $wishlist->product_id   =       $request->product_id;


            $wishlist->save();


            if ($wishlist) {
                return apiresponse(true, 'Product added to wishlist successfully', $wishlist);
            } else {
                return apiresponse(false, 'Some error occured');
            }
        }
    }
}
