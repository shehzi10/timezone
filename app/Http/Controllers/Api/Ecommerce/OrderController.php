<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CartItems;
use App\Models\Discount;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Product;
use App\Models\Vat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Order;
use Stripe\StripeClient;

class OrderController extends Controller
{
    public $stripe = "";
    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SK'));
    }

    public function placeOrder(Request $request)
    {
        try {
            $vat = Vat::get();
            $cartItems = $request->cartData;
            $orderItems = array();
            $order_id = rand(0000, 9999);
            $total_discount = 0;
            foreach ($cartItems as $item) {
                $discount_amount = 0;
                if ($item->discount_id != "") {
                    $dis = Discount::where('id', $item->discount_id)->first();
                    if ($dis->discount_type == 'percent') {
                        $discount_amount = ($item->price / 100) * $dis->discount_amount;
                    } else {
                        $discount_amount = $dis->discount_amount;
                    }
                }
                $orderItems[] = [
                    'user_id'           => $item->user_id,
                    'product_id'        => $item->product_id,
                    'quantity'          => $item->quantity,
                    'price'             => $item->price,
                    'order_id'          => $order_id,
                    'discount_id'       => ($discount_amount > 0) ? $dis->id : 0,
                    'discount_amount'   => $discount_amount,
                    'total_price'       => ($this->price - $discount_amount),
                ];
                $total_discount += $discount_amount;
            }
            OrderItems::insert($orderItems);

            $payment = $this->stripe->charges->create([
                "amount" => 100 * ($request->total),
                "currency" => "AED",
                "source" => $request->source_id,
                "customer" => $request->user()->stripe_customer_id,
                "description" => "TimeZone Order."
            ]);

            $order = Orders::create([
                'user_id'               => $request->user()->id,
                'order_id'              => $order_id,
                'payment_method_id'     => $request->source_id,
                'delivery_address_id'   =>  $request->delivery_address_id,
                'sub_total'             => $request->sub_total,
                'discount_amount'       => $total_discount,
                'vat_percent'           => $vat->vat_percent,
                'vat_amount'            => $request->tax,
                'total'                 => $request->total,
                'charge_id'             => $payment->id,
                'blc_transaction_id'    => $payment->balance_transaction,
            ]);

            return apiresponse(true, 'order places successfull',  $order);
            // return ['charge_id' => $charge_id, "transaction_id" => $blc_transaction];
        } catch (Exception $e) {
            return apiresponse("false", "error", $e->getMessage());
        }
    }

    // public function getOrders()
    // {
    //     $orders = Orders::leftjoin('orderI')->where('user_id', Auth::user()->id)->paginate(10)->toArray();
    //     foreach ($orders as $key => $value) {
    //         $orders[$key]['product_detail']
    //     }
    // }
}
