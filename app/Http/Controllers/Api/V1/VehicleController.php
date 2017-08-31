<?php

namespace App\Http\Controllers\api\V1;

use App\ServiceRequest;
use App\UserVehicle;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
class VehicleController extends Controller
{

    public function index(Request $request){


        $rows = Vehicle::join('vehicle_type', 'vehicle.type_id', '=', 'vehicle_type.id')
            ->join('vehicle_model', 'vehicle.model_id', '=', 'vehicle_model.id')
            //->leftjoin('vehicle_color', 'vehicle_color.vehicle_id', '=','vehicle.id')
            ->TypeId($request->input('type_id'))
            ->ModelId($request->input('model_id'))
            ->select('vehicle.id','vehicle.production_year','vehicle.engine_displacement','vehicle.engine_details',
                'vehicle.fuel_system', 'vehicle_type.name as type', 'vehicle_model.name as model',
                'vehicle.vehicle_image','vehicle.brochure')
            ->orderBy('id', 'desc')
            ->get();
        $data = [];
        $colors =[];
        for($i=0; $i < count($rows); $i++) {
            $data[$i]['id'] = $rows[$i]->id;
            $data[$i]['production_year'] = $rows[$i]->production_year;
            $data[$i]['engine_displacement'] = $rows[$i]->engine_displacement;
            $data[$i]['engine_details'] = $rows[$i]->engine_details;
            $data[$i]['fuel_system'] = $rows[$i]->fuel_system;
            $data[$i]['type'] = $rows[$i]->type;
            $data[$i]['model'] = $rows[$i]->model;
            $data[$i]['vehicle_image'] = $rows[$i]->vehicle_image;
            $data[$i]['brochure'] = $rows[$i]->brochure;

            $data[$i]['colors'] = $rows[$i]->colors;
            $data[$i]['features'] = $rows[$i]->features;

        }

        return response()->json($data, 200);

    }



    public function user_vehicle(Request $request){

        $user_vehicles = UserVehicle::where('user_id',$request->user()->id)->get();
        $service_count = ServiceRequest::where('user_id', $request->user()->id)->where('status', 5)->count();

        if (count($user_vehicles) > 0) {

            $user_vehicle_no = count($user_vehicles);

                foreach ($user_vehicles as $user_vehicle) {
                    //$vehicle = Vehicle::where('id',$user_vehicle->vehicle_id)->get();
                    //$service_count = ServiceRequest::where('user_id', $user_vehicle->user_id)->where('status', 5)->count();

                    $purchase_date = Carbon::createFromFormat('Y-m-d H:s:i', $user_vehicle->purchase_date);

                    $service = $this->freeService($purchase_date,$service_count,$user_vehicle_no);

                    if($service > 0){

                      $vehicle = DB::table("vehicle")
                          ->select('vehicle.id')
                          ->leftjoin("service_request", function ($join) use ($request){

                              $join->on("vehicle.id", "=", "service_request.vehicle_id");
                          })
                          ->where("user_vehicles.user_id",$request->user()->id)
                          ->count();
                    }
                }

        }else{
            $total_free_services = 0;
        }

      //rint_r($vehicle);exit;
    }


    public function freeService($purchase_date,$service_count,$user_vehicle_no){

        $current_date = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());

        $interval = $purchase_date->diffInDays($current_date, false);

        if ($interval > 360) {
            $total_free_services = 0;
        } else {
            if ($service_count < 17 ) {
                $total_free_services = ($user_vehicle_no * 16 - $service_count);
            } else {
                $total_free_services = 0;
            }
        }
        return $total_free_services;

    }


}
