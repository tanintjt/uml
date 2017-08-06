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


        $service_requests = DB::select('select count(id) as cnt, user_id from tbl_service_request
                              where user_id in (select user_id from tbl_user_vehicles)
                              and status = 5
                              group by user_id');

        foreach ($service_requests as $service_request){

            $user_vehicles = UserVehicle::where('user_id',$service_request->user_id)->get();

            foreach ($user_vehicles as $user_vehicle){

                $purchase_date = Carbon::parse($user_vehicle->purchase_date)->format('Y-m-d');
                $current_date  = Carbon::now()->format('Y-m-d');

                if($service_request->cnt<5 && $service_request->cnt>0){
                    echo 'ok';

                }else{
                    echo 'exit';
                }
            }
            // print_r($user_vehicle);




        }

        exit;

    }
}
