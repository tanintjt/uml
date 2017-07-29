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
        $activation = Activation::where('token', $token)->first();

        if($activation) {
            $user = User::where('id', $activation->user_id)->first();
            if($user->status == 1) {
                return redirect()->route('public.home')
                    ->with('status', 'success')
                    ->with('message', 'Your email is already activated.');
            }

            $user->status = 1;
            $user->save();

            $activation->delete();

            return redirect()->route('public.home')
                ->with('status', 'success')
                ->with('message', 'You successfully activated your email!');
        }


        return redirect()->route('public.home')
            ->with('status', 'wrong')
            ->with('message', 'No such token in the database!');



    }
}
