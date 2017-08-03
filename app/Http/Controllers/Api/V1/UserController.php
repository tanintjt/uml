<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Validator;
class UserController extends Controller
{


    public function user_profile(Request $request){

        $row = $request->user();
        $result['user'] = [
            'name' => $row->name,
            'email' => $row->email,
            'phone' => $row->phone,
        ];
        return response()->json($result, 202);

    }


    public function profile_image(Request $request){

        $rules = [
            'file'      => 'required|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $messages = [
            'file.required' => 'Profile Image is required!',
            'file.mimes' => 'Invalid Image Format !',
            'file.max' => 'Invalid Image Size !',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json($result, 400);
        }

        $file = $request->file('file');

        if($file){

            // Files destination
            $destinationPath = 'public/uploads/profile/';

            // Create folders if they don't exist
            if( ! File::isDirectory(public_path('public/uploads/profile'))) {
                File::makeDirectory(public_path('public/uploads/profile'), 493, true);
            }

            $file_name = time(). '_'. str_random(4).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $file_name);
        }

        $data = [
            'image' => 'public/uploads/profile/' . $file_name,
        ];

        $user_profile = User::where('id',$request->user()->id)->first();

        if (isset($user_profile->image)) {
                unlink($user_profile->image);
        }

        $user_profile->update($data);

        if ($user_profile->id > 0) {

            $result = $user_profile->image;
            $http_code = 201;

        } else {
            $result =  'adding fail.';
            $http_code = 500;
        }

        return response()->json($result, $http_code);
    }

}
