<?php

namespace App\Http\Controllers;

use App\ServiceRequest;
use App\User;
use App\UserVehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    public function index(Request $request){


        $users1 = DB::select('select count(id) as cnt, user_id from tbl_service_request
                              where user_id in (select user_id from tbl_user_vehicles)
                              and status = 5
                              group by user_id');

        

        if($users1){
            return true;
        }else{
            $purchase_date = Carbon::createFromFormat('Y-m-d H:s:i', $user_vehicle->purchase_date);
            $current_date  = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());

        }








        if($user_vehicles){
            foreach ($user_vehicles as $user_vehicle){

                //print_r($user_vehicle);
                $service = ServiceRequest::where('user_id',$user_vehicle->id)->count('status');


                print_r($service);



                $interval = $purchase_date->diffInDays($current_date, false);

                //dd($interval);
                if($service<4 && $service>0){
                    //print_r($interval);
                }

            }
         exit;

        }
    }
}
