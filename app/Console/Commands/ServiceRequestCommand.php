<?php

namespace App\Console\Commands;

use App\ServiceRequest;
use App\UserVehicle;
use Edujugon\PushNotification\Facades\PushNotification;
use Edujugon\PushNotification\Providers\PushNotificationServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Parser\Reader;
use Auth;
use Carbon\Carbon;
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
        $user_vehicle = UserVehicle::where('user_id',49)->first();

        if($user_vehicle){
            $service = ServiceRequest::where('user_id',49)->count();

            $purchase_date = Carbon::createFromFormat('Y-m-d H:s:i', $user_vehicle->purchase_date);
            $current_date = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());

            $interval = $purchase_date->diffInDays($current_date, false);

            //dd($interval);
            if($service<4 && $service>0){
                dd($interval);
            }
        }

    }

}
