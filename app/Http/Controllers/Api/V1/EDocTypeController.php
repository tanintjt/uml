<?php

namespace App\Http\Controllers\api\V1;

use App\EDocType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class EDocTypeController extends Controller
{


    public function index(Request $request)
    {
        $rows = EDocType::get();

        return response()->json($rows, 200);
    }

    public function store(Request $request ){


        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'E-Doc Type is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json(['error' => true, 'result' => $result ], 400);
        }

        $data_exists = EDocType::where('name','=',$request->name)->exists();

        if($data_exists){
            return response()->json(['error' => true, 'result' => 'Already Added. Please try another one!!!' ], 200);
        }
        else{
            $data = EDocType::create(
                [
                    'name'   => $request->input('name'),
                ]
            );
        }
        if ($data) {
            $result = 'Successfully Sent Request';
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
