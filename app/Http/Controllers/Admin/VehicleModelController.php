<?php

namespace App\Http\Controllers\Admin;

use App\VehicleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
class VehicleModelController extends Controller
{
    public function index(Request $request){

        $title = 'Vehicle Model';
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

        $rows = VehicleModel::Search(Session::get('search'))->
        // Status(Session::get('status'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/vehicle_model/index', compact('rows', 'title', 'extrajs'));
    }


    public function create()
    {
        $title = 'Add Vehicle Model';
        return view('admin.vehicle_model.create', compact('title') );
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

            return redirect('admin/vehicle-model/create')->withErrors($validator)->withInput();
        }


        $vehicle_model = VehicleModel::create($input);

        if ($vehicle_model->id > 0) {
            $message = 'New '.  $vehicle_model->name.' Vehicle Model added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .'Vehicle Model adding fail.';
            $error = true;
        }

        return redirect('admin/vehicle-model')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = VehicleModel::findOrFail($id);
        $title = 'Edit details';
        return view('admin.vehicle_model.edit',compact('title', 'row'));
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
        $model = VehicleModel::findOrFail($id);

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => ' Name is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/vehicle-model/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $model->update($input);


        if ($model->id > 0) {
            $message = $model->name.' Vehicle Model Successfully updated.';
            $error = false;
        } else {
            $message =  $request->get('name') .'Vehicle Model updating fail.';
            $error = true;
        }

        return redirect('admin/vehicle-model')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = VehicleModel::findOrFail($id);

        $title = 'Vehicle Model details';
        return view('admin.vehicle_model.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = VehicleModel::where('id',$id)->first();

        $message =  $model->name.' Vehicle Model deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
