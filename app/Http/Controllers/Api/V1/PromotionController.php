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

        }

        return response()->json($result, 202);


    }

}
