<?php

namespace App\Http\Controllers\api\V1;

use App\ServicePackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicePackageController extends Controller
{


    public function index(){

        $rows = ServicePackage::get();
        return response()->json($rows, 200);
    }

}
