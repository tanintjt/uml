<?php

namespace App\Http\Controllers\Api\V1;

use App\SparePartsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SparePartsCategoryController extends Controller
{


    public function index(Request $request)
    {
        $rows = SparePartsCategory::get();
        $result['Spare Parts Category'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);
    }
}
