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


       /* $spec_rows = SpecCategory::join('spec_details', 'spec_details.cat_id', '=', 'spec_category.id')->
        select([
            'spec_category.title as name','spec_details.title as title','spec_details.spec_value as value'
        ])->
                join('vehicle', function ($join) use($request){
                $join->on('vehicle.id', '=', 'spec_details.vehicle_id')-> where('vehicle_id',$request->input('id'));

            })->get();



        $value = [];
        for($i=0; $i < count($spec_rows); $i++) {

           $value[$i]['name'] = $spec_rows[$i]->title;

            foreach ($spec_rows as $val) {
                $value[$i]['elems'][$val->title] = $val->value;
            }
        }*/


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
            $data[$i]['spec_details'] =  $value;
        }

        return response()->json($data, 200);
    }




}
