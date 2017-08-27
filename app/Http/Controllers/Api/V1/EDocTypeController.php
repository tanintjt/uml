<?php

namespace App\Http\Controllers\api\V1;

use App\EDocType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class EDocTypeController extends Controller
{


    public function index(Request $request)
    {
        $rows = EDocType::get();

        return response()->json($rows, 200);
    }

}
