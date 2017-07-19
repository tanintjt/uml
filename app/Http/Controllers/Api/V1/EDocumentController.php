<?php

namespace App\Http\Controllers\api\V1;

use App\EDocType;
use App\EDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;
use File;
use Carbon\Carbon;

class EDocumentController extends Controller
{


    public function index(Request $request){

        /*$rows =EDocument::join('e_doc_type','e_documents.doc_type_id', '=', 'e_doc_type.id')
            ->EDoc($request->input('type'))
            ->select('e_doc_type.name','e_documents.issue_date','e_documents.expiry_date','e_documents.file')
            ->get();

        return response()->json($rows, 200);*/

        $rows = EDocument::join('e_doc_type','e_documents.doc_type_id', '=', 'e_doc_type.id')
            ->EDoc($request->input('type'))
            ->select('e_documents.id','e_documents.issue_date','e_documents.expiry_date','e_documents.file','e_doc_type.name')
            ->get();

        $result = [];

        for( $i = 0; $i< count($rows); $i++) {

            $result[$i]['id'] = $rows[$i]->id;
            $result[$i]['name'] = $rows[$i]->name;
            $result[$i]['file'] = $rows[$i]->file;
            $result[$i]['issue_date'] = date("jS F, Y", strtotime($rows[$i]->issue_date));
            $result[$i]['expiry_date'] = date("jS F, Y", strtotime($rows[$i]->expiry_date));
        }

        return response()->json($result, 202);
    }


    public function store(Request $request) {


        $file = Input::file('file');

        $rules = [
            'type'   => 'required',
            //'issue_date' => 'required',
            //'expiry_date' => 'required',
            'file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg',
        ];

        $messages = [
            'type.required'    => 'Type is required!',
            'issue_date.required' => ' Issue Date is required!',
            'expiry_date.required' => ' Expiry Date is required!',
            'file.required' => ' File is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $result = $validator->errors()->all();

            return response()->json($result, 400);
        }

       /* $doc_type_exists = EDocument::where('doc_type_id','=',$request->input('doc_type_id'))
            ->exists();

         if($doc_type_exists){
             return response()->json(['error' => true, 'result' => 'Already added. Please try another one!!!' ], 200);
         }*/
//         else{

             // Files destination
             $destinationPath = 'public/uploads/e_documents/';

             // Create folders if they don't exist
             if ( !file_exists($destinationPath) ) {
                 mkdir ($destinationPath, 775);
             }

             $file_original_name = $file->getClientOriginalName();
             $file_name = rand(11111, 99999) . $file_original_name;
             $file->move($destinationPath, $file_name);
             //$file = 'public/uploads/e_documents/' . $file_name;

             $data = [
                 'issue_date' => Carbon::parse($request->input('issue_date'))->format('Y-m-d'),
                 'expiry_date' => Carbon::parse($request->input('expiry_date'))->format('Y-m-d'),
                 'file'=> 'public/uploads/e_documents/' . $file_name,
                 'doc_type_id' => $request->input('type'),
                 'params' => $request->input('issue_date') . ' : ' . $request->input('expiry_date'),
             ];

             $doc = EDocument::create($data);
//        }

        if ($doc->id > 0) {

            $message = 'Successfully  Added';
            $error = false;
        } else {
            $message =  'adding fail.';
            $error = true;
        }

        return response()->json($message, 202);
    }



    public function update(Request $request, $id)
    {

        $model = EDocument::findOrFail($id);

        $rules = [
//            'issue_date'      => 'required',
//            'expiry_date'      => 'required',
            'file'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
//            'issue_date.required'     => 'Issue Date is required!',
//            'expiry_date.required'    => 'Expiry Date is required!',
           // 'file.required' => 'File is required!',
            'file.mimes' => 'Invalid File Format !',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json(['error' => true, 'result' => $result ], 400);
        }
        //return Carbon::parse($request->input('issue_date'))->format('Y/m/d');


            // Files destination
            $destinationPath = 'public/uploads/e_documents/';

            $file = $request->file('file');
            //$file_original_name = $file->getClientOriginalName();
            //$file_name = rand(11111, 99999) . $file_original_name;

            $file_name = time(). '_'. str_random(4).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $file_name);

            $data = [
                'issue_date' => Carbon::parse($request->input('issue_date'))->format('Y/m/d'),
                'expiry_date' => Carbon::parse($request->input('expiry_date'))->format('Y/m/d'),
                'file' => 'public/uploads/e_documents/' . $file_name,
                'doc_type_id' => $request->input('doc_type_id')
            ];

        $model->update($data);


            if ($model) {
                $result = 'Successfully Updated';
                $http_code = 201;
            } else {
                $result = 'Request failed.';
                $http_code = 500;
            }
            return response()->json($result, $http_code);


    }

}
