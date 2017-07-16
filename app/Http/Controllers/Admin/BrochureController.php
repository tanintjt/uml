<?php

namespace App\Http\Controllers\Admin;

use App\Brochure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
class BrochureController extends Controller
{


    public function index(Request $request)
    {
        $title = 'Brochure';
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
            // Session::put('status', $request->input('status'));
            Session::put('search', $request->input('search'));
        }

        $rows = Brochure::Search(Session::get('search'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));


        return view('admin/brochure/index', compact('rows', 'title','extrajs'));
    }


    public function create()
    {
        $title = 'Add Brochure';
        return view('admin.brochure.create', compact('title') );
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

            return redirect('admin/brochure/create')->withErrors($validator)->withInput();
        }

        // Files destination
        $destinationPath = 'public/uploads/brochure/';

        // Create folders if they don't exist
        if ( !file_exists($destinationPath) ) {
            mkdir ($destinationPath, 775);
        }

        $file_original_name = $file->getClientOriginalName();
        $file_name = rand(11111, 99999) . $file_original_name;
        $file->move($destinationPath, $file_name);
        $input['file'] = 'public/uploads/brochure/' . $file_name;


        $brochure = Brochure::create($input);

        if ($brochure->id > 0) {
            $message = 'New '.  $brochure->title.' Brochure added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('title') .'Brochure adding fail.';
            $error = true;
        }

        return redirect('admin/brochure')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = Brochure::findOrFail($id);
        $title = 'Edit details';
        return view('admin.brochure.edit',compact('title', 'row'));
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

        $model = Brochure::findOrFail($id);

        $rules = [
            'title' => 'required',
            'file' => 'mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub'
        ];

        $messages = [
            'title.required' => 'Title is required!',
            //'file.required' => 'File is required!',
        ];


        $file = Input::file('file');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/brochure/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        if(count($file)>0){
            //Delete previous image from folder
            unlink($model->file);

            // Files destination
            $destinationPath = 'public/uploads/brochure/';

            // Create folders if they don't exist
            if ( !file_exists($destinationPath) ) {
                mkdir ($destinationPath, 0777);
            }

            $file_original_name = $file->getClientOriginalName();
            $file_name = rand(11111, 99999) . $file_original_name;
            $file->move($destinationPath, $file_name);
            $input['file'] = 'public/uploads/brochure/' . $file_name;
        }

        $model->update($input);

        if ($model->id > 0) {
            $message ='Successfully updated.';
            $error = false;
        } else {
            $message =  'updating fail.';
            $error = true;
        }

        return redirect('admin/brochure')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = Brochure::findOrFail($id);

        $title = 'Brochure details';
        return view('admin.brochure.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = Brochure::where('id',$id)->first();

        $message =  $model->name.' deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
