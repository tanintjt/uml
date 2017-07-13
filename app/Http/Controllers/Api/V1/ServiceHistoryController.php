<?php

namespace App\Http\Controllers\Api\V1;

use App\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class ServiceHistoryController extends Controller
{


    public  function index(Request $request){

        $user = $request->user();
        $row = ServiceRequest::with('users','service_package')
            ->where('user_id',$user->id)
            ->get();


        return $row;
    }
}
