<?php

namespace App\Http\Controllers\api\V1;

use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class VehicleController extends Controller
{



    public function index(Request $request){


        $rows = DB::table('vehicle')
            ->join('vehicle_type', 'vehicle.type_id', '=', 'vehicle_type.id')
            ->join('vehicle_model', 'vehicle.model_id', '=', 'vehicle_model.id')
            ->where('vehicle.type_id',$request->type_id)
            ->where('vehicle.model_id',$request->model_id)
            ->select('vehicle.production_year','vehicle.engine_displacement','vehicle.engine_details',
                'vehicle.fuel_system', 'vehicle_type.name as type', 'vehicle_model.name as model')
            ->get();

        $result['Vehicle'] = $rows;

        return response()->json(['error' => false, 'result' => $result], 200);
    }

}
