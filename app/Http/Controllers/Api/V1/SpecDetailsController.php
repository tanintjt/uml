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


        $specs = SpecCategory::orderBy('title', 'asc')->get();

        $value = [];
        for($i=0; $i < count($specs); $i++) {
            $value[$i]['name'] = $specs[$i]->title;
            $value[$i]['elems'] = $this->getDetails($specs[$i]->id, $request->input('id'));
        }

        $rows = Vehicle::where('id',$request->input('id'))
            ->select('vehicle.id')
            ->orderBy('id', 'desc')
            ->get();
        $data = [];
        foreach ($rows as $row) {

            for ($j=0; $j < count($row->colors); $j++) {
                $data['colors'][$j]['img']    =    asset('public/uploads/vehicle/colors/'.$row->colors[$j]->img);
                $data['colors'][$j]['hex']    =    $row->colors[$j]->hex;
            }

            for ($k=0; $k < count($row->features); $k++) {
                $data['features'][$k]['img']    =    asset('public/uploads/vehicle/features/'.$row->features[$k]->img);
                $data['features'][$k]['sub']    =    $row->features[$k]->sub;
            }

            $data['specs']     =     $value;
        }
        return response()->json($data, 200);
    }

    public function getDetails($catid, $vehicleid) {

        $rows = SpecDetails::select('title', 'spec_value')
            ->where('cat_id', $catid)->where('vehicle_id', $vehicleid)->get();
        $elms = [];
        foreach($rows as $row) {
            $elms[$row->title] = $row->spec_value;
        }
        return $elms;
    }



}
