<?php

namespace App\Http\Controllers\Admin;

use App\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
class FaqController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Faq';
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


        $rows = Faq::
        orderBy('id', 'asc')->
        paginate(config('app.limit'));


        return view('admin/faq/index', compact('rows', 'title','extrajs'));
    }


    public function create()
    {
        $title = 'Add Faqs';
        return view('admin.faq.create', compact('title') );
    }


    public function store(Request $request)
    {

        $input = $request->all();

        $rules = [
            'title' => 'required',
            'file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub'
        ];

        $messages = [
            'title.required' => 'Title is required!',
            'file.required' => 'File is required!',
        ];

        $file = Input::file('file');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/faq/create')->withErrors($validator)->withInput();
        }

        // Files destination
        $destinationPath = 'public/uploads/faq/';

        // Create folders if they don't exist
        if ( !file_exists($destinationPath) ) {
            mkdir ($destinationPath, 777);
        }

        $file_original_name = $file->getClientOriginalName();
        $file_name = rand(11111, 99999) . $file_original_name;
        $file->move($destinationPath, $file_name);
        $input['file'] = 'public/uploads/faq/' . $file_name;


        $brochure = Faq::create($input);

        if ($brochure->id > 0) {
            $message = 'New '.  $brochure->title.' Faq added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('title') .'Faq adding fail.';
            $error = true;
        }

        return redirect('admin/faq')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = Faq::findOrFail($id);
        $title = 'Edit details';
        return view('admin.faq.edit',compact('title', 'row'));
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

        $model = Faq::findOrFail($id);

        $rules = [
            'title' => 'required',
            'file' => 'mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub'
        ];

        $messages = [
            'title.required' => 'Title is required!',
           // 'file.required' => 'File is required!',
        ];


        $file = Input::file('file');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/faq/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        if(count($file)>0){
            // Files destination
            $destinationPath = 'public/uploads/faq/';

            // Create folders if they don't exist
            if ( !file_exists($destinationPath) ) {
                mkdir ($destinationPath, 0777);
            }

            $file_original_name = $file->getClientOriginalName();
            $file_name = rand(11111, 99999) . $file_original_name;
            $file->move($destinationPath, $file_name);
            $input['file'] = 'public/uploads/faq/' . $file_name;
        }

        $model->update($input);

        if ($model->id > 0) {
            $message ='Successfully updated.';
            $error = false;
        } else {
            $message =  'updating fail.';
            $error = true;
        }

        return redirect('admin/faq')->with(['message' => $message, 'error' => $error]);
    }

    public function show($id){

        $row = Faq::findOrFail($id);

        $title = 'Faq details';
        return view('admin.faq.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = Faq::where('id',$id)->first();

        $message =  $model->name.'  deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
