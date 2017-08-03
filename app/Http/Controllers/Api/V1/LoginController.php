<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\UserDevice;
use App\UserDevices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
use Zizaco\Entrust\EntrustRole;
use App\Traits\ActivationTrait;

class LoginController extends Controller
{
    use ActivationTrait;

    /*private $user;
    public function __construct(User $user){
        $this->user = $user;
    }*/

    /*---------------Basic authentication--------------*/

    public function register(Request $request){

        //$input = $request->all();

        $file = Input::file('image');

        $rules = [
            'name' =>  'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            //'phone' => 'required|regex:/(01)[0-9]{9}/',
            //'phone' => 'required|regex:/^[0-1]{2}\d{9}$/',
            'phone' => 'required|regex:/^[0]{1}[1]{1}[5-9]{1}\d{8}$/',

            //'image' => 'required',
        ];

        $messages = [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'email.email' => 'Not a valid email address!',
            'email.unique' => 'This email already exists!',
            'password.required' => 'Password is required!',
            'phone.required' => 'Phone is required!',
            'phone.regex' => 'Not a valid mobile number!',
            //'image.required' => 'Profile Picture is required!',
        ];

        $validator = Validator::make($request->all(),$rules, $messages);

        if ($validator->fails()) {

            $result = $validator->errors()->all();
            return response()->json($result, 400);
        }

        $user = User::create(
            [
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'phone'         => $request->input('phone'),
                'password'      => bcrypt($request->input('password')),
                'provider'      => 'uml',
                'provider_id'   => bcrypt($request->input('password')),
                'status'        => 1,
               // 'image'         => $input['image']
            ]
        );

        if ($user->id > 0) {
            $user->attachRole(4);
            $this->initiateEmailActivation($user);
        }

        return response()->json(
            [
                'status'=>true,
                'message'=>'User created successfully',
                'data'=> $user
            ]
        );
    }




    public function login(Request $request)
    {
        $row = $request->user();
        //print_r($row);exit;
        if ($row) {
             return response()->json(['error' => false, 'result' => $row ], 202);
        }
        else
         {
            return response()->json([
                'error'=>'Authorization error'
            ]);
         }
    }
    /*---------------Basic authentication : end --------------*/


    /*-----------------Social authentication----------------*/

    public function provider(Request $request)
    {

        $rules = [
            'name' =>  'required',
            'email' => 'required',
            'provider' => 'required',
            'provider_id' => 'required',
        ];

        $messages = [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'provider.required' => 'Provider is required!',
            'provider_id.required' => 'Provider Id is required!',
        ];

        $validator = Validator::make($request->all(),$rules, $messages);

        if ($validator->fails()) {

            $result = $validator->errors()->all();

            return response()->json(['error' => true, 'result' => $result], 400);
        }

        $authUser = $this->findOrCreateUser($request->all());
        Auth::login($authUser, true);

    }


    public function findOrCreateUser($request)
    {

        /*$authUser = User::where('provider_id',$request['provider_id'])->where('provider',$request['provider'])->first();*/

        $authUser = User::where('email',$request['email'])->where('provider',$request['provider'])->first();

        if ($authUser) {
            return $authUser;
        }
        else{

            $newUser = User::create([
                'name'          =>    $request['name'],
                'email'         =>    $request['email'],
                'password'      =>    bcrypt($request['uid']),
                'provider'      =>    $request['provider'],
                'provider_id'   =>    $request['provider_id'],
                //'device_id'   =>    $request['provider_id'],
                'status'        =>   1
            ]);

            if ($newUser->id > 0) {
                $newUser->attachRole(4);
            }

            return $newUser;
        }
    }
    /*-----------------Social authentication : end----------------*/




    public function device_info(Request $request){


        $data = [
            'user_id'    =>  $request->user()->id,
            'device_id'  =>  $request->input('device_id')
        ];


        $user_device = UserDevices::where('user_id',$request->user()->id)->first();

        if($user_device){

            $user_device->update($data);

        }
        else{

            $user_device = UserDevices::create($data);
        }

        if ($user_device->id > 0) {

            $message = 'Successfully  Added';
            $http_code = 201;
        } else {
            $message =  'adding fail.';
            $http_code = 500;
        }

        return response()->json($message, $http_code);
    }



    public function logout(){

            Auth::logout();

            return response()->json([
                'message'=>'successfully Logged out.'
            ]);

    }
}
