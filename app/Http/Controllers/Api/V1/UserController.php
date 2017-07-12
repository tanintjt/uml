<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{


    public function user_profile(Request $request){

        $row = $request->user();
        $result['user'] = [
            'name' => $row->name,
            'email' => $row->email,
            'phone' => $row->phone,
        ];
        return response()->json($result, 202);

    }
}
