<?php

namespace App\Http\Controllers\Api\V1;

use App\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
class ServiceHistoryController extends Controller
{


    public  function index(Request $request){

        $rows = ServiceRequest::where('user_id',$request->user()->id)->get();
//print_r($rows);exit;

        $data = [];

        for($i=0; $i < count($rows); $i++) {

            $data[$i]['username'] = $rows[$i]->users->name;
            $data[$i]['registration_date'] = date("jS F, Y", strtotime($rows[$i]->users->created_at));
            $data[$i]['packages'] = $rows[$i]->packages->name;
            $data[$i]['request_date'] = date("jS F, Y", strtotime($rows[$i]->request_date));
            $data[$i]['status'] = $status;
        }

        return response()->json($data, 202);
    }
}
