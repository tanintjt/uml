<?php

namespace App\Http\Controllers\api\V1;

use App\EDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;

class EDocumentController extends Controller
{


    public function index(Request $request){

        $rows =EDocument::join('e_doc_type','e_documents.doc_type_id', '=', 'e_doc_type.id')
            ->EDoc($request->input('doc_type_id'))
            ->select('e_doc_type.name','e_documents.issue_date','e_documents.expiry_date','e_documents.file')
            ->get();

        return response()->json($rows, 200);
    }


    public function store(Request $request) {

        $input = $request->all();

        $file = Input::file('file');

        $rules = [
            'doc_type_id'   => 'not_in:0',
            'issue_date' => 'required',
            'expiry_date' => 'required',
            'file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg',
        ];

        $messages = [
            'doc_type_id.not_in'    => 'Type is required!',
            'issue_date.required' => ' Issue Date is required!',
            'expiry_date.required' => ' Expiry Date is required!',
            'file.required' => ' File is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $result = $validator->errors()->all();

            return response()->json($result, 400);
        }

        // Files destination
        $destinationPath = 'public/uploads/e_documents/';

        // Create folders if they don't exist
        if ( !file_exists($destinationPath) ) {
            mkdir ($destinationPath, 775);
        }

        $file_original_name = $file->getClientOriginalName();
        $file_name = rand(11111, 99999) . $file_original_name;
        $file->move($destinationPath, $file_name);
        $input['file'] = 'public/uploads/e_documents/' . $file_name;

        $doc = EDocument::create($input);

        if ($doc) {
            $result = 'Successfully Saved';
            $http_code = 201;
        } else {
            $result = 'Request failed.';
            $http_code = 500;

        }
        return response()->json($result, $http_code);
    }

    public function update(Request $request, $id)
    {
        //$user = Auth::user();
        $input = $request->all();

        $edocs = EDocument::find($id);

        if(!$edocs) {
            return response()->json(['error' => true, 'result' => ' not found' ], 404);
        }

        $rules = [
            'doc_type_id'   => 'not_in:0',
            'issue_date'      => 'required',
            'expiry_date'      => 'required',
           // 'file'      => 'mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub',
        ];

        $messages = [
            'doc_type_id.not_in'    => 'Type is required!',
            'issue_date.required'     => 'Issue Date is required!',
            'expiry_date.required'    => 'Expiry Date is required!',
            'file.required' => 'File is required!',
        ];


        $file = Input::file('file');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $result = $validator->errors()->all();

            return response()->json($result, 400);
        }


        if(count($file)>0){
            //Delete previous image from folder
            //unlink($model->file);

            // Files destination
            $destinationPath = 'public/uploads/e_documents/';

            // Create folders if they don't exist
            if ( !file_exists($destinationPath) ) {
                mkdir ($destinationPath, 0777);
            }

            $file_original_name = $file->getClientOriginalName();
            $file_name = rand(11111, 99999) . $file_original_name;
            $file->move($destinationPath, $file_name);
            $input['file'] = 'public/uploads/e_documents/' . $file_name;
        }

        $data = array(
            'doc_type_id'     => $request->input('doc_type_id'),
            'issue_date'          => $request->input('issue_date'),
            'expiry_date'          => $request->input('expiry_date'),
            'file'          => $input['file'],
        );

        $edocs->update($data);

        if ($edocs) {
            $result = 'Successfully Saved';
            $http_code = 201;
        } else {
            $result = 'Request failed.';
            $http_code = 500;

        }
        return response()->json($result, $http_code);
    }




}
