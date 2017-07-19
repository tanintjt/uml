<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class TestController extends Controller
{



    public function index(){

        $date = Carbon::parse('2017-07-18T18:00:00.000Z')->format('Y-m-d');

        dd($date);
    }
}
