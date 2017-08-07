<?php

namespace App\Http\Controllers\Api\V1;

use App\NotificationHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationHistoryController extends Controller
{

    public function index()
    {
        $rows = NotificationHistory::get();

        $result = [];
        for( $i = 0; $i< count($rows); $i++) {
            $result[$i]['message'] = $rows[$i]->message;
            $result[$i]['creation_date'] = date("jS F, Y", strtotime($rows[$i]->created_at));
        }
        return response()->json($result, 202);

    }
}
