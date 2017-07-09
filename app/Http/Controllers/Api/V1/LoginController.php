<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\UserDevice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Socialite;
use Session;
class LoginController extends Controller
{

    /*private $user;
    public function __construct(User $user){
        $this->user = $user;
    }*/


    public function register(Request $request){

        $user = User::create(
            [
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'password'      => bcrypt($request->input('password')),
                'provider'      => 'uml',
                'provider_id'   => bcrypt($request->input('password')),
                //'device_id'   =>   1,
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



    public function provider(Request $request)
    {

        $authUser = $this->findOrCreateUser($request->all());
        Auth::login($authUser, true);

    }


    public function findOrCreateUser($request)
    {
        //print_r($request['provider_id']);exit;

        $authUser = User::where('provider_id',$request['provider_id'])->where('provider',$request['provider'])->exists();

        if ($authUser) {
            return $authUser;
        }

        $newUser = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'provider' => $request['provider'],
            'provider_id' =>$request['provider_id'],
            'status' => 1,
        ]);

        return response()->json(['error' => false, 'result' => $newUser], 202);
    }



    public function providerCallback($provider)
    {

        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);

        return true;

    }




    public function device_info(Request $request){


            //$input = $request->all();

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



    public function logout(Request $request){


       /* $user_token = [
            'api_token' =>Null,
        ];*/

//        if(DB::table('users')->where('id', '=', Auth::user()->id)->update($user_token)){

            Auth::logout();

            return response()->json([
                'message'=>'successfully Logged out.'
            ]);
//        }


    }
}
