<?php

namespace App\Http\Controllers\Admin;

use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use Illuminate\Support\Facades\Input;

class VehicleTypeController extends Controller
{

    public function index(Request $request){

        $title = 'Vehicle Type';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
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

        $rows = VehicleType::Search(Session::get('search'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/vehicle_type/index', compact('rows', 'title', 'extrajs'));
    }


    public function create()
    {
        $title = 'Add Vehicle Type';
        return view('admin.vehicle_type.create', compact('title') );
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

            return redirect('admin/vehicle-type/create')->withErrors($validator)->withInput();
        }


        $vehicle_type = VehicleType::create($input);

        if ($vehicle_type->id > 0) {
            $message = 'New '.  $vehicle_type->name.' Vehicle Type added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .'Vehicle Type adding fail.';
            $error = true;
        }

        return redirect('admin/vehicle-type')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = VehicleType::findOrFail($id);
        $title = 'Edit details';
        return view('admin.vehicle_type.edit',compact('title', 'row'));
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
        $model = VehicleType::findOrFail($id);

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => ' Name is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/vehicle-type/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $model->update($input);


        if ($model->id > 0) {
            $message = $model->name.' Vehicle Type Successfully updated.';
            $error = false;
        } else {
            $message =  $request->get('name') .'Vehicle Type updating fail.';
            $error = true;
        }

        return redirect('admin/vehicle-type')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = VehicleType::findOrFail($id);

        $title = 'Vehicle Type details';
        return view('admin.vehicle_type.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = VehicleType::where('id',$id)->first();

        $message =  $model->name.' Vehicle Type deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
