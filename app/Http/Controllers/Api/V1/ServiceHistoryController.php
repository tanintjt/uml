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

        if (count($rows) > 0) {
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
            $result = $data;
        } else {
            $data[0]['username'] = $request->user()->name;
            $data[0]['registration_date'] = date("jS F, Y", strtotime($request->user()->created_at));
            $data[0]['packages'] = 'No history found';
            $data[0]['request_date'] = date("jS F, Y", strtotime(Carbon::now()));
            $data[0]['status'] = 5;

            $result = $data;
        }

        return response()->json($result, 202);
    }
}
