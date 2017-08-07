<?php

namespace App\Http\Controllers;

use App\ServiceRequest;
use App\User;
use App\UserDevices;
use App\UserVehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class TestController extends Controller
{

    public function index(Request $request){


        $service_requests = DB::select('select count(id) as cnt, user_id from tbl_service_request
                              where user_id in (select user_id from tbl_user_vehicles)
                              and status = 5
                              group by user_id');

        if($service_requests){
            foreach ($service_requests as $service_request){

                $user_vehicles = UserVehicle::where('user_id',$service_request->user_id)->get();

                foreach ($user_vehicles as $user_vehicle){

                    // user_device_id....
                    $device_ids = UserDevices::where('user_id',$user_vehicle->user_id)->pluck('device_id')->toArray();

                    $purchase_date = Carbon::createFromFormat('Y-m-d H:s:i', $user_vehicle->purchase_date);
                    $current_date = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());

                    $interval = $purchase_date->diffInDays($current_date, false);

                    if($service_request->cnt < 4 ){

                        if($interval== 89 || $interval == 179 || $interval == 359){

                            $this->sendNotification($device_ids);
                        }
                    }
                }
            }
        }

    }



    public function sendNotification($device_ids)
    {

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('Uttara Motors');
        $notificationBuilder->setClickAction('FCM_PLUGIN_ACTIVITY')
            ->setBody('Test Message')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();

        $dataBuilder
            ->addData(['title' => 'Uttara Motors'])
            ->addData(['body' => 'Test Message']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = $device_ids ;
//print_r($tokens);exit;
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        return $downstreamResponse->numberSuccess();
    }
}
