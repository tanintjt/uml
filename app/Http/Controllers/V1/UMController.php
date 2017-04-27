<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UMController extends Controller
{
    public function index()
    {
        $title = 'Services';
        return view('services/index', compact('title'));
    }
}
