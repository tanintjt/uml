<?php

namespace App\Http\Controllers\Admin;

use App\NewsEvents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
class NewsEventsController extends Controller
{


    public function index(Request $request)
    {
        $title = 'News Events';
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


        $rows = NewsEvents::
        orderBy('id', 'asc')->
        paginate(config('app.limit'));


        return view('admin/news_events/index', compact('rows', 'title','extrajs'));
    }


    public function create()
    {
        $title = 'Add News Events';
        return view('admin.news_events.create', compact('title') );
    }


    public function store(Request $request)
    {

        $input = $request->all();

        $rules = [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub'
        ];

        $messages = [
            'title.required' => 'Title is required!',
            'file.required' => 'File is required!',
            'start_date.required' => 'Start Date is required!',
            'end_date.required' => 'End Date is required!',
        ];

        $file = Input::file('file');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/news-events/create')->withErrors($validator)->withInput();
        }

        // Files destination
        $destinationPath = 'public/uploads/news_events/';

        // Create folders if they don't exist
        if ( !file_exists($destinationPath) ) {
            mkdir ($destinationPath, 775);
        }

        $file_original_name = $file->getClientOriginalName();
        $file_name = rand(11111, 99999) . $file_original_name;
        $file->move($destinationPath, $file_name);
        $input['file'] = 'public/uploads/news_events/' . $file_name;


        $brochure = NewsEvents::create($input);

        if ($brochure->id > 0) {
            $message = 'New '.  $brochure->title.'  added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('title') .' adding fail.';
            $error = true;
        }

        return redirect('admin/news-events')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = NewsEvents::findOrFail($id);
        $title = 'Edit details';
        return view('admin.news_events.edit',compact('title', 'row'));
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

        $model = NewsEvents::findOrFail($id);

        $rules = [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'file' => 'mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub'
        ];

        $messages = [
            'title.required' => 'Title is required!',
//            'file.required' => 'File is required!',
            'start_date.required' => 'Start Date is required!',
            'end_date.required' => 'End Date is required!',
        ];


        $file = Input::file('file');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/news-events/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        if(count($file)>0){
            //Delete previous image from folder
            unlink($model->file);

            // Files destination
            $destinationPath = 'public/uploads/news_events/';

            // Create folders if they don't exist
            if ( !file_exists($destinationPath) ) {
                mkdir ($destinationPath, 0777);
            }

            $file_original_name = $file->getClientOriginalName();
            $file_name = rand(11111, 99999) . $file_original_name;
            $file->move($destinationPath, $file_name);
            $input['file'] = 'public/uploads/news_events/' . $file_name;
        }

        $model->update($input);

        if ($model->id > 0) {
            $message ='Successfully updated.';
            $error = false;
        } else {
            $message =  'updating fail.';
            $error = true;
        }

        return redirect('admin/news-events')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = NewsEvents::findOrFail($id);

        $title = 'News Events details';
        return view('admin.news_events.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = NewsEvents::where('id',$id)->first();

        $message =  $model->name.' deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
