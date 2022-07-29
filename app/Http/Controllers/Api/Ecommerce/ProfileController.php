<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $data = $request->except(['profile_pic']);
        if ($request->hasFile('profile_pic')) {
            $file               =   $request->file('profile_pic');
            $fileName = time() . '.' . $request->file('profile_pic')->getClientOriginalExtension();
            $featured_path      =   'public/images';
            $file->move($featured_path, $fileName);
            $data['profile_pic']   =   $fileName;
        }
        User::where('id', $request->user()->id)->update($data);

        $user = User::find($request->user()->id);

        if ($user) {
            return apiresponse(true, 'Your Profile has been updated successfully', $user);
        } else {
            return apiresponse(false, 'Error in updating profile');
        }
    }
}
