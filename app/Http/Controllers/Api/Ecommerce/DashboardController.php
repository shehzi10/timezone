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
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashBoard()
    {
        $product = Product::where('popular_watch', 1)->with(['category', 'brand', 'color'])->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $brand = Brand::where('top_brand', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $banner = Banners::where('banner_status', '1')->orderby('created_at', 'DESC')->get()->toArray();
        $category = Category::where('top_category', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $products = Product::orderBy('created_at', 'DESC')->limit(10)->get()->toArray();

        foreach ($product as $key => $watch) {
            $media = ProductMedia::where('product_id', $watch['id'])->get()->toArray();
            $images = $videos = array();
            if (!empty($media)) {
                foreach ($media as $value) {
                    $type = explode('.', $value['media']);
                    if (in_array($type[1], ['mp4', 'mkv', 'wmv', '3gp'])) {
                        $videos[] = $value;
                    } else {
                        $images[] = $value;
                    }
                }
                $product[$key]['videos'] = $videos;
                $product[$key]['images'] = $images;
            } else {
                $product[$key]['videos'] = $videos;
                $product[$key]['images'] = $images;
            }
        }

        foreach ($products as $key => $watch) {
            $media = ProductMedia::where('product_id', $watch['id'])->get()->toArray();
            $images = $videos = array();
            if (!empty($media)) {
                foreach ($media as $value) {
                    $type = explode('.', $value['media']);
                    if (in_array($type[1], ['mp4', 'mkv', 'wmv', '3gp'])) {
                        $videos[] = $value;
                    } else {
                        $images[] = $value;
                    }
                }
                $products[$key]['videos'] = $videos;
                $products[$key]['images'] = $images;
            } else {
                $products[$key]['videos'] = $videos;
                $products[$key]['images'] = $images;
            }
        }

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
        $where = array();
        $order = "";

        if (isset($request->filter_sort)) {
            if ($request->filter_sort == 'popular') {
                $where[] = array("popular_watch", '1');
            } elseif ($request->filter_sort == 'latest') {
                $order = "created_at DESC";
            } elseif ($request->filter_sort == 'lowToHigh') {
                $order = "price ASC";
            }
        }

        if (isset($request->filter_gender)) {
            $where[] = array("gender", $request->filter_gender);
        }

        if (isset($request->filter_color)) {
            $where[] = array("color_id", $request->filter_color);
        }

        if (isset($request->filter_availability)) {
            $where[] = array("availability", $request->filter_availability);
        }

        if (isset($request->filter_brand)) {
            $where[] = array("brand_id", $request->filter_brand);
        }
        if (isset($request->filter_category)) {
            $where[] = array("color_id", $request->filter_category);
        }

        if (isset($request->search)) {
            if (isset($request->type)) {
                if ($request->type == 'popular') {
                    $base_product = Product::where('popular_watch', 1)->where($where)->with(['brand', 'category', 'color', 'discount']);
                    if (isset($request->search)) {
                        $base_product = $base_product->where('product_name', 'LIKE', $request->search . '%');
                    }
                    if (isset($request->search)) {
                        $base_product = $base_product->where('gender', 'LIKE', $request->search . '%');
                    }
                    if ($order != "") {
                        $product = $base_product->orderBYRaw(DB::raw($order))->simplePaginate(10)->toArray();
                    } else {
                        $product = $base_product->simplePaginate(10)->toArray();
                    }
                } else if ($request->type == 'latest') {
                    $product = Product::with(['color', 'category', 'brand', 'discount'])->where('product_name', 'LIKE', $request->search . '%')->orderBY('created_at', 'DESC')->simplePaginate(10)->toArray();
                }
            } else {
                if ($order != "") {
                    $product = Product::with(['brand', 'category', 'color', 'discount'])->where('product_name', 'LIKE', $request->search . '%')->where($where)->orderByRaw(DB::raw($order))->simplePaginate(10);
                } else {
                    $product = Product::with(['brand', 'category', 'color', 'discount'])->where('product_name', 'LIKE', $request->search . '%')->where($where)->simplePaginate(10);
                }
            }
        } else {
            if (isset($request->type)) {
                if ($request->type == 'popular') {
                    $product = Product::where('popular_watch', 1)->with(['color', 'category', 'brand', 'discount'])->simplePaginate(10)->toArray();
                } else if ($request->type == 'latest') {
                    $product = Product::with(['color', 'category', 'brand', 'discount'])->orderBY('created_at', 'DESC')->simplePaginate(10)->toArray();
                }
            } else {
                if ($order != "") {
                    $product = Product::where($where)->with(['color', 'category', 'brand', 'discount'])->orderByRaw(DB::raw($order))->simplePaginate(10);
                } else {
                    $product = Product::where($where)->with(['color', 'category', 'brand', 'discount'])->simplePaginate(10);
                }
            }
        }
        foreach ($product as $key => $watch) {
            $media = ProductMedia::where('product_id', $watch->id)->get()->toArray();
            $images = $videos = array();
            if (!empty($media)) {
                foreach ($media as $value) {
                    $type = explode('.', $value['media']);
                    if (in_array($type[1], ['mp4', 'mkv', 'wmv', '3gp'])) {
                        $videos[] = $value;
                    } else {
                        $images[] = $value;
                    }
                }
                $product[$key]['videos'] = $videos;
                $product[$key]['images'] = $images;
            } else {
                $product[$key]['videos'] = $videos;
                $product[$key]['images'] = $images;
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


    public function topCategoryProducts()
    {
        $category = Category::with('products')->where("top_category", "1")->orderBy('created_at', 'DESC')->get();
        // Product::with(['category', 'brand', 'color'])->whereHas('category', function($query){
        //     $query->where('top_category', '1');
        // })->orderBy('created_at', 'DESC')->get();
        return apiresponse(true, 'Top categories found', $category);
    }
}
