<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
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
                'status'        => $request->input('status')
            ]
        );
        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
    }



    public function login(Request $request)
    {
       /* $row = $request->user();

        $result['user'] = [
            'name' => $row->name,
            'email' => $row->email,
//            'provider' => $row->provider,
//            'provider_id' => $row->provider_id,
            'api_token' =>str_random(30),
        ];

        //return $request->user();
        return response()->json(['error' => false, 'result'=>$request], 200);*/


        if (Auth::check()) {

            $user_token = [
                'remember_token' =>str_random(30),
                'api_token' =>str_random(60),
            ];

            DB::table('users')->where('id', '=', Auth::user()->id)->update($user_token);

            return response()->json([
                'name' => Auth::user()->name,
                'email' =>Auth::user()->email,
                'api_token' =>$user_token['api_token'],
            ]);
        } else {
            return response()->json([
                'error'=>'Authorization error'
            ]);
        }

    }

    public function logout(Request $request){


        $user_token = [
            'api_token' =>Null,
        ];

        DB::table('users')->where('id', '=', Auth::user()->id)->update($user_token);

        Auth::logout();

        return response()->json([
            'message'=>'successfully Logged out.'
        ]);


    }
}
