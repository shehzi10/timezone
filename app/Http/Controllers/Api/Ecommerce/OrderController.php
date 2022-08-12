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
        $this->stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
    }

    public function placeOrder(Request $request)
    {
        try {
            $vat = Vat::first();
            $cartItems = $request->cartData;
            $orderItems = array();
            $order_id = rand(0000, 9999);
            $total_discount = 0;
            foreach ($cartItems as $item) {
                $orderItems[] = [
                    'user_id'           => $request->user()->id,
                    'product_id'        => $item['product_id'],
                    'price'             => $item['price'],
                    'order_id'          => $order_id,
                    'discount_amount'   => $item['discount_amount'],
                    'total_price'       => $item['product_total'],
                ];
                $total_discount += $item['discount_amount'];
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
                'address'               => $request->address,
                'sub_total'             => $request->sub_total,
                'discount_amount'       => $total_discount,
                'vat_percent'           => $vat->vat_percent,
                'vat_amount'            => $request->tax_amount,
                'total'                 => $request->total,
                'charge_id'             => $payment->id,
                'blc_transaction_id'    => $payment->balance_transaction,
            ]);

            return apiresponse(true, 'order places successfull',  $order);
        } catch (Exception $e) {
            return apiresponse(false, "error", $e->getMessage());
        }
    }

    public function ordersHistory()
    {
        $orders = Orders::where('user_id', Auth::user()->id)->paginate(10);
        foreach ($orders as $key => $value) {
            $orders[$key]['order_detail'] = OrderItems::where('order_id', $value->order_id)->get();
            foreach ($orders[$key]['order_detail'] as $oKey => $oValue) {
                $orders[$key]['order_detail'][$oKey]['product_detail'] = Product::where('id', $oValue->product_id)->first();
            }
        }
        return apiresponse(true, 'Order History', $orders);
    }
}
