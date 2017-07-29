<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activation;

class ActivateController extends Controller
{
    public function activate($token)
    {
        $title = 'Email Activation';

        $activation = Activation::where('token', $token)->first();

        if ($activation) {

            $user = User::where('id', $activation->user_id)->first();

            if ($user->status == 1) {
                $data = ['status' => 'success', 'message' => 'Your email is already activated.'];
            } else {
                $user->status = 1;
                $user->save();
                $activation->delete();
                $data = ['status' => 'success', 'message' => 'You successfully activated your email'];
            }
        } else {
            $data = ['status' => 'danger', 'message' => 'No such token in the system!'];
        }

        return view('auth/activation/index', compact('data', 'title'));

    }
}
