<?php

namespace App\Http\Controllers\api\V1;

use App\FeedBack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class FeedbackController extends Controller
{

    public function index(Request $request){

        $user = $request->user();

        $rules = [
            'subject' => 'required',
            'feedback_details' => 'required',
        ];

        $messages = [
            'subject.required' => 'Subject is required!',
            'feedback_details.required' => 'Message is required!',
        ];

        $validator = Validator::make($request->all(),$rules, $messages);

        if ($validator->fails()) {

            $result = $validator->errors()->all();

            return response()->json($result, 400);
        }

        FeedBack::create(
            [
                'user_id'            => $user->id,
                'subject'            => $request->input('subject'),
                'feedback_details'   =>$request->input('feedback_details'),
            ]
        );

        return response()->json(
            [
                'status' => false,
                'message' => 'Thank you for your feedback.'
            ]
            , 201);
    }
}
