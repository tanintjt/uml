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


    public static function index() {


        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder(['Service Request']);
        $notificationBuilder->setBody(['Thank You. Request Accepted !!!'])
                           ->setSound('default');
                          // ->setClickAction('FCM_PLUGIN_ACTIVITY');

        $dataBuilder = new PayloadDataBuilder();

        $dataBuilder
//            ->addTitle(['title' => 'Service Request'])
//                    ->addBody(['body' => 'Thank You. Request Accepted !!!'])
                    ->addData(['a_data' => 'Uml']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "dtZIjFb32zE:APA91bGmAonLp_U7iNM0t1Vzd8loFYr_16CL-CLOK0T958GpQZVR0gmoC_EEOy4uuSQhzHRQSbEYL6_KbZzzQSJYTiV-ft8KWITxHfy2p0LjP8mcvWcCvvqZxS3iyWQZ4pc9yrSn1ao-";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        /*$downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();*/
        return $downstreamResponse->numberSuccess();


    }
}
