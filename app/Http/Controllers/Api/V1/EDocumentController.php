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
class EDocumentController extends Controller
{


    public function index(Request $request){

        $rows =EDocument::join('e_doc_type','e_documents.doc_type_id', '=', 'e_doc_type.id')
            ->EDoc($request->input('type'))
            ->select('e_doc_type.name','e_documents.issue_date','e_documents.expiry_date','e_documents.file')
            ->get();

        return response()->json($rows, 200);
    }


    public function store(Request $request) {

        $input = $request->all();

        $file = Input::file('file');

        $rules = [
            'doc_type_id'   => 'required',
            'issue_date' => 'required',
            'expiry_date' => 'required',
            'file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg',
        ];

        $messages = [
            'doc_type_id.required'    => 'Type is required!',
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


        $doc_exists = EDocument::where('doc_type_id','=',$request->doc_type_id)->exists();

        /*if($doc_exists){

            $edoc = EDocument::where('doc_type_id','=',$request->doc_type_id)->first();

            $oldfile = public_path().'public/uploads/e_documents/'.$edoc->file;

            if( $request->input('file') != $edoc->file) {
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

        }*/

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

    public function update(Request $request, $type)
    {

        $edoc_type_id = EDocType::where('name','=',$type)->first();

        $input = [];
        $file = $request->file('file');

        if($edoc_type_id){
            $edocs = EDocument::where('doc_type_id','=',$edoc_type_id->id)->first();

            if(!$edocs->id) {
                return response()->json(['error' => true, 'result' => ' not found'], 404);
            }
        }

        $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');


        $validator = Validator::make(array('file' => $file), $rules);

        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json(['error' => true, 'result' => $result ], 400);
        }

        /*
        if($request->hasFile('file')) {
            $rules['file'] = 'mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub';
            $messages['file.mimes'] = 'File is required!';
        }*/


        $oldfile = public_path().'public/uploads/e_documents/'.$edocs->img;

        if($request->hasFile('file')){
            //Delete previous image
            if( $request->input('file') != $edocs->file) {
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

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


        $edocs->update($input);

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
