<?php

namespace App\Http\Controllers\Admin;

use App\SpecCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Validator;

class SpecCategoryController extends Controller
{

    public function index(Request $request){

        $title = 'Specification Category';
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
            // Session::put('status', $request->input('status'));
            Session::put('search', $request->input('search'));
        }

        $rows = SpecCategory::
//        Search(Session::get('search'))->
        // Status(Session::get('status'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/spec_category/index', compact('rows', 'title', 'extrajs'));
    }


    public function create()
    {
        $title = 'Add Specification Category';
        return view('admin.spec_category.create', compact('title') );
    }


    public function store(Request $request)
    {

       $input = $request->all();

        $rules = [
            'title' => 'required',
        ];

        $messages = [
            'title.required' => ' Name is required!',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/spec/category/create')->withErrors($validator)->withInput();
        }

        $sp_cat = SpecCategory::create($input);

        if ($sp_cat->id > 0) {
            $message = 'New '.  ucfirst($sp_cat->title).' Category added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('title') .'Category adding fail.';
            $error = true;
        }

        return redirect('admin/spec/category')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = SpecCategory::findOrFail($id);
        $title = 'Edit details';
        return view('admin.spec_category.edit',compact('title', 'row'));
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
        $model = SpecCategory::findOrFail($id);

        $rules = [
            'title' => 'required',
        ];

        $messages = [
            'title.required' => ' Title is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/spec/category/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $model->update($input);


        if ($model->id > 0) {
            $message = ucfirst($model->title).'Category Successfully updated.';
            $error = false;
        } else {
            $message =  $request->get('title') .'Category updating fail.';
            $error = true;
        }

        return redirect('admin/spec/category')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = SpecCategory::findOrFail($id);

        $title = 'Specification Category details';
        return view('admin.spec_category.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = SpecCategory::where('id',$id)->first();

        $message =  $model->title.' deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
