<?php

namespace App\Http\Controllers\Admin;

use App\ServicePackage;
use App\ServicePackageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Validator;
class ServicePackageController extends Controller
{


    public function index(Request $request){

        $title = 'Service Package';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#package_type_id option:selected').val('0');
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
            Session::put('package_type_id', $request->input('package_type_id'));
            Session::put('search', $request->input('search'));
        }

        $rows = ServicePackage::with('service_package_type')->
            Search(Session::get('search'))->
            PackageTypeId(Session::get('package_type_id'))->
            orderBy('id', 'asc')->
            paginate(config('app.limit'));

        $package_type_id = $this->ServicePackageTypeList();

        return view('admin/service_package/index', compact('rows', 'title','package_type_id', 'extrajs'));
    }


    public function create()
    {
        $title = 'Add Service Package';
        $package_type_id = $this->ServicePackageTypeList();

        return view('admin.service_package.create', compact('title','package_type_id') );
    }


    public function store(Request $request)
    {

        $input = $request->all();

        $rules = [
            'package_type_id'   => 'not_in:0',
            'name' => 'required',
        ];

        $messages = [
            'package_type_id.not_in'    => 'Type is required!',
            'name.required'             => ' Name is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/service-package/create')->withErrors($validator)->withInput();
        }

        $service_package = ServicePackage::create($input);

        if ($service_package->id > 0) {
            $message = 'New '.  $service_package->name.' service package added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .' service package adding fail.';
            $error = true;
        }

        return redirect('admin/service-package')->with(['message' => $message, 'error' => $error]);
    }


    public function edit($id)
    {
        $row = ServicePackage::findOrFail($id);
        $title = 'Edit details';

        $package_type_id = $this->ServicePackageTypeList();

        return view('admin.service_package.edit',compact('title', 'row','package_type_id'));
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
        $model = ServicePackage::findOrFail($id);

        $rules = [
            'package_type_id'   => 'not_in:0',
            'name' => 'required',
            'details' => 'required',
            //'package_rate' => 'required',
        ];

        $messages = [
            'package_type_id.not_in'    => 'Type is required!',
            'name.required' => ' Name is required!',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/service-package/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $model->update($input);

        if ($model->id > 0) {
            $message = $model->name.' service package updated.';
            $error = false;
        } else {
            $message =  $request->get('name') .' service package updating fail.';
            $error = true;
        }

        return redirect('admin/service-package')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = ServicePackage::findOrFail($id);

        $title = 'Service Package details';
        return view('admin.service_package.view',compact('title', 'row'));
    }



    public function delete($id)
    {

        $model = ServicePackage::where('id',$id)->first();

        $message =  $model->name.' Service Package deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }

    private function ServicePackageTypeList($boolean = false)
    {
        $rows = ServicePackageType::orderBy('id', 'ASC')->get();

        $sp_cat_list[0] = ($boolean == true ? 'Select a Category' : 'All Category');

        foreach($rows as $row):
            $sp_cat_list[$row->id] = $row->name;
        endforeach;

        return $sp_cat_list;
    }
}
