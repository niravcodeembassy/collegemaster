<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //
    public function index() {
        $this->data['title'] =  'Profile';
        $this->data['profile'] = Auth::guard('admin')->user();
        return $this->view('admin.profile.index');
    }

    public function update(Request $request , Admin $profile)
    {
        $data = $request->all();

        if ($request->filled('new_password')) {
            
            $validatedData = $request->validate([
                'old_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password'
            ]); 

            //check old password is correct or not
            if (!Hash::check($request->old_password, $profile->password)) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'old_password' => ['Your current password do not match in our records. Try to enter valid password'],
                 ]);
                 throw $error;
            }

        }
       

        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->email = $data['email'];
        $profile->name = null;
        if($request->filled('new_password')) {
            $profile->password = $data['new_password'];
        }
        $profile->save();

        return back()->with('success' ,'Profile update successfully');

    }

    public function updateImage(Request $request ,Admin $admin)
    {
        $status = 400;

        $oldImage = $admin->profile_image;
        $file_data = $request->input('image');
        $file_name = 'image_' . time() . '.png'; //generating unique file name
        $url = 'profile/' . $file_name; //generating unique file name;

        @list($type, $file_data) = explode(';', $file_data);
        @list(, $file_data) = explode(',', $file_data);

        if ($file_data != "") { 
            $isUploda = Storage::disk('public')->put($url, base64_decode($file_data));
            if ($isUploda) {
                Storage::disk('public')->delete($oldImage);
            }
            $admin->profile_image = $url;
            $admin->save();
            $status = 200;
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile Image Update SuccessFully',
            'image_url' => $admin->profile_src,
        ], $status);
        
    }

}
