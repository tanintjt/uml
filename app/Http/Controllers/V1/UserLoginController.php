<?php

namespace App\Http\Controllers\V1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;

class UserLoginController extends Controller
{


    public function __construct()
    {

        $this->middleware('auth.basic');
    }

    public function index()
    {
        
        $title = 'Login to your account';
        return view('auth/login/index', compact('title'));
    }


    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'status' => 1 ], $request->input('remember'))) {

            if(Auth::user()->hasRole('super-administrator')) {

                //return redirect($this->redirectTo);
                $users = DB::table('users')->select('name', 'email','provider','status')->where('email',$request['email'])->get();

                return response()->json($users);
                //return view('home');
            } else {
                return redirect()->route('get-login');
            }
        }

    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('get-login');
    }


}
