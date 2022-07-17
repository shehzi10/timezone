<?php

use App\Models\CartItems;
use App\Models\Discount;
use App\Models\User;
use App\Models\Vat;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

if (!function_exists('apiresponse')) {
    /**
     * @param boolean $status
     * @param string $msg
     * @param array|null $data
     * @param integer $http_status
     * @return \Illuminate\Http\JsonResponse
     */
    function apiresponse($status, $msg, $data = null, $http_status = 200)
    {
        return response()->json(['success' => $status, 'message' => $msg, 'data' => $data], $http_status);
    }
}


if (!function_exists('SendNotification')) {
    /**
     * Send Notification to Device
     * @param string $device_id
     * @param string $title
     * @param string $body
     * @param null $data
     */
    function SendNotification($device_id, $title, $body, $data = null)
    {
        try {
            if ($device_id) {
                $factor = (new Factory())->withServiceAccount('firebase.json');
                $messaging = $factor->createMessaging();
                $message = CloudMessage::withTarget('token', $device_id)
                    ->withNotification(Notification::create($title, $body));
                if ($data) {
                    $message->withData($data);
                }
                $messaging->send($message);
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('cartData')) {
    function cartData($user)
    {
        $cart_data = CartItems::leftjoin('products', 'products.id', 'cart_items.product_id')
            ->where('cart_items.user_id', $user->id)->get()->toArray();
        $grand_total = $sub_total = 0;
        foreach ($cart_data as $key => $value) {
            $price = $value->price * $value->quantity;
            $total = $discount_amount = 0;
            if ($value->discount_id > 0) {
                $dis = Discount::where('id', $value->discount_id)->first();
                if ($dis->discount_type == 'percent') {
                    $discount_amount = ($price / 100) * $dis->discount_amount;
                } else {
                    $discount_amount = $dis->discount_amount;
                }
                $total = $price - $discount_amount;
            }
            $cart_data[$key]['cart_price'] = ($value['quantity'] * $value['price']);
            $cart_data[$key]['cart_total'] = ($total > 0) ? $total : $price;
            $grand_total += $cart_data[$key]['cart_total'];
            $sub_total += $cart_data[$key]['cart_price'];
        }
        $vat = Vat::first();
        $cart_data['vat_percent'] = $vat->percent;
        $cart_data['vat_amount']  = ($grand_total / 100) * $cart_data['vat_percent'];
        $cart_data['grand_total'] = $grand_total;
        $cart_data['sub_total'] = $sub_total;
        $cart_data['grand_total_after_vat'] = $grand_total - $cart_data['vat_amount'];
        return $cart_data;
    }
}
