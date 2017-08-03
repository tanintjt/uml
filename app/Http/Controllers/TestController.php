<?php

namespace App\Http\Controllers;

use App\ServiceRequest;
use App\User;
use App\UserVehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;
class TestController extends Controller
{



    public function index(Request $request){

        $user = UserVehicle::where('user_id',$request->user()->id)->get();

        if($user){
            $service = ServiceRequest::where('user_id',$request->user()->id)->count();

            print_r($service);exit;


        }
    }
}
