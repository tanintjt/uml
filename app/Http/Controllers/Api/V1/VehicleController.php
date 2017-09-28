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
            ->select('vehicle.id','vehicle.production_year','vehicle.engine_displacement','vehicle.engine_details','vehicle.description',
                'vehicle.fuel_system', 'vehicle_type.name as type', 'vehicle_model.name as model',
                'vehicle.vehicle_image','vehicle.brochure')->
             orderBy('id', 'asc')
            ->get();
        $data = [];
        $colors =[];
        for($i=0; $i < count($rows); $i++) {
            $data[$i]['id'] = $rows[$i]->id;
            $data[$i]['production_year'] = $rows[$i]->production_year;
//            $data[$i]['engine_displacement'] = $rows[$i]->engine_displacement;
//            $data[$i]['engine_details'] = $rows[$i]->engine_details;
//            $data[$i]['fuel_system'] = $rows[$i]->fuel_system;
            $data[$i]['type'] = $rows[$i]->type;
            $data[$i]['model'] = $rows[$i]->model;
            $data[$i]['vehicle_image'] = $rows[$i]->vehicle_image;
            $data[$i]['description'] = $rows[$i]->description;
//            $data[$i]['brochure'] = $rows[$i]->brochure;

//            $data[$i]['colors'] = $rows[$i]->colors;
//            $data[$i]['features'] = $rows[$i]->features;

        }

        return response()->json($data, 200);

    }



    public function user_vehicle(Request $request){

        //vehicle information join with user_vehicle by user_id.....

        $vehicles  = Vehicle::join('vehicle_type', 'vehicle.type_id', '=', 'vehicle_type.id')
            ->join('vehicle_model', 'vehicle.model_id', '=', 'vehicle_model.id')
            ->join('user_vehicles', 'user_vehicles.vehicle_id', '=', 'vehicle.id')
            ->select('vehicle.id','vehicle.engine_no','user_vehicles.purchase_date',
                'vehicle.fuel_system', 'vehicle_type.name as type', 'vehicle_model.name as model')
            ->where('user_id', '=', $request->user()->id)
            ->orderBy('id', 'desc')
            ->get();

        if (count($vehicles)>0) {

            //TODO..add necessary vehicle info
            $data = [];
            for($i=0; $i < count($vehicles); $i++) {
            $data[$i]['id'] = $vehicles[$i]->id;
            $data[$i]['engine_no'] = $vehicles[$i]->engine_no;
            $data[$i]['fuel_system'] = $vehicles[$i]->fuel_system;
            $data[$i]['type'] = $vehicles[$i]->type;
            $data[$i]['model'] = $vehicles[$i]->model;
            }

            $j=0;
            foreach ($vehicles as $vehicle) {
                //count completed service....
                $service_count = ServiceRequest::where('user_id', $request->user()->id)
                                ->where('vehicle_id',$vehicle->id)
                                ->where('status', 5)
                                ->count();

                $purchase_date = Carbon::createFromFormat('Y-m-d H:s:i', $vehicle->purchase_date);

                //calculate free services.....
                $service = $this->freeService($purchase_date,$service_count);

                if($service){
                    $data[$j]['free_services'] = $service;
                    $j++;
                }else{
                    $data[0]['free_services'] = 0;
                }
            }
        }else{
            $data[0]['id'] = '';
            $data[0]['engine_no'] = '';
            $data[0]['fuel_system'] = '';
            $data[0]['type'] = '';
            $data[0]['model'] = '';
        }
        return response()->json($data, 200);
    }



    public function freeService($purchase_date,$service_count){

        $current_date = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());

        $interval = $purchase_date->diffInDays($current_date, false);

        if ($interval > 360) {
            $total_free_services = 0;
        } else {
            if ($service_count < 17 ) {
                $total_free_services = (16 - $service_count);
            } else {
                $total_free_services = 0;
            }
        }
        return $total_free_services;
    }

}
