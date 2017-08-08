<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\UserDevice;
use App\UserDevices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
use App\Activation;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class LoginController extends Controller
{
    //use ActivationTrait;

    /*private $user;
    public function __construct(User $user){
        $this->user = $user;
    }*/

    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /*---------------Basic authentication--------------*/

    public function register(Request $request){

        //$input = $request->all();

        $file = Input::file('image');

        $rules = [
            'name' =>  'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'phone' => 'required|regex:/^[0]{1}[1]{1}[5-9]{1}\d{8}$/',
        ];

        $messages = [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'email.email' => 'Not a valid email address!',
            'email.unique' => 'This email already exists!',
            'password.required' => 'Password is required!',
            'phone.required' => 'Phone is required!',
            'phone.regex' => 'Not a valid mobile number!',
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
            ]
        );

        if ($user->id > 0) {
            $user->attachRole(4);
            //$this->initiateEmailActivation($user);
            $activation = new Activation;
            $activation->user_id = $user->id;
            $activation->token = str_random(64);
            $activation->save();

            $link = route('auth.activation', $activation->token);
            $message = sprintf('Activate account %s', $link, $link);
            $this->mailer->raw($message, function (Message $m) use ($user) {
                $m->to($user->email)->subject('Verify your email address');
            });


        }

        return response()->json('Thanks for signing up! An email is sent to you for verification.', 200);
    }




    public function login(Request $request)
    {
        $row = $request->user();
        if ($row) {
            return response()->json(
                [
                    'status' => false,
                    'result' => $row
                ]
                , 201);
        }
        else
         {
            return response()->json(
                'Authorization error', 401);
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

            return response()->json( $result, 400);
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
