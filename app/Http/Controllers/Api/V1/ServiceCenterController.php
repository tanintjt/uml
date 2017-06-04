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
        $result['Service Center'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);
    }



    public function distanceCalculation(Request $request) {

        $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        $messages = [
            'latitude.required' => 'User latitude is required!',
            'longitude.required' => 'User longitude is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json(['error' => true, 'result' => $result ], 400);
        }

        //user coordinates ...

        //$point1_lat = 33.8280741;
        //$point1_long = 116.5069582;

        $point1_lat = $request->latitude;
        $point1_long = $request->longitude;


        $unit = 'km';

        $decimals = 2;

        // service centre location ......
        $location_centers = $users = DB::table('service_center')->get();

        /* get distance from user to service center location coordinates....*/
        $lcs = array();

        if($location_centers){

            foreach ($location_centers as $lc) {

                $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($lc->latitude))) + (cos(deg2rad($point1_lat))*cos(deg2rad($lc->latitude))*cos(deg2rad($point1_long-$lc->longitude)))));

                $distance = ($degrees * 111.13384); // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)

                $value = round($distance, $decimals);
                array_push($lcs,$value);

            }
            //print_r(($lcs));exit;

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
            //print_r($min);exit;

            /* get nearest coordinates according to minimum distance....*/
            for($i=0;$i<count($lcs);$i++){

                if($min == $lcs[$i]){
                    $result = DB::table('service_center')->where('id','=',$i+1)->get();
                }
            }
        }
        //print_r($result);exit;
        return response()->json(['error' => false, 'result' => $result ], 202);

    }

}
