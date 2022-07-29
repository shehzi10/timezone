<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function doLogin(Request $request){
        $user = Admin::where('email',$request->email)->first();
        if($user){

            $remember_me = $request->has('remember') ? true : false;
            if (Auth::guard('admin')->attempt(['email' => $request->email,'password' => $request->password],$remember_me)) {
                if (Auth::guard('admin')->user()) {
                    return redirect(route('product'));
                } else {
                    session()->flash('success', 'Invalid Credentials!');
                    return redirect()->back()->withInput();
                }
            }
        }
        session()->flash('error', 'Invalid Credentials!');
        return redirect()->back()->withInput();
    }
}
