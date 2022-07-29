<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgetPasswordController extends Controller
{
    public function sendMail(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        $code = substr(md5(rand()), 0, 4);

        if (!$user) {
            return apiresponse(false, 'Email does not exist');
        } else {
            $user->remember_token = $code;
            $user->save();
            //        $this->SendForgetMessage($code, $user);
            $update['remember_token'] =   $code;
            //        $update['confirmation_code']    =   Null;
            User::where('id', $user->id)->update($update);
            $user = User::where('id', $user->id)->first();
            if ($user) {
                Mail::to($request->email)->send(new ForgotPassword($user));
                return  apiresponse(true, 'Password reset link sent to your email', $update);
            } else {
                return apiresponse(false, 'Some error occurred. Please try again');
            }
        }
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'             => 'required',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password'
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
