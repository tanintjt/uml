<?php

namespace App\Http\Controllers\api\V1;

use App\ServiceCenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ServiceCenterController extends Controller
{


    public function index(){

        $rows = ServiceCenter::get();
        $result['Service Center'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);
    }



    public function distanceCalculation() {

        //user coordinates ...
        $point1_lat = 33.8280741;

        $point1_long = 116.5069582;


        // service centre coordinates ...
        $point2_lat = 44.2272390;

        $point2_long = 19.5649320;

        $unit = 'km';

        $decimals = 2;


        $location_centers = $users = DB::table('service_center')->get();

        $lcs = array();

        foreach ($location_centers as $lc) {


            $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($lc->latitude))) + (cos(deg2rad($point1_lat))*cos(deg2rad($lc->latitude))*cos(deg2rad($point1_long-$lc->longitude)))));

            $distance = ($degrees * 111.13384); // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)

            $value = round($distance, $decimals);
            $ar_push = array_push($lcs,$value);

        }

        $min = $lcs[0];

        foreach($lcs as $obj)
        {
            if($obj < $min)
            {
                $temp1 =  $obj;
                $min = $temp1;
            }
        }

        if($min == $lcs[0]){

        }

      /*  // Calculate the distance in degrees
        $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));

        $distance = ($degrees * 111.13384); // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
        //print_r($distance);exit;

        $value = round($distance, $decimals);
        return $value."  ".$unit;*/
    }


}
