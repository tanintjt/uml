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

        $data = [];

        for($i=0; $i < count($rows); $i++) {

            if($rows[$i]->status ==1){
                $status = 'Pending';
            }elseif ($rows[$i]->status ==2){
                $status = 'Accepted';
            }elseif ($rows[$i]->status ==3){
                $status = 'Reject';
            }elseif ($rows[$i]->status ==4){
                $status = 'Rescheduled';
            }else{
                $status = 'Done';
            }

            $data[$i]['username'] = $rows[$i]->users->name;
            $data[$i]['registration_date'] = date("jS F, Y", strtotime($rows[$i]->users->created_at));
            $data[$i]['packages'] = $rows[$i]->packages->name;
            $data[$i]['request_date'] = date("jS F, Y", strtotime($rows[$i]->request_date));
            $data[$i]['status'] = $status;
        }

        if ($data) {
            $result = $data;
            //$http_code = 201;

        } else {
            $result =  'No Data Found';
            //$http_code = 500;
        }

        return response()->json($result, 202);
    }
}
