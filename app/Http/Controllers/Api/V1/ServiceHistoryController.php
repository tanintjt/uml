<?php

namespace App\Http\Controllers\Api\V1;

use App\ServiceRequest;
use App\UserVehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use DB;
class ServiceHistoryController extends Controller
{


    public  function index(Request $request){

        $rows = ServiceRequest::where('user_id',$request->user()->id)->get();



        /*if($users){
            $rows = DB::table("user_vehicles")
                ->select('user_vehicles.user_id','user_vehicles.vehicle_id',
                    'user_vehicles.purchase_date','service_request.status')

                ->leftjoin("service_request", function ($join) use ($request){

                    $join->on("user_vehicles.user_id", "=", "service_request.user_id");

                })->where("service_request.status",5)
                ->where("user_vehicles.user_id",$request->user()->id)
                ->count();


        }*/


        //free services .......
        /*$users = UserVehicle::where('user_id',$request->user()->id)->get();

        $user_vehicle_no = UserVehicle::where('user_id',$request->user()->id)->count();
        if($users){
            foreach($users as $user){

                $service_count = ServiceRequest::where('user_id',$user->user_id)->where('status',5)->count();

                $purchase_date = Carbon::createFromFormat('Y-m-d H:s:i', $user->purchase_date);
                $current_date = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());

                $interval = $purchase_date->diffInDays($current_date, false);

                if($interval==360){
                    $total_free_services = 0;
                }else{
                    if($service_count>0){
                        $total_free_services =($user_vehicle_no*4 - $service_count) ;
                    }else{
                        $total_free_services = $user_vehicle_no*4;
                    }
                }
            }

        }else{
            $total_free_services = 0;
        }*/

        $data = [];

        if (count($rows) > 0) {
            for($i=0; $i < count($rows); $i++) {

                if($rows[$i]->status ==1){
                    $status = 'Pending';
                }elseif ($rows[$i]->status ==2){
                    $status = 'Accepted';
                }elseif ($rows[$i]->status ==3){
                    $status = 'Reject';
                }elseif ($rows[$i]->status ==4){
                    $status = 'Rescheduled';
                }else{
                    $status = 'Done';
                }

                $data[$i]['username'] = $rows[$i]->users->name;
                $data[$i]['registration_date'] = date("jS F, Y", strtotime($rows[$i]->users->created_at));
                $data[$i]['packages'] = $rows[$i]->packages->name;
                $data[$i]['request_date'] = date("jS F, Y", strtotime($rows[$i]->request_date));
                $data[$i]['status'] = $status;
                //$data[$i]['freeservice'] = $total_free_services;
            }
            $result = $data;
        }
        else {
            $data[0]['username'] = $request->user()->name;
            $data[0]['registration_date'] = date("jS F, Y", strtotime($request->user()->created_at));
            $data[0]['packages'] = 'No history found';
            $data[0]['request_date'] = date("jS F, Y", strtotime(Carbon::now()));
            $data[0]['status'] = 0;
            //$data[0]['freeservice'] = $total_free_services;
            $result = $data;
        }

        return response()->json($result, 202);
    }

}
