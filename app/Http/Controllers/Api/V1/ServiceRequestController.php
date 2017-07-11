<?php

namespace App\Http\Controllers\api\V1;

use App\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class ServiceRequestController extends Controller
{


    public function store(Request $request ){


        $user = Auth::user();

        $rules = [
            //'user_id' => 'required',
            'service_center_id' => 'required',
            'service_package_id' => 'required',
        ];

        $messages = [
            //'user_id.required' => 'User is required!',
            'service_center_id.required' => 'Service Center is required!',
            'service_package_id.required' => 'Service Package is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json(['error' => true, 'result' => $result ], 400);
        }

        $request_exists = ServiceRequest::where('user_id','=',$user->id)->where('service_center_id','=',$request->service_center_id)
            ->where('service_package_id','=',$request->service_package_id)
            ->exists();

        if($request_exists){
            return response()->json(['error' => true, 'result' => 'Already added. Please try another one!!!' ], 200);
        }
        else{
            $service_request = ServiceRequest::create(
                [
                    'user_id'   => $user->id,
                    'service_center_id'      => $request->input('service_center_id'),
                    'service_package_id'     => $request->input('service_package_id'),
                    'status'    =>0,
                    'request_time' => date('Y-m-d h:i:s', time()),
                    'special_request'=>$request->input('special_request')
                ]
            );
        }
        if ($service_request) {
            $result = 'Successfully Sent Request';
            $error = false;
            $http_code = 201;
        } else {
            $result = 'Request failed.';
            $http_code = 500;
            $error = true;
        }

        return response()->json($result, $http_code);
    }



}
