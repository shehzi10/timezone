<?php

use App\Models\CartItems;
use App\Models\User;
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
        foreach ($cart_data as $key => $value) {
            $cart_data[$key]['cart_price'] = ($value['quantity'] * $value['price']);
        }

        return $cart_data;
    }
}
