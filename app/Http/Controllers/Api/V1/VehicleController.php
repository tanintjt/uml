<?php

namespace App\Http\Controllers\api\V1;

use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

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
                'vehicle.vehicle_image')
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

            $data[$i]['colors'] = $rows[$i]->colors;

        }

        return response()->json($data, 200);

    }

}
