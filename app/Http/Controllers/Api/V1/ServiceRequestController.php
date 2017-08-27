<?php

namespace App\Http\Controllers\api\V1;

use App\ServicePackage;
use App\ServiceRequest;
use App\User;
use App\UserVehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use DB;
class ServiceRequestController extends Controller
{


    public function store(Request $request ){

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

        $data =
            [
                'user_id'   => $request->user()->id,
                'service_center_id'      => $request->input('service_center_id'),
                'service_package_id'     => $request->input('service_package_id'),
                'status'    => 1,
                'request_date' => $date->format('Y-m-d'),
                'request_time' => $date->format('H:i:s'),
                'special_request'=> $request->input('special_request')
            ];


        if($request->input('service_package_id') == 19 ){

            $user = UserVehicle::where('user_id',$request->user()->id)->first();

            if($user) {

                $purchase_date = Carbon::createFromFormat('Y-m-d H:s:i', $user->purchase_date);
                $current_date = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
                $interval = $purchase_date->diffInDays($current_date, false);

                $service_count = ServiceRequest::where('user_id', $user->user_id)->where('status', 5)->count();

                if ($interval<=360) {

                    if($service_count < 4){

                        $service_request =  ServiceRequest::create($data);

                        if ($service_request) {
                            $result = 'Successfully Sent Request';
                            $http_code = 201;
                        } else {
                            $result = 'Request failed.';
                            $http_code = 500;
                        }
                        return response()->json($result, $http_code);
                    }else{
                        return response()->json(
                            ' You have already taken four free services.', 401);
                    }
                }
                else{
                    return response()->json(
                        'Date Expired !!', 401);
                }
            }else{
                return response()->json(
                    'You are not entitled for free services.', 401);
            }

        }else{
            $service_request =  ServiceRequest::create($data);

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

}
