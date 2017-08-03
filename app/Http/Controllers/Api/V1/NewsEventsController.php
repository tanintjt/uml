<?php

namespace App\Http\Controllers\api\V1;

use App\NewsEvents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
class NewsEventsController extends Controller
{


    public function index(){

        $rows = NewsEvents::get();
        /*$result['News & Events'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);*/
        return response()->json($rows, 200);
    }

    public function store(Request $request) {


        $input = $request->all();
//print_r($input);exit;
        $file = Input::file('file');

        $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');

        $validator = Validator::make(array('file' => $file), $rules);

        if ($validator->passes()) {

            $img_data = file_get_contents($file);
            pathinfo($file, PATHINFO_EXTENSION);
            $base64 = base64_encode($img_data);


            $news = NewsEvents::create([
                'file' => $base64,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'title' => $request->title,
                'details' => $request->details,
            ]);

            if ($news) {
                $result = 'Successfully Saved';
                $error = false;
                $http_code = 201;
            } else {
                $result = 'Request failed.';
                $http_code = 500;
                $error = true;
            }
            return response()->json( $result, $http_code);
        }
    }

}
