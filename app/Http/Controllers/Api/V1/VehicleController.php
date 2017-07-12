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
            ->leftjoin('vehicle_color', 'vehicle_color.vehicle_id', '=','vehicle.id')
            ->Type($request->input('type_id'))
            ->Model($request->input('model_id'))
            ->select('vehicle.id','vehicle.production_year','vehicle.engine_displacement','vehicle.engine_details',
                'vehicle.fuel_system', 'vehicle_type.name as type', 'vehicle_model.name as model','vehicle.vehicle_image','vehicle_color.available_colors')
            ->get();

        return response()->json($rows, 200);

    }

}
