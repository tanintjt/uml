<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\UserDevice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;

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

            /*$data_exists = DB::table('users_devices')->where('user_id', '=', $row->id)
                                   ->where('device_id', '=', $row->device_id)
                                   ->exists();
            if($data_exists){

                UserDevice::create(
                    [
                        'user_id'  =>$row->id,
                        'device_id'  =>$row->device_id,
                    ]
                );
            }*/
            return response()->json(['error' => false, 'result' => $row ], 202);
        }
        else
         {
            return response()->json([
                'error'=>'Authorization error'
            ]);
         }
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
