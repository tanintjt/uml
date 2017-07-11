<?php

namespace App\Http\Controllers\api\V1;

use App\ServiceCenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
class ServiceCenterController extends Controller
{


    public function index(){

        $rows = ServiceCenter::get();
        /*$result['Service Center'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);*/
        return response()->json($rows, 200);
    }



    public function distanceCalculation(Request $request) {

        $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        $messages = [
            'latitude.required' => ' latitude is required!',
            'longitude.required' => ' longitude is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json(['error' => true, 'result' => $result ], 400);
        }

        //user coordinates ...
        $point1_lat = $request->latitude;
        $point1_long = $request->longitude;

        $unit = 'km';

        // service centre location ......
        $location_centers = $users = DB::table('service_center')->get();

        /* get distance from user to service center location coordinates....*/
        $lcs = array();

        //$lcs1 = [ 'degree' => 1.31, 'id' => 1, 'degree' => 1.31, 'id' => 2 ];

        if($location_centers){

            foreach ($location_centers as $lc) {

                $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($lc->latitude)))
                    + (cos(deg2rad($point1_lat))*cos(deg2rad($lc->latitude))*cos(deg2rad($point1_long-$lc->longitude)))));

                $distance = ($degrees * 111.13384); // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)

                $value =  [ 'minimum_distance' => round($distance, 2),
                    'lat' => $lc->latitude,
                    'long'=>$lc->longitude,
                    'address'=>$lc->address,
                    'phone'=>$lc->phone,
                ];

                array_push($lcs,$value);

                /*get minimum distance from all distances.....*/
                $min = $lcs[0];

                foreach($lcs as $obj)
                {

                    if($obj < $min)
                    {
                        $temp1 =  $obj;
                        $min = $temp1;
                    }
                }
            }
        }
        //print_r($lcs);exit;
        return response()->json($min, 200);

    }

}
