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

        $doc_type_exists = EDocument::where('doc_type_id','=',$request->input('doc_type_id'))
            ->exists();

         if($doc_type_exists){
             return response()->json(['error' => true, 'result' => 'Already added. Please try another one!!!' ], 200);
         }
         else{

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


             //$doc_exists = EDocument::where('doc_type_id','=',$request->doc_type_id)->exists();

             /*if($doc_exists){

                 $edoc = EDocument::where('doc_type_id','=',$request->doc_type_id)->first();

                 $oldfile = public_path().'public/uploads/e_documents/'.$edoc->file;

                 if( $request->input('file') != $edoc->file) {
                     if (File::exists($oldfile)) {
                         File::delete($oldfile);
                     }
                 }

             }*/
             $data = [
                 'issue_date' => Carbon::parse($request->input('issue_date')),
                 'expiry_date' => Carbon::parse($request->input('expiry_date')),
                 'file'=> 'public/uploads/e_documents/' . $file_name,
                 'doc_type_id'=>$request->input('doc_type_id')
             ];

             $doc = EDocument::create($data);
        }


        if ($doc->id > 0) {
            //$message = 'New '.  $data['issue_date'].' And '.$data['expiry_date'].'  Added';
            $message = 'Successfully  Added';
            $error = false;
        } else {
            $message =  'adding fail.';
            $error = true;
        }

        return response()->json($message, 202);
    }



    public function update(Request $request,$type)
    {

        //$model = Promotion::findOrFail($id);

        $edoc_type_id = EDocType::where('name','=',$type)->first();

        $file = Input::file('file');


        $rules = [
//            'issue_date'      => 'required',
//            'expiry_date'      => 'required',
            //'file'      => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub',
        ];

        $messages = [
//            'issue_date.required'     => 'Issue Date is required!',
//            'expiry_date.required'    => 'Expiry Date is required!',
           // 'file.required' => 'File is required!',
           // 'file.mimes' => 'Invalid File Format !',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json(['error' => true, 'result' => $result ], 400);
        }


        if($edoc_type_id) {

            $edocs = EDocument::where('doc_type_id', '=', $edoc_type_id->id)->first();

            $oldfile = public_path() . 'public/uploads/e_documents/' . $edocs->file;

            if ($request->hasFile('file')) {
                //Delete previous image
                if ($request->input('file') != $edocs->file) {
                    if (File::exists($oldfile)) {
                        File::delete($oldfile);
                    }
                }

                // Files destination
                $destinationPath = 'public/uploads/e_documents/';

                // Create folders if they don't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }

                $file_original_name = $file->getClientOriginalName();
                $file_name = rand(11111, 99999) . $file_original_name;
                $file->move($destinationPath, $file_name);
                //$input['file'] = 'public/uploads/e_documents/' . $file_name;

                $data = [
                    'issue_date' => Carbon::parse($request->input('issue_date')),
                    'expiry_date' => Carbon::parse($request->input('expiry_date')),
                    'file'=> 'public/uploads/e_documents/' . $file_name,
                    'doc_type_id'=>$request->input('doc_type_id')
                ];

                $edocs->update($data);
            }

            if ($edocs) {
                //$result = 'New '.  $edocs->issue_date.' And '.$edocs->expiry_date. '  Updated';
                $result = 'Successfully Updated';
                $http_code = 201;
            } else {
                $result = 'Request failed.';
                $http_code = 500;
            }
            return response()->json($result, $http_code);
        }

        else {
            return response()->json(['error' => true, 'result' => 'Not Found'], 404);
        }

    }

}
