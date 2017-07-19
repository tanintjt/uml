<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class TestController extends Controller
{



    public function index(){

        $date = Carbon::parse('7/19/2017')->format('Y-m-d');

        dd($date);
    }
}
