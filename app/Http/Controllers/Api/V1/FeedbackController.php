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
            //'user_id'   => 'not_in:0',
            'subject' => 'required',
            'feedback_details' => 'required',
        ];

        $messages = [
            //'user_id.not_in'    => 'User is required!',
            'subject.required' => 'Subject is required!',
            'feedback_details.required' => 'Message is required!',
        ];

        $validator = Validator::make($request->all(),$rules, $messages);

        if ($validator->fails()) {

            $result = $validator->errors()->all();

            return response()->json(['error' => true, 'result' => $result], 400);
        }

         FeedBack::create(
            [
                'user_id'            => $user->id,
                'subject'            => $request->input('subject'),
                'feedback_details'   =>$request->input('feedback_details'),
            ]
        );
        return response()->json('Successfully added');
    }
}
