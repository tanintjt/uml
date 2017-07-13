<?php

namespace App\Http\Controllers\Api\V1;

use App\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class ServiceHistoryController extends Controller
{


    public  function index(){

        $user = Auth::user();
        $row = ServiceRequest::with('users','service_package')
            ->where('user_id',$user->id)
            ->get();

      /* $row = ServiceRequest::join('users', 'service_request.user_id', '=', 'users.id')
            ->join('service_package', 'service_request.service_package_id', '=', 'service_package.id')
            ->select('users.name as username','service_package.name')
            ->get();*/

        /*$rows = ServiceRequest::join('users', 'service_request.user_id', '=', 'users.id')
            ->join('service_package', 'service_request.service_package_id', '=', 'service_package.id')
            ->select('users.name','service_package.name','service_request.updated_at as servicing_time','service_package_id.name as s_name')
            ->get();
        $data = [];


        for($i=0; $i < count($rows); $i++) {
            //$data[$i]['name'] = $rows[$i]->users;
            $data[$i]['name'] = $rows[$i]->users;
            $data[$i]['s_name'] = $rows[$i]->s_name;
            /*$data[$i]['engine_displacement'] = $rows[$i]->engine_displacement;
            $data[$i]['engine_details'] = $rows[$i]->engine_details;
            $data[$i]['fuel_system'] = $rows[$i]->fuel_system;
            $data[$i]['type'] = $rows[$i]->type;
            $data[$i]['model'] = $rows[$i]->model;
            $data[$i]['vehicle_image'] = $rows[$i]->vehicle_image;*/

            //$data[$i]['colors'] = $rows[$i]->colors;*/

        //}

        return $row;
    }
}
