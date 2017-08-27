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

        /*$rows = EDocument::join('e_doc_type','e_documents.doc_type_id', '=', 'e_doc_type.id')
            ->EDoc($request->input('type'))
            ->where('user_id',$request->user()->id)
            ->select('e_documents.id',
                'e_documents.expiry_date','e_documents.file','e_doc_type.name')
            ->get();*/

        $rows = EDocument::EDoc($request->input('type'))
            ->where('user_id',$request->user()->id)
            ->get();

        $result = [];

        for( $i = 0; $i< count($rows); $i++) {

            $result[$i]['id'] = $rows[$i]->id;
            $result[$i]['name'] = $rows[$i]->type->name;
            $result[$i]['file'] = $rows[$i]->file;
            $result[$i]['expiry_date'] = date("jS F, Y", strtotime($rows[$i]->expiry_date));
        }

        return response()->json($result, 202);
    }


    public function findOrCreateDocument(Request $request)
    {

        $rules = [
            'expiry_date'      => 'required',
            'file'      => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
            'expiry_date.required'    => 'Expiry Date is required!',
            'file.required' => 'File is required!',
            'file.mimes' => 'Invalid File Format !',
            'file.max' => 'Invalid File Size !',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            $result = $validator->errors()->all();
            return response()->json($result , 400);
        }

        $file = $request->file('file');

        if($file){

            // Files destination
            $destinationPath = 'public/uploads/e_documents/';

            $file_name = time(). '_'. str_random(4).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $file_name);
        }

        $data = [
            'user_id'     =>     $request->user()->id,
            'expiry_date' =>     Carbon::parse($request->input('expiry_date'))->format('Y/m/d'),
            'file'        =>     'public/uploads/e_documents/' . $file_name,
            'doc_type_id' =>     $request->input('type')
        ];

        $eDoc = EDocument::where('user_id',$request->user()->id)->where('doc_type_id',$request->input('type'))->first();

        if ($eDoc) {

           if($eDoc->file){
               unlink($eDoc->file);
           }
            $eDoc->update($data);
        }
        else{
            $eDoc = EDocument::create($data);
        }
        if ($eDoc->id > 0) {

            $message = 'Successfully  Added';
            $http_code = 201;
        } else {
            $message =  'adding fail.';
            $http_code = 500;
        }

        return response()->json($message, $http_code);
    }

}
