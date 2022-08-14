<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\CartItems;
use App\Models\PaymentMethods;
use App\Models\User;
use App\Models\Vat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stripe\StripeClient;

class AuthController extends Controller
{
    public $stripe = "";

    function __construct()
    {
        // die(env("STRIPE_SECRET_KEY"));
        $this->stripe = new StripeClient(env("STRIPE_SECRET_KEY"));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      =>  'required',
            'email'     =>  'required|unique:users,email',
            'password'  =>  'min:8|required_with:confirm_password|same:confirm_password',
        ]);
        if ($validator->fails()) {
            return apiresponse(false, implode("\n", $validator->errors()->all()));
        }

        $stripeCustomer = $this->stripe->customers->create([
            'email' => $request->email,
            'name' => $request->username,
        ]);

        $data = $request->except(['password']);
        $data['stripe_customer_id'] = $stripeCustomer->id;
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($request->has('device_id') and !empty($request->device_id)) {
                    User::find($user->id)->update(['device_id' => $request->device_id]);
                    $user = User::find($user->id);
                }

                $data = [
                    'token' => $user->createToken('customer Token')->accessToken,
                    'user' => $user,
                    'payment_methods' => PaymentMethods::where('user_id', $user->id)->get()->toArray(),
                    'addresses' => Address::where('user_id', $user->id)->get()->toArray(),
                    'vat'   => Vat::first()->toArray(),
                ];
                return apiresponse(true, 'Login Success', $data);
            } else {
                return apiresponse(false, 'Invalid Credentials');
            }
        } else {
            return apiresponse(false, 'Please try again');
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email|exists:users,email',
            'password'  => 'required|min:8'
        ]);
        if ($validator->fails()) return apiresponse(false, implode("\n", $validator->errors()->all()));
        $user = User::where('email', $request->email)->first();
        // $user = User::where('email', $request->email)->with('userPlan')->with('userSubscription')->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($request->has('device_id') and !empty($request->device_id)) {
                    User::find($user->id)->update(['device_id' => $request->device_id]);
                    $user = User::find($user->id);
                    // $user = User::with('userPlan')->with('userSubscription')->find($user->id);
                }
                $data = [
                    'token' => $user->createToken('customer Token')->accessToken,
                    'user' => $user,
                    'payment_methods' => PaymentMethods::where('user_id', $user->id)->get()->toArray(),
                    'addresses' => Address::where('user_id', $user->id)->get()->toArray(),
                    'vat'   => Vat::first()->toArray(),
                ];

                return apiresponse(true, 'Login Success', $data);
            } else {
                return apiresponse(false, 'Invalid Credentials');
            }
        } else {
            return apiresponse(false, 'User not Found!');
        }
    }




    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return apiresponse(false, implode("\n", $validator->errors()->all()));
        }

        try {
            $pass = Hash::make($request->password);
            User::where('email', $request->email)->update(['password' => $pass]);
            return apiresponse(true, "password updated successfully");
        } catch (Exception $e) {
            return apiresponse(false, $e->getMessage());
        }
    }
}
