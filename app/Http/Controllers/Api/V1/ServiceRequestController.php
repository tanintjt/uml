<?php

namespace App\Http\Controllers\api\V1;

use App\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class ServiceRequestController extends Controller
{


    public function store(Request $request ){

        $user = $request->user();

        $rules = [
            'service_center_id' => 'required',
            'service_package_id' => 'required',
        ];

        $messages = [
            'service_center_id.required' => 'Service Center is required!',
            'service_package_id.required' => 'Service Package is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json($result, 400);
        }

        $date = Carbon::parse($request->input('request_date'));
        $service_request = ServiceRequest::create(
            [
                'user_id'   => $user->id,
                'service_center_id'      => $request->input('service_center_id'),
                'service_package_id'     => $request->input('service_package_id'),
                'status'    => 1,
                'request_date' => $date->format('Y-m-d'),
                'request_time' => $date->format('H:i:s'),
                'special_request'=> $request->input('special_request')
            ]
        );

        if ($service_request) {
            $result = 'Successfully Sent Request';
            $http_code = 201;
        } else {
            $result = 'Request failed.';
            $http_code = 500;
        }

        return response()->json($result, $http_code);
    }



}
