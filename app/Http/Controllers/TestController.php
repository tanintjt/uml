<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class TestController extends Controller
{



    public function index(){

        $date = Carbon::parse(json_decode('2017-07-18T18:00:00.000Z'))->format('Y-m-d H:i:s');

        //json_decode($json)
        //json_decode($json)
        dd($date);
    }
}
