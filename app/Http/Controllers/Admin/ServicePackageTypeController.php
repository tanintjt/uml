<?php

namespace App\Http\Controllers\Admin;

use App\ServicePackageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Validator;
class ServicePackageTypeController extends Controller
{


    public function index(Request $request){

        $title = 'Service Package Type';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#status option:selected').val('0');
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
             Session::put('status', $request->input('status'));
            Session::put('search', $request->input('search'));
        }

        $rows = ServicePackageType::Search(Session::get('search'))->
         Status(Session::get('status'))->
         orderBy('id', 'asc')->
         paginate(config('app.limit'));

        return view('admin/service_package_type/index', compact('rows', 'title', 'extrajs'));
    }


    public function create()
    {
        $title = 'Add Service Package Type';

        return view('admin.service_package_type.create', compact('title', 'js', 'extrajs') );
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

            return redirect('admin/service-package-type/create')->withErrors($validator)->withInput();
        }


        $sp_cat = ServicePackageType::create($input);

        if ($sp_cat->id > 0) {
            $message = $sp_cat->name.' Successfully  added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .'Service Package Type adding fail.';
            $error = true;
        }

        return redirect('admin/service-package-type')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = ServicePackageType::findOrFail($id);
        $title = 'Edit details';

        return view('admin.service_package_type.edit',compact('title', 'row'));
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
        $model = ServicePackageType::findOrFail($id);

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => ' Name is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/service-package-type/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $model->update($input);


        if ($model->id > 0) {
            $message = $model->name.'Service Package Type Successfully updated.';
            $error = false;
        } else {
            $message =  $request->get('name') .'Service Package Type updating fail.';
            $error = true;
        }

        return redirect('admin/service-package-type')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = ServicePackageType::findOrFail($id);

        $title = 'Service Package Type details';

        return view('admin.service_package_type.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = ServicePackageType::where('id',$id)->first();

        $message =  $model->name.' deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
