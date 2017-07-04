<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
class BrandController extends Controller
{


    public function index(Request $request){

        $title = 'Brand';
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

        $rows = Brand::Search(Session::get('search'))->
        // Status(Session::get('status'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/brand/index', compact('rows', 'title', 'extrajs'));
    }


    public function create()
    {
        $title = 'Add Brand';
        return view('admin.brand.create', compact('title') );
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

            return redirect('admin/brand/create')->withErrors($validator)->withInput();
        }


        $brand = Brand::create($input);

        if ($brand->id > 0) {
            $message = 'New '.  $brand->name.'  brand added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .' brand adding fail.';
            $error = true;
        }

        return redirect('admin/brand')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = Brand::findOrFail($id);
        $title = 'Edit details';
        return view('admin.brand.edit',compact('title', 'row'));
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
        $model = Brand::findOrFail($id);

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => ' Name is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/brand/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $model->update($input);


        if ($model->id > 0) {
            $message = $model->name.'  Brand Successfully updated.';
            $error = false;
        } else {
            $message =  $request->get('name') .'  Brand updating fail.';
            $error = true;
        }

        return redirect('admin/brand')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = Brand::findOrFail($id);

        $title = 'Brand details';
        return view('admin.brand.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = Brand::where('id',$id)->first();

        $message =  $model->name.' Brand deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
