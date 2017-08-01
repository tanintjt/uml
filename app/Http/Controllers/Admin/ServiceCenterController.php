<?php

namespace App\Http\Controllers\Admin;

use App\ServiceCenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use Illuminate\Support\Facades\Input;

class ServiceCenterController extends Controller
{

    public function index(Request $request){

        $title = 'Service Location';
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

        $rows = ServiceCenter::Search(Session::get('search'))->
       // Status(Session::get('status'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/service_center/index', compact('rows', 'title', 'extrajs'));
    }


    public function create()
    {
        $title = 'Add Service Center';
        return view('admin.service_center.create', compact('title') );
    }


    public function store(Request $request)
    {

        $input = $request->all();

        $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'store_image' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg',
        ];

        $messages = [
            'latitude.required' => ' Latitude is required!',
            'longitude.required' => ' Longitude is required!',
            'phone.required' => ' Phone is required!',
            'address.required' => ' Address is required!',
            'store_image.required' => ' Image is required!',
        ];

        $file = Input::file('store_image');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/service-center/create')->withErrors($validator)->withInput();
        }


        // Files destination
        $destinationPath = 'public/uploads/service_center/';

       // Create folders if they don't exist
        if ( !file_exists($destinationPath) ) {
            mkdir ($destinationPath, 0777);
        }

        $file_original_name = $file->getClientOriginalName();
        $file_name = rand(11111, 99999) . $file_original_name;
        $file->move($destinationPath, $file_name);
        $input['store_image'] = 'public/uploads/service_center/' . $file_name;


        $service_center = ServiceCenter::create($input);

        if ($service_center->id > 0) {
            $message = 'Service Center Successfully added.';
            $error = false;
        } else {
            $message =  'Service Center adding fail.';
            $error = true;
        }

        return redirect('admin/service-center')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = ServiceCenter::findOrFail($id);
        $title = 'Edit details';
        return view('admin.service_center.edit',compact('title', 'row'));
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
        $model = ServiceCenter::findOrFail($id);

        $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => 'required',
            'address' => 'required',
//            'store_image' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg',
        ];

        $messages = [
            'latitude.required' => ' Latitude is required!',
            'longitude.required' => ' Longitude is required!',
            'phone.required' => ' Phone is required!',
            'address.required' => ' Address is required!',
//            'store_image.required' => ' Image is required!',
        ];

        $file = Input::file('store_image');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/service-center/'.$id.'/edit')->withErrors($validator)->withInput();
        }


        if(count($file)>0) {
            //Delete previous image from folder
            if(($model->file)){
                unlink($model->file);
            }

            // Files destination
            $destinationPath = 'public/uploads/service_center/';

            // Create folders if they don't exist
            if ( !file_exists($destinationPath) ) {
                mkdir ($destinationPath, 0777);
            }

            $file_original_name = $file->getClientOriginalName();
            $file_name = rand(11111, 99999) . $file_original_name;
            $file->move($destinationPath, $file_name);
            //$input['store_image'] = date('Y-m-d h:i:s', time()).'  '.$file_name;
            $input['store_image'] = 'public/uploads/service_center/' . $file_name;

        }

        $model->update($input);

        if ($model->id > 0) {
            $message = 'Service Center Successfully updated.';
            $error = false;
        } else {
            $message =  'Service Center updating fail.';
            $error = true;
        }

        return redirect('admin/service-center')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = ServiceCenter::findOrFail($id);

        $title = 'Service Location details';
        return view('admin.service_center.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = ServiceCenter::where('id',$id)->first();

        $message = 'Service Center deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }
}
