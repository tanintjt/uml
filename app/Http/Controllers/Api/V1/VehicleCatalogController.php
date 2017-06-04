<?php

namespace App\Http\Controllers\api\V1;

use App\VehicleCatalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;
class VehicleCatalogController extends Controller

{

    public function index(Request $request){

        $rows = DB::table('vehicle_catalog')
            ->join('vehicle_type','vehicle_catalog.vehicle_type', '=', 'vehicle_type.id')
            ->join('vehicle_model','vehicle_catalog.vehicle_model', '=', 'vehicle_model.id')
            ->join('vehicle', 'vehicle_catalog.vehicle_id', '=', 'vehicle.id')
            ->join('brands', 'vehicle_catalog.brand_id', '=', 'brands.id')
            ->where('vehicle_catalog.vehicle_type',$request->vehicle_type)
            ->where('vehicle_catalog.vehicle_id',$request->vehicle_id)
            ->where('vehicle_catalog.brand_id',$request->brand_id)
            ->where('vehicle_catalog.vehicle_model',$request->vehicle_model)
            ->select('vehicle_type.name','vehicle_model.name as model','vehicle_catalog.vehicle_image')
            ->get();

        $result['Vehicle Catalog'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);
    }


    public function store(Request $request) {

        $user = Auth::user();

        $input = $request->all();

        $file = Input::file('vehicle_image');

        $rules = array('vehicle_image' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');

        $validator = Validator::make(array('vehicle_image' => $file), $rules);

        if ($validator->passes()) {

            $img_data = file_get_contents($file);
            pathinfo($file, PATHINFO_EXTENSION);
            $base64 = base64_encode($img_data);


            $faq = VehicleCatalog::create([
                'vehicle_image' => $base64,
                'vehicle_type' => $request->vehicle_type,
                'vehicle_id' => $request->vehicle_id,
                'brand_id' => $request->brand_id,
                'vehicle_model' => $request->brand_id,
            ]);

            if ($faq) {
                $result = 'Successfully Saved';
                $error = false;
                $http_code = 201;
            } else {
                $result = 'Request failed.';
                $http_code = 500;
                $error = true;
            }
            return response()->json(['error' => $error, 'result' => $result], $http_code);
        }
     }

}
