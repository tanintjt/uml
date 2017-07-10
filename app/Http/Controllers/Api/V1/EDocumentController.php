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

        $result['E Documents'] = $rows;

        return response()->json(['error' => false, 'result' => $result ], 200);
    }



    public function store(Request $request) {

        $input = $request->all();

        $file = Input::file('file');

        $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');

        $validator = Validator::make(array('file' => $file), $rules);

        if ($validator->passes()) {

            $img_data = file_get_contents($file);
            pathinfo($file, PATHINFO_EXTENSION);
            $base64 = base64_encode($img_data);


            $doc = EDocument::create([
                'file' => $base64,
                'doc_type_id' => $request->doc_type_id,
                'issue_date' => $request->issue_date,
                'expiry_date' => $request->expiry_date,
            ]);

            if ($doc) {
                $result = 'Successfully Saved';
                $error = false;
                $http_code = 201;
            } else {
                $result = 'Request failed.';
                $http_code = 500;
                $error = true;
            }
            return response()->json(['error' => $error, 'result' => $result], $http_code);
        }
    }


}
