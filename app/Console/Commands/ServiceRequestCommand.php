<?php

namespace App\Console\Commands;

use App\ServiceRequest;
use App\UserDevices;
use App\UserVehicle;
use Edujugon\PushNotification\Facades\PushNotification;
use Edujugon\PushNotification\Providers\PushNotificationServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Parser\Reader;
use Auth;
use Carbon\Carbon;
use DB;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
class ServiceRequestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:free_service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification for free services';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service_requests = DB::select('select count(id) as cnt, user_id from tbl_service_request
                              where user_id in (select user_id from tbl_user_vehicles)
                              and status = 5
                              group by user_id');

        foreach ($service_requests as $service_request){

            $user_vehicles = UserVehicle::where('user_id',$service_request->user_id)->get();

            foreach ($user_vehicles as $user_vehicle){

                // user_device_id....
                $device_ids = UserDevices::where('user_id',$user_vehicle->user_id)->pluck('device_id')->toArray();

                $purchase_date = Carbon::createFromFormat('Y-m-d H:s:i', $user_vehicle->purchase_date);
                $current_date = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());

                $interval = $purchase_date->diffInDays($current_date, false);
                print_r($interval);

                if($service_request->cnt<5 && $service_request->cnt>0){

                    if($interval==179){

                        $sendMsg = $this->sendNotification($device_ids);

                        if($sendMsg){
                            return 'success';
                        }else{
                            return 'failed';
                        }
                    }

                }else{

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
            ->setBody('Free Services.....')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();

        $dataBuilder
            ->addData(['title' => 'Uttara Motors'])
            ->addData(['body' => 'Free Services.....']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = $device_ids ;

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        return $downstreamResponse->numberSuccess();
    }

}
