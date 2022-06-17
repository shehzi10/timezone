<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function product(){
        return view('admin.products.index');
    }


    public function addProduct(){

        $brand  =   Brand::get();
        $cate   =   Category::get();
        $color  =   Color::get();
        return view('admin.products.add-product', ['brands'=>$brand, 'cats'=>$cate, 'colors'=>$color]);
    }

    public function storeProduct(Request $request){
        $validator = Validator::make($request->all(),[
            'name'      =>  'required',
            'price'     =>  'required',
        ]);
        if($validator->fails()){
            session()->flash('error', implode("\n", $validator->errors()->all()));
        }

        $product = new Product();


    }
}
