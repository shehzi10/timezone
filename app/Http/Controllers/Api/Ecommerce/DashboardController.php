<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashBoard(){

        $product = Product::where('popular_watch', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $brand = Brand::where('top_brand', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $category = Category::where('top_category', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $products = Product::orderBy('created_at', 'DESC')->limit(10)->get()->toArray();

        return apiresponse(true, 'Dashboard Data', ['popular_watches'=>$product, 'top_brands'=>$brand, 'top_categories'=>$category, 'latest_watches'=>$products]);

    }
}
