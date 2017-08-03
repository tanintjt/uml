<?php

namespace App\Http\Controllers\Api\V1;

use App\ServicePackageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicePackageTypeController extends Controller
{

    public function index(Request $request)
    {
        $rows = ServicePackageType::where('status',1)->get();
        $data = [];
        for($i = 0; $i < count($rows); $i++) {
            $data[$i]['id'] = $rows[$i]->id;
            $data[$i]['name'] = $rows[$i]->name;
            $data[$i]['packages'] = $rows[$i]->packages;
        }

        return response()->json($data, 200);
    }
}
