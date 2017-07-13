<?php

namespace App\Http\Controllers\api\V1;

use App\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
class PromotionController extends Controller
{



    public function index()
    {

        $rows = Promotion::get();

        $result = [];
        for( $i = 0; $i< count($rows); $i++) {

            $result[$i]['id'] = $rows[$i]->id;
            $result[$i]['title'] = $rows[$i]->title;
            $result[$i]['file'] = $rows[$i]->file;
            $result[$i]['start_date'] = date("jS F, Y", strtotime($rows[$i]->start_date));
            $result[$i]['end_date'] = date("jS F, Y", strtotime($rows[$i]->end_date));
            $result[$i]['created_at'] = $rows[$i]->created_at;
            $result[$i]['updated_at'] = $rows[$i]->updated_at;
            /*
             *  "id": 5,
        "title": "pro1",
        "file": "public/uploads/promotions/77937CT-100.pdf",
        "start_date": "2017-07-03 00:00:00",
        "end_date": "2017-07-04 00:00:00",
        "created_at": "2017-07-13 14:36:50",
        "updated_at": "2017-07-13 14:38:34"
             */
            /*$result = [
                'title' => $row->title,
                'start_date' => date("jS F, Y", strtotime($row->start_date)),
                'end_date' => date("jS F, Y", strtotime($row->end_date)),
                'file' => $row->file,
            ];*/
        }

        return response()->json($result, 202);


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
