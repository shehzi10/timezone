<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CartItems;
use App\Models\Discount;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
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

            $cartItems = CartItems::where('user_id', $request->user()->id)->get();
            $orderItems = array();
            foreach ($cartItems as $item) {
                $prd = Product::where('id', $item->product_id)->first();
                $price = $prd->price * $item->quantity;
                $total = $discount_amount = 0;
                if ($item->discount_id > 0) {
                    $dis = Discount::where('id', $item->discount_id)->first();
                    if ($dis->discount_type == 'percent') {
                        $discount_amount = ($price / 100) * $dis->discount_amount;
                    } else {
                        $discount_amount = $dis->discount_amount;
                    }
                    $total = $price - $discount_amount;
                }
                $orderItems[] = [
                    'user_id'           => $item->user_id,
                    'product_id'        => $item->product_id,
                    'quantity'          => $item->quantity,
                    'price'             => $price,
                    'order_id'          => $item->cart_id,
                    'discount_id'       => ($discount_amount > 0) ? $dis->id : 0,
                    'discount_amount'   => $discount_amount,
                    'total_price'       => ($total > 0) ? $total : $price,
                ];
            }
            OrderItems::insert($orderItems);
            $order = Orders::create([
                'user_id' => $request->user()->id,
                'order_id' => $cartItems[0]->cart_id,
                'payment_method_id' =>  $request->payment_stripe_id,
                'sub_total'         =>  $request->sub_total,
            ]);
            $payment = $this->stripe->charges->create([
                "amount" => 100 * ($request->total),
                "currency" => "AED",
                "source" => $request->source_id,
                "customer" => $request->user()->stripe_customer_id,
                "description" => "TimeZone Order."
            ]);

            $order_detail['charge_id'] = $payment->id;
            $order_detail['blc_transaction'] = $payment->balance_transaction;

            return apiresponse(true, 'order places successfull', $order_detail);
            // return ['charge_id' => $charge_id, "transaction_id" => $blc_transaction];
        } catch (Exception $e) {
            return apiresponse("false", "error", $e->getMessage());
        }
    }
}
