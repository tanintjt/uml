<?php

namespace App\Http\Controllers\Api\V1;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class BrandController extends Controller
{
    
    public function index(Request $request)
    {
        //'2012-9-5 23:26:11.123789'
        //$input = "Wed, Mar 9 2017 06:00:00" ;
        //$date = Carbon::parse($input);
        //dd($date->format('Y-m-d H:i:s'));

        $rows = Brand::get();

        return response()->json($rows, 200);
    } 
}

