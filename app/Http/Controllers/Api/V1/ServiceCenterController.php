<?php

namespace App\Http\Controllers\api\V1;

use App\ServiceCenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceCenterController extends Controller
{


    public function index(){

        $rows = ServiceCenter::get();
        $result['Service Center'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);
    }


}
