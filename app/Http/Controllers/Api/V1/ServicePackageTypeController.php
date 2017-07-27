<?php

namespace App\Http\Controllers\Api\V1;

use App\ServicePackageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicePackageTypeController extends Controller
{

    public function index(Request $request)
    {
        $rows = ServicePackageType::get();

        return response()->json($rows, 200);
    }
}
