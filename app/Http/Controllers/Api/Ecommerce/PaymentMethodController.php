<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethods;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\StripeClient;

class PaymentMethodController extends Controller
{
    public $stripe = "";

    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
    }

    public function addPaymentMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required',
            'exp_date' => 'required',
            'cvc' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => implode("\n", $validator->errors()->all())]);
        }

        try {
            $user = $request->user();
            $date = explode("/", $request->exp_date);

            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $date[0],
                    'exp_year' => $date[1],
                    'cvc' => $request->cvc,
                ],
            ]);

            $stripe_customer_id = $user->stripe_customer_id;
            $stripeCustomer = $this->stripe->customers->retrieve($stripe_customer_id);
            // return response()->json(["status" => "error", "data" => $stripeCustomer]);
            $willBeDefault = ($stripeCustomer->default_source == null) ? '1' : '0';
            $source = $this->stripe->customers->createSource($stripe_customer_id, [
                'source' => $token
            ]);
            //                echo"<pre>"; print_r($token); die();
            if ($willBeDefault == '1') {
                PaymentMethods::where('user_id', $user->id)->update(['is_default' => '0']);
            }
            $pm = PaymentMethods::create([
                'card_brand' => $source->brand,
                'stripe_card_id' => $source->id,
                'card_end_number' => $source->last4,
                'user_id' => $user->id,
                'is_default' => $willBeDefault,
            ]);
            $pms = PaymentMethods::where('user_id', $user->id)->get();
            $user = User::where("id", $user->id)->first();
            return apiresponse(true, 'Payment Method Added', $pm);
        } catch (Exception $e) {
            return apiresponse(false, $e->getMessage());
        }
    }

    public function updateMethod(Request $request)
    {
        try {
            $user = $request->user();
            PaymentMethods::where('user_id', $request->user()->id)->update(['is_default' => '0']);
            PaymentMethods::where('stripe_card_id', $request->source_id)->update(['is_default' => '1']);
            $this->stripe->customers->update(
                $request->user()->stripe_customer_id,
                ['default_source' =>  $request->source_id]
            );
            $pms  = PaymentMethods::where(['user_id' => $user->id, 'status' => '0'])->get();
            return apiresponse(true, 'Payment Method Updated', $pms);
        } catch (Exception $e) {
            return apiresponse(false, $e->getMessage());
        }
    }

    public function showMethod(Request $request)
    {
        $user = $request->user();
        $data  = PaymentMethods::where(['user_id' => $user->id, 'status' => '0'])->get();
        //paginate(10)->toArray();
        if ($data) {
            return apiresponse(true, 'Payment Methods Found', $data);
            // return response()->json(['success' => 'true', 'msg' => 'Payment Methods Found', 'data' => $data]);
        } else {
            return apiresponse(false, "No Methods Found");
            // return response()->json(['success' => 'false', 'msg' => 'Not Found']);
        }
    }

    public function deleteMethod(Request $request)
    {
        $data  = PaymentMethods::where('id', $request->id)->update(['status' => '1']);
        if ($data) {
            return apiresponse(true, 'Deleted Successfully', 1);
        } else {
            return apiresponse(false, 'Cannot Delete Payment Method');
        }
    }
}
