<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    
    public function index(Request $request)
    {
        $brands = \App\Brand::paginate(10);
        return response(array(
                'error' => false,
                'brands' =>$brands->toArray(),),200);       
    } 
}

