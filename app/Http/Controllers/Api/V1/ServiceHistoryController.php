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
        //join('users','service_request.user_id', '=', 'users.id')
            //->join('service_package','service_request.service_package_id', '=', 'service_package.id')
            where('user_id',$request->user()->id)
            //->select('service_request.request_date','service_package.name as package_name')
            ->get();

        $data = [];

        for($i=0; $i < count($rows); $i++) {
            $data[$i]['username'] = $rows[$i]->users->name;
            $data[$i]['registration_date'] = date("jS F, Y", strtotime($rows[$i]->users->created_at));
            $data[$i]['packages'] = $rows[$i]->packages->name;
            $data[$i]['request_date'] = date("jS F, Y", strtotime($rows[$i]->request_date));
        }

        return response()->json($data, 202);
    }
}
