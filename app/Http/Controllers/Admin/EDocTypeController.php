<?php

namespace App\Http\Controllers\Admin;

use App\EDocType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
class EDocTypeController extends Controller
{

    public function index(Request $request){

        $title = ' E Doc Type';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
//				$('#status option:selected').val('0');
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
        }

        $rows = EDocType::Search(Session::get('search'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/edoc_type/index', compact('rows', 'title', 'extrajs'));
    }


    public function create()
    {
        $title = 'Add E-Doc Type ';
        return view('admin.edoc_type.create', compact('title') );
    }


    public function store(Request $request)
    {

        $input = $request->all();

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Name is required!',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/e-doc-type/create')->withErrors($validator)->withInput();
        }


        $e_doc_type = EDocType::create($input);

        if ($e_doc_type->id > 0) {
            $message = 'New '.  $e_doc_type->name.'  added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .' adding fail.';
            $error = true;
        }

        return redirect('admin/e-doc-type')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = EDocType::findOrFail($id);
        $title = 'Edit details';
        return view('admin.edoc_type.edit',compact('title', 'row'));
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
        $model = EDocType::findOrFail($id);

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => ' Name is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/e-doc-type/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $model->update($input);


        if ($model->id > 0) {
            $message = $model->name.'Successfully updated.';
            $error = false;
        } else {
            $message =  $request->get('name') .'updating fail.';
            $error = true;
        }

        return redirect('admin/e-doc-type')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = EDocType::findOrFail($id);

        $title = 'E-Doc Type details';
        return view('admin.edoc_type.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = EDocType::where('id',$id)->first();

        $message =  $model->name.' deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
