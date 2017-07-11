<?php

namespace App\Http\Controllers\api\V1;

use App\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
class PromotionController extends Controller
{



    public function index(){

        $rows = Promotion::get();
        /*$result['Promotion'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);*/
        return response()->json($rows, 200);
    }



    public function store(Request $request) {


        $input = $request->all();

        $file = Input::file('file');

        $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');

        $validator = Validator::make(array('file' => $file), $rules);

        if ($validator->passes()) {

            $img_data = file_get_contents($file);
            $type = pathinfo($file, PATHINFO_EXTENSION);
            $base64 = base64_encode($img_data);

            $promotion = Promotion::create([
                'file' => $base64,
            ]);

            if ($promotion) {
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
