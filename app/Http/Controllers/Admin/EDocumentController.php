<?php

namespace App\Http\Controllers\Admin;

use App\EDocType;
use App\EDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
class EDocumentController extends Controller
{


    public function index(Request $request)
    {
        $title = 'E Documents';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#type_id option:selected').val('0');
				$('#model_id option:selected').val('0');
				$('#brand_id option:selected').val('0');
				$('#admin-form').submit();
			});

			$('a[data-target=\"#confirmDelete\"]').on('click', function(e) {
				var target_modal = $(e.currentTarget).data('target');
				var href = $(this).attr('href');
				var message = $(e.currentTarget).attr('data-message');
				var title = $(e.currentTarget).attr('data-title');
				var modal = $(target_modal);
				$('#confirm').attr('href', href);

				modal.on('show.bs.modal', function () {
      				$(modal).find('.modal-body p').text(message);
					$(modal).find('.modal-title').text(title);
				}).modal();

				return false;
			});

			$('#confirm').click(function (e) {
			  e.preventDefault()
			  $('#confirmDelete').modal('hide');
			  window.location = $(this).attr('href');
			})

		});

		</script>";

        if ($request->isMethod('post')) {
            Session::put('search', $request->input('search'));
            Session::put('doc_type_id', $request->input('doc_type_id'));
        }

        $doc_type = $this->docTypeList();
        //print_r($doc_type);exit;

        $rows = EDocument::with('doc_type')->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/e_documents/index', compact('rows', 'title', 'doc_type','model','brand','extrajs'));
    }



    public function create()
    {
        $title = 'Add E Document';

        $doc_type = $this->docTypeList(true);

        return view('admin.e_documents.create', compact('title', 'doc_type') );
    }

	public function store(Request $request)
	{

		$input = $request->all();


		$rules = [
			'doc_type_id'   => 'not_in:0',
			'issue_date'      => 'required',
			'expiry_date'      => 'required',
			'file'      => 'required',
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
			return redirect('admin/e-documents/create')->withErrors($validator)->withInput();
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
//        $input['vehicle_image'] = date('Y-m-d h:i:s', time()).'  '.$file_name;
		$input['file'] = 'public/uploads/e_documents/' . $file_name;

		$vehicle = EDocument::create($input);

		if ($vehicle->id > 0) {

			$message = 'Successfully Added';
			$error = false;
		} else {
			$message =  'Adding fail.';
			$error = true;
		}

		return redirect('admin/e-documents')->with(['message' => $message, 'error' => $error]);
	}


	public function show($id)
	{
		$row = EDocument::findOrFail($id);

		$title = 'E-Document details';
		return view('admin.e_documents.view',compact('title', 'row'));
	}


	public function edit($id)
	{
		$row = EDocument::findOrFail($id);
		$title = 'Edit details';

		$doc_type = $this->docTypeList(true);

		return view('admin.e_documents.edit',compact('title', 'row', 'doc_type'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function update(Request $request, $id)
	{
		$input = $request->all();

		$model = EDocument::findOrFail($id);

		$rules = [
			'doc_type_id'   => 'not_in:0',
			'issue_date'      => 'required',
			'expiry_date'      => 'required',
			'file'      => 'mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub',
		];

		$messages = [
			'doc_type_id.not_in'    => 'Type is required!',
			'issue_date.required'     => 'Issue Date is required!',
			'expiry_date.required'    => 'Expiry Date is required!',
			//'file.required' => 'File is required!',
		];


		$file = Input::file('file');

		$validator = Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {

			return redirect('admin/e-documents/'.$id.'/edit')->withErrors($validator)->withInput();
		}

		if(count($file)>0){
			//Delete previous image from folder
			unlink($model->file);

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

		$model->update($input);

		if ($model->id > 0) {
			$message ='Successfully updated.';
			$error = false;
		} else {
			$message =  'updating fail.';
			$error = true;
		}

		return redirect('admin/e-documents')->with(['message' => $message, 'error' => $error]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{

		$user = EDocument::findOrFail($id);

		$user->delete();
		$message =  ' Successfully deleted';
		$error = true ;

		return redirect('admin/e-documents')->with(['message' => $message, 'error' => $error]);
	}



    private function docTypeList($boolean = false)
    {
        $rows = EDocType::orderBy('id', 'ASC')->get();

        $type[0] = ($boolean == true ? 'Select a type' : 'All type');

        foreach($rows as $row):
            $type[$row->id] = $row->name;
        endforeach;

        return $type;
    }
}
