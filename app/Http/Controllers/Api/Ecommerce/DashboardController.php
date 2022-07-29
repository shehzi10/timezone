<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Banners;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashBoard()
    {
        $product = Product::where('popular_watch', 1)->with(['category', 'brand', 'color'])->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $brand = Brand::where('top_brand', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $banner = Banners::where('banner_status', '1')->orderby('created_at', 'DESC')->get()->toArray();
        $category = Category::where('top_category', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $products = Product::orderBy('created_at', 'DESC')->limit(10)->get()->toArray();

        return apiresponse(true, 'Dashboard Data', ['popular_watches' => $product, 'top_brands' => $brand, 'banners' => $banner, 'top_categories' => $category, 'latest_watches' => $products]);
    }

    public function allBrands($search = "")
    {
        $brand = array();
        if ($search == "") {
            $brand = Brand::orderBY('created_at', 'DESC')->get()->toArray();
        } else {
            $brand = Brand::where('brand_name', 'LIKE', '%' . $search . '%')->orderBY('created_at', 'DESC')->get()->toArray();
        }
        return apiresponse(true, 'all brands', $brand);
    }

    public function allCategories($search = "")
    {
        $category = array();
        if ($search == "") {
            $category = Category::orderBY('created_at', 'DESC')->get()->toArray();
        } else {
            $category = Category::where('category_name', 'LIKE', '%' . $search . '%')->orderBY('created_at', 'DESC')->get()->toArray();
        }
        return apiresponse(true, 'all categories', $category);
    }

    public function allWatches(Request $request)
    {
        $product = array();
        if(isset($request->search))
        {
            if(isset($request->type))
            {
                if ($request->type == 'popular') {
                    $base_product = Product::where('popular_watch', 1)->with(['brand', 'category', 'color']);
                    if(isset($request->search )){
                        $base_product = $base_product->where('product_name', 'LIKE', $request->search. '%' );
                    }
                    if(isset($request->search )){
                        $base_product = $base_product->where('gender', 'LIKE', $request->search. '%' );
                    }
                    $product = $base_product->orderBY('created_at', 'DESC')->simplePaginate(10)->toArray();
                } else if ($request->type == 'latest') {
                    $product = Product::with(['color', 'category', 'brand'])->where('product_name', 'LIKE', $request->search. '%' )->orderBY('created_at', 'DESC')->simplePaginate(10)->toArray();
                }
            }
            else{
                $product = Product::with(['brand', 'category', 'color'])->where('product_name', 'LIKE', $request->search. '%' )->orderBy('created_at', 'DESC')->simplePaginate(10);
            }
        }
        else
        {
            if(isset($request->type))
            {
                if ($request->type == 'popular') {
                    $product = Product::where('popular_watch', 1)->with(['color', 'category', 'brand'])->orderBY('created_at', 'DESC')->simplePaginate(10)->toArray();
                } else if ($request->type == 'latest') {
                    $product = Product::with(['color', 'category', 'brand'])->orderBY('created_at', 'DESC')->simplePaginate(10)->toArray();
                }
            }
            else{
                $product = Product::with(['color', 'category', 'brand'])->orderBy('created_at', 'DESC')->simplePaginate(10);
            }
        }
        return apiresponse(true, 'All watches found', $product);
    }

    public function watchDetail($watch_id)
    {
        $products = Product::where('id', $watch_id)->get()->toArray();
        if (!empty($products)) {
            $media = ProductMedia::where('product_id', $watch_id)->get()->toArray();
            $images = $videos = array();

            if (!empty($media)) {
                foreach ($media as $value) {
                    $type = explode('.', $value['media']);
                    if (['mp4', 'mkv', 'wmv', '3gp'] . include($type)) {
                        $videos[] = $value;
                    } else {
                        $images[] = $value;
                    }
                }
                $products['videos'] = $videos;
                $products['images'] = $images;
            } else {
                $products['videos'] = $videos;
                $products['images'] = $images;
            }
            return apiresponse(true, 'watch detail', $products);
        }
        return apiresponse(false, 'no watch found');
    }

    public function search($keyword)
    {
        $products = Product::where('product_name', 'LIKE', '%' . $keyword . '%')->simplePaginate(10)->toArray();
        return apiresponse(true, 'Search Result', $products);
    }

    public function addAddress(Request $request)
    {
        Address::create([
            'user_id'           => $request->user()->id,
            'delivery_address'  =>  $request->address,
        ]);
        return apiresponse(true, 'Address added successfully', Address::where('user_id', $request->user()->id)->get()->toArray());
    }


    public function topCategoryProducts(){
        $category = Category::with('products')->where("top_category","1")->orderBy('created_at', 'DESC')->get();
        // Product::with(['category', 'brand', 'color'])->whereHas('category', function($query){
        //     $query->where('top_category', '1');
        // })->orderBy('created_at', 'DESC')->get();
        return apiresponse(true, 'Top categories found', $category);
    }
}
