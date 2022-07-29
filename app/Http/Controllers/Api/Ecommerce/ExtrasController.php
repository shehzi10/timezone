<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Help;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ExtrasController extends Controller
{
    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password'          =>          'required_with:password|min:8',
            'new_password'          =>          'min:8|different:old_password',
        ]);
        if ($validator->fails()) {
            return apiresponse(false, implode("\n", $validator->errors()->all()));
        }
        try {
            $old_password   =   Hash::check($request->old_password, Auth::User()->password);
            if ($old_password) {
                $data['password']       =   Hash::make($request->new_password);
                $user = User::findOrFail(auth()->user()->id)->update($data);
                if ($user) {
                    return apiresponse(true, 'Password has been updated successfully', $data);
                } else {
                    return apiresponse(false, 'Error occurred, please try again');
                }
            } else {
                return apiresponse(false, "Old password is incorrect");
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }


    public function help(Request $request){

        $data['user_id']        =       Auth::user()->id;
        $data['text']           =       $request->text;

        $help = Help::create($data);

        if($help){
            return apiresponse(true, 'Query has been sent successfully', $help);
        }
        return apiresponse(false, 'Some error occurred, please try again');


    }
}
