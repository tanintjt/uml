<?php

namespace App\Http\Controllers\Api\V1;

use App\SpecCategory;
use App\SpecDetails;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SpecDetailsController extends Controller
{

    public function index(Request $request){


       /*$spec_rows = SpecCategory::select('spec_category.title')
                   ->join('spec_details', 'spec_details.cat_id', '=', 'spec_category.id')
                   ->where('vehicle_id',$request->input('id'))
                    ->groupBy('spec_category.title')
                    ->get();*/

        $spec_rows = SpecCategory::get();
        //  return $spec_rows;
        $value = [];
        for($i=0; $i < count($spec_rows); $i++) {
            $value[$i]['name'] = $spec_rows[$i]->title;
            foreach ($spec_rows[$i]->spec_details as $val) {
                $value[$i]['elems'][$val->title] = $val->value;
            }
        }
        //return $value;
        $rows = Vehicle::where('id',$request->input('id'))
            ->select('vehicle.id')
            ->orderBy('id', 'desc')
            ->get();
        $data = [];
        for($i=0; $i < count($rows); $i++) {
            $data[$i]['colors'] = $rows[$i]->colors;
            $data[$i]['features'] = $rows[$i]->features;
            $data[$i]['specs'] =  $value;
        }
        return response()->json($data, 200);
    }



}
