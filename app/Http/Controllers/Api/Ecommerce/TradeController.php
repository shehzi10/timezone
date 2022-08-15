<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\TradeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;

class TradeController extends Controller
{
    public function storeTrade(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'brand_id'      =>      'required',
            'model_name'    =>      'required',

        ]);

        if ($validator->fails()) {
            return apiresponse(false, implode("\n", $validator->errors()->all()));
        }

        $data['user_id']            =       $request->user_id;
        $data['brand_id']           =       $request->brand_id;
        $data['name']               =       $request->name;
        $data['email']              =       $request->email;
        $data['phone']              =       $request->phone;
        $data['model_num']          =       $request->model_num;
        $data['model_name']         =       $request->model_name;
        $data['model_price']        =       $request->model_price;
        $data['model_condition']    =       $request->model_condition;
        $data['packing']            =       $request->packing;
        $data['comments']           =       $request->comments;

        $trade = Trade::create($data);

        if ($trade) {
            $validator = Validator::make($request->all(), [
                'images'    =>      'required',
            ]);
            if ($validator->fails()) return apiresponse(false, implode("\n", $validator->errors()->all()));
            if (isset($request->images) && $request->images != Null && count($request->images) > 0)
            // dd($request->images);
            {
                foreach ($request->file('images') as $image) {
                    $data['trade_id']       =       $trade->id;
                    $file                   =       $image;
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $featured_path      =   'public/images';
                    $file->move($featured_path, $fileName);
                    $data['image']   =   $fileName;

                    $images = TradeImage::create($data);
                }
            }
        }
        return apiresponse(true, 'Trade Request has been recorde successfully', $data);
    }
}
