<?php

namespace App\Http\Controllers\api\V1;

use App\ServicePackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicePackageController extends Controller
{


    public function index(){

        $rows = ServicePackage::get();
        $result['Service Package'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);
    }

}
