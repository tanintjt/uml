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

        $notificationBuilder = new PayloadNotificationBuilder('Service Request');
        $notificationBuilder->setBody('Accepted your Request!!')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'Uml']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "fpzriQE4rao:APA91bHWl5-yAgyfX4JOQUVV5pRZktGSulelUluRAl1TTBr_G5-unnxrIMMHP59cFb2WuJEWnAOBvQBvgcTR7dcGGVA35AnY3giaK3MWC3cXZh1r6akAKvE9QubrGl38I3YLsOrDdwrY";
//        $token = "861105030067461";

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
