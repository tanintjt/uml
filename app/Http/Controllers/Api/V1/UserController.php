<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
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


    public function update_profile(Request $request)
    {

        $model = User::findOrFail($request->user()->id);

        $rules = [
            'phone'     =>  'regex:/^[0]{1}[1]{1}[5-9]{1}\d{8}$/',
            'file'      => '|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $messages = [
            'phone.regex' => 'Not a valid mobile number!',
            'file.mimes' => 'Invalid Image Format !',
            'file.max' => 'Invalid Image Size !',
        ];




        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json($result, 400);
        }

        //update password
        if ($request->has('password')) {
            $input['password'] = bcrypt($request->input('password'));
        }

        if ($request->has('name')) {
            $input['name'] = $request->input('name');
        }

        if ($request->has('phone')) {
            $input['phone'] = $request->input('phone');
        }


        if($request->hasFile('file')){
            $image = Input::file('file');
            //Delete previous image from folder
            if (File::exists('public/uploads/profile/'.$model->image)) {
                File::delete('public/uploads/profile/'.$model->image);
            }

            // Files destination
            $destinationPath = 'public/uploads/profile/';
            $file_name = time(). '_'. str_random(4).'.'.$image->getClientOriginalExtension();
            $image->move($destinationPath, $file_name);
            $input['image'] = 'public/uploads/profile/' . $file_name;
        }

        ;

        if ($model->update($input)) {
            $message = 'Successfully  updated';
            $http_code = 201;
        } else {
            $message =  'update failed.';
            $http_code = 500;
        }

        return response()->json($message, $http_code);
    }

}
