<?php

namespace App\Http\Controllers\api\V1;

use App\Brochure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
class BrochureController extends Controller
{
    public function index(){

        $rows = Brochure::get();
        return response()->json($rows, 200);
    }

}
