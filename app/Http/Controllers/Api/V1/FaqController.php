<?php

namespace App\Http\Controllers\api\V1;

use App\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class FaqController extends Controller
{


    public function index(){

        $rows = Faq::get();
        $result['Faq'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);
    }



    public function store(Request $request) {

        $user = Auth::user();

        $input = $request->all();

        $file = Input::file('file');

        $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');

        $validator = Validator::make(array('file' => $file), $rules);

        if ($validator->passes()) {

            /*// Files destination
            $destinationPath = 'public/uploads/faqs/';

            $file_original_name = $file->getClientOriginalName();
            $file_name = rand(11111, 99999) . $file_original_name;
            $file->move($destinationPath, $file_name);
            $input['file'] = date('Y-m-d h:i:s', time()).'  '.$file_name;*/


            $img_data = file_get_contents($file);
            $type = pathinfo($file, PATHINFO_EXTENSION);
            $base64 = base64_encode($img_data);

            $faq = Faq::create([
                'file' => $base64,
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




    /*public function geocode(){

        $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address=102+Shaheed+Tajuddin+Ahmed+Ave%2C+Dhaka+1208&oq=102+Shaheed+Tajuddin+Ahmed+Ave%2C+Dhaka+1208&sensor=false');

        $output= json_decode($geocode);

        $lat = $output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;

        return response()->json(['lat' => $lat, 'long' => $long]);
    }*/




}
