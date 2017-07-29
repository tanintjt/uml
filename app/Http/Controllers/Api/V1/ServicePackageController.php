<?php

namespace App\Http\Controllers\api\V1;

use App\ServicePackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicePackageController extends Controller
{


    public function index(Request $request){

        $rows =ServicePackage::
        join('service_package_type','service_package.package_type_id', '=', 'service_package_type.id')
            ->SP($request->input('type'))
            ->select('service_package_type.name as category_name','service_package.name as package_name')
            ->get();

        return response()->json($rows, 200);
    }

}
