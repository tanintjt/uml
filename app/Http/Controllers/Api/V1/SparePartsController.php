<?php

namespace App\Http\Controllers\Api\V1;

use App\SpareParts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SparePartsController extends Controller
{


    public function index(Request $request){

        /*$rows =SpareParts::join('spare_parts_category','spare_parts.sp_cat_id', '=', 'spare_parts_category.id')
            ->leftjoin('spare_category','spare_parts.id', '=', 'spare_category.sp_id')
            ->SP($request->input('sp_cat_id'))
            ->select('spare_parts.name','spare_parts.part_id','spare_parts.rate','spare_parts_category.name as Category','spare_category.file')
            ->get();*/

        $rows = SpareParts::get();


        return response()->json($rows, 200);
    }
}
