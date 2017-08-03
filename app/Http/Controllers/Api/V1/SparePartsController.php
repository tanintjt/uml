<?php

namespace App\Http\Controllers\Api\V1;

use App\SpareParts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SparePartsController extends Controller
{

    public function index(Request $request){
        $rows = SpareParts::get();
        return response()->json($rows, 200);
    }
}
