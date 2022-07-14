<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
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

        $product = Product::where('popular_watch', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $brand = Brand::where('top_brand', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $banner = Banners::where('banner_status', '1')->orderby('created_at', 'DESC')->get()->toArray();
        $category = Category::where('top_category', 1)->orderBY('created_at', 'DESC')->limit(10)->get()->toArray();
        $products = Product::orderBy('created_at', 'DESC')->limit(10)->get()->toArray();

        return apiresponse(true, 'Dashboard Data', ['popular_watches' => $product, 'top_brands' => $brand, 'banners' => $banner, 'top_categories' => $category, 'latest_watches' => $products]);
    }

    public function allBrands()
    {
        $brand = Brand::orderBY('created_at', 'DESC')->paginate(10)->toArray();
        return apiresponse(true, 'all brands', $brand);
    }

    public function allCategories()
    {
        $category = Category::orderBY('created_at', 'DESC')->paginate(10)->toArray();
        return apiresponse(true, 'all categories', $category);
    }

    public function allWatches($type)
    {
        $product = array();
        if ($type == 'popular') {
            $product = Product::where('popular_watch', 1)->orderBY('created_at', 'DESC')->paginate(10)->toArray();
        } else if ($type == 'latest') {
            $product = Product::orderBY('created_at', 'DESC')->paginate(10)->toArray();
        }
        return apiresponse(true, 'all watches data', $product);
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
        $products = Product::where('product_name', 'LIKE', '%' . $keyword . '%')->paginate(10)->toArray();
        return apiresponse(true, 'Search Result', $products);
    }
}
