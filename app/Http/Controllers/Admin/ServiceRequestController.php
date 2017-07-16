<?php

namespace App\Http\Controllers\Admin;

use App\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
class ServiceRequestController extends Controller
{


    public function index(Request $request){

       /* $title = "Service Request";
        $user = $request->user();

        $rows = ServiceRequest::with('users','service_center','service_package')->get();

        return view('admin/service_request/index', compact('rows','title'));*/

        $title = 'Service Request';
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
             Session::put('status', $request->input('status'));
             Session::put('search', $request->input('search'));
        }

         $rows = ServiceRequest::Search(Session::get('search'))->
         Status(Session::get('status'))->
         orderBy('id', 'asc')->
         paginate(config('app.limit'));

        return view('admin/service_request/index', compact('rows', 'title', 'extrajs'));
    }




	public function edit($id)
	{
		$row = ServiceRequest::findOrFail($id);
		$title = 'Edit Status';

		return view('admin.service_request.status_form',compact('title', 'row'));
	}


	public function update(Request $request, $id)
	{

		$input = $request->all();
		$model = ServiceRequest::findOrFail($id);

		$rules = [
			'status' => 'required',
		];

		$messages = [
			'status.required' => ' Status is required!',
		];

		$validator = Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {

			return redirect('admin/service-request/'.$id.'/edit')->withErrors($validator)->withInput();
		}

		$model->update($input);


		if ($model->id > 0) {
			$message = $model->name.' Status Successfully updated.';
			$error = false;
		} else {
			$message =  $request->get('name') .'Status updating fail.';
			$error = true;
		}

		return redirect('admin/service-request')->with(['message' => $message, 'error' => $error]);
	}

}
