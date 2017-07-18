<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class PushNotificationController extends Controller
{
    public function index(Request $request) {


        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world 2')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'Uml test data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "fd-6dZ95-QQ:APA91bGBgZBxTxeFc-5oPa_kqkI6c_aVgqNhs39BSLKqlTkiSLPi5cOeFOqLhbU4Ej1Ha4aSlDj9lXfrG7X-Hki5rstPMMOU8bODfKUcy-wjvUYacGvt-_Dd-0qqS8si6co_HjNyfo5-";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        /*$downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();*/

        return $downstreamResponse->numberSuccess();
        //$downstreamResponse->numberFailure();
        //$downstreamResponse->numberModification();;


    }
}
