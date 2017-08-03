<?php

namespace App\Http\Controllers\api\V1;

use App\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class FaqController extends Controller
{


    public function index(){

        $rows = Faq::get();
        return response()->json($rows, 200);
    }

}
