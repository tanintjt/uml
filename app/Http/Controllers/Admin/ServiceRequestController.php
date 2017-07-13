<?php

namespace App\Http\Controllers\Admin;

use App\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceRequestController extends Controller
{


    public function index(Request $request){

        $title = "Service Request";
        $user = $request->user();

        $rows = ServiceRequest::with('users','service_center','service_package')->get();

        return view('admin/service_request/index', compact('rows','title'));
    }

    public function status(Request $request,$id){

    }
}
