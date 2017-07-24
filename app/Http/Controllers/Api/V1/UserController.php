<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
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
            'image'      => 'required|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $messages = [
            'image.required' => 'Profile Image is required!',
            'image.mimes' => 'Invalid Image Format !',
            'image.max' => 'Invalid Image Size !',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json(['error' => true, 'result' => $result ], 400);
        }

        $file = $request->file('image');

        if($file){

            // Files destination
            $destinationPath = 'public/uploads/profile/';

            // Create folders if they don't exist
            if ( !file_exists($destinationPath) ) {
                mkdir ($destinationPath, 0777);
            }

            $file_name = time(). '_'. str_random(4).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $file_name);
        }

        $data = [
            'image'        =>     'public/uploads/profile/' . $file_name,
        ];

        $user_profile = User::where('id',$request->user()->id)->first();

        if (isset($user_profile->image)) {

                unlink($user_profile->image);
        }

        $user_profile->update($data);

        if ($user_profile->id > 0) {

            $message = 'Successfully  Added Profile Image :'.$user_profile->image;
            $http_code = 201;
        } else {
            $message =  'adding fail.';
            $http_code = 500;
        }

        return response()->json($message, $http_code);
    }

}
