<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\PushNotificationController;
use Illuminate\Console\Command;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class PushNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification to User';

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
       //echo "success";exit;
        $

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('Service Request');
        $notificationBuilder->setBody('Accepted your Request!!')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'Uml']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "fd-6dZ95-QQ:APA91bGBgZBxTxeFc-5oPa_kqkI6c_aVgqNhs39BSLKqlTkiSLPi5cOeFOqLhbU4Ej1Ha4aSlDj9lXfrG7X-Hki5rstPMMOU8bODfKUcy-wjvUYacGvt-_Dd-0qqS8si6co_HjNyfo5-";
//        $token = "dT6LEBeNx08:APA91bGu2eju6beFk3bivPeyiAsfF4Spa9dhiQfDSalKIsVYg9R8GEMkagwSPtSclrIIA-r_89pYDB5RMBRRixXUVzyjYGrtLyDiIyWDTRdB_N4jbHs1l5ADReMxIAn6j-Hs3okKYnpM";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        /*$downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();*/

        return response()->json([
            'fail' => $downstreamResponse->numberFailure(),
            'sucess' => $downstreamResponse->numberSuccess(),
            'msg' =>$downstreamResponse->tokensWithError()
        ],200);
    }
}
