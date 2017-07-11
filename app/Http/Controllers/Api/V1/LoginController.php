<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\UserDevice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;
class LoginController extends Controller
{

    /*private $user;
    public function __construct(User $user){
        $this->user = $user;
    }*/

    /*---------------Basic authentication--------------*/

    public function register(Request $request){

        $rules = [
            'name' =>  'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
        ];

        $messages = [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'password.required' => 'Password is required!',
            'phone.required' => 'Phone is required!',
        ];

        $validator = Validator::make($request->all(),$rules, $messages);

        if ($validator->fails()) {

            $result = $validator->errors()->all();

            return response()->json(['error' => true, 'result' => $result], 400);
        }

        $user = User::create(
            [
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'password'      => bcrypt($request->input('password')),
                'provider'      => 'uml',
                'provider_id'   => bcrypt($request->input('password')),
                'status'        => 1
            ]
        );
        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
    }




    public function login(Request $request)
    {
        $row = $request->user();

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

        $authUser = User::where('provider_id',$request['provider_id'])->where('provider',$request['provider'])->first();

        if ($authUser) {

            return $authUser;
        }
        else{

            $newUser = User::create([
                'name'          =>    $request['name'],
                'email'         =>    $request['email'],
                'provider'      =>    $request['provider'],
                'provider_id'   =>    $request['provider_id'],
                'status'        =>   1
            ]);

            return $newUser;
        }
    }
    /*-----------------Social authentication : end----------------*/




    public function device_info(Request $request){

     //dd(Auth::user()->id);
            $data_exists = DB::table('users_devices')->where('user_id', '=',$request->user_id)
                ->where('device_id', '=', $request->device_id)
                ->exists();

            if(!$data_exists){

                UserDevice::create(
                    [
                        'user_id'  =>$request->user_id,
                        'device_id'  =>$request->device_id,
                    ]
                );
                return response()->json(['error' => false, 'message'=>'User created successfully'], 202);
            }else{
                return response()->json([
                    'error'=>'Already Exists!!!'
                ]);
            }
    }




    public function logout(){

            Auth::logout();

            return response()->json([
                'message'=>'successfully Logged out.'
            ]);

    }
}
