<?php

namespace App\Http\Controllers\Api\V1;

use App\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class ServiceHistoryController extends Controller
{


    public  function index(Request $request){

        $rows = ServiceRequest::
        join('users','service_request.user_id', '=', 'users.id')
            ->join('service_package','service_request.service_package_id', '=', 'service_package.id')
            ->where('user_id',$request->user()->id)
            ->select('users.name as username','users.created_at as User_Since','service_request.request_date','service_package.name as package_name')
            ->get();

        $data = [];

        for($i=0; $i < count($rows); $i++) {
           // $data[$i]['users'] = $rows[$i]->users;
            $data[$i]['service_package'] = $rows[$i]->service_package;
            $data[$i]['User_Since'] = date("jS F, Y", strtotime($rows[$i]->User_Since));
            /*$data[$i]['engine_displacement'] = $rows[$i]->engine_displacement;
            $data[$i]['engine_details'] = $rows[$i]->engine_details;
            $data[$i]['fuel_system'] = $rows[$i]->fuel_system;
            $data[$i]['type'] = $rows[$i]->type;
            $data[$i]['model'] = $rows[$i]->model;
            $data[$i]['vehicle_image'] = $rows[$i]->vehicle_image;

            $data[$i]['colors'] = $rows[$i]->colors;*/

        }

        return response()->json($rows, 202);
    }
}
