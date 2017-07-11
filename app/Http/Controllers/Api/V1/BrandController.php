<?php

namespace App\Http\Controllers\Api\V1;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    
    public function index(Request $request)
    {
        $rows = Brand::get();
        /*$result['Brand'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);*/

        return response()->json($rows, 200);
    } 
}

