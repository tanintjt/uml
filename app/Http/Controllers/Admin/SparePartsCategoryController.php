<?php

namespace App\Http\Controllers\Admin;

use App\SparePartsCategory;
use App\SparePatrsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
class SparePartsCategoryController extends Controller
{


    public function index(Request $request){

        $title = 'Spare Parts Category';
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

        $rows = SparePartsCategory::Search(Session::get('search'))->
        // Status(Session::get('status'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/spare_parts_category/index', compact('rows', 'title', 'extrajs'));
    }


    public function create()
    {
        $title = 'Add Spare Parts Category';
        return view('admin.spare_parts_category.create', compact('title') );
    }


    public function store(Request $request)
    {

        $input = $request->all();

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => ' Name is required!',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/spare-parts-category/create')->withErrors($validator)->withInput();
        }


        $sp_cat = SparePartsCategory::create($input);

        if ($sp_cat->id > 0) {
            $message = 'New '.  $sp_cat->name.' Spare Parts Category added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .'Spare Parts Category adding fail.';
            $error = true;
        }

        return redirect('admin/spare-parts-category')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = SparePartsCategory::findOrFail($id);
        $title = 'Edit details';
        return view('admin.spare_parts_category.edit',compact('title', 'row'));
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
        $model = SparePartsCategory::findOrFail($id);

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => ' Name is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/spare-parts-category/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $model->update($input);


        if ($model->id > 0) {
            $message = $model->name.'Spare Parts Category Successfully updated.';
            $error = false;
        } else {
            $message =  $request->get('name') .'Spare Parts Category updating fail.';
            $error = true;
        }

        return redirect('admin/spare-parts-category')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = SparePartsCategory::findOrFail($id);

        $title = 'Spare Parts Category details';
        return view('admin.spare_parts_category.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = SparePartsCategory::where('id',$id)->first();

        $message =  $model->name.' deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }

}
