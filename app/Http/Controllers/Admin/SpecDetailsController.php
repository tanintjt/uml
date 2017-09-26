<?php

namespace App\Http\Controllers\Admin;

use App\SpecCategory;
use App\SpecDetails;
use App\Vehicle;
use App\VehicleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Validator;
class SpecDetailsController extends Controller
{


    public function index(Request $request,$id)
    {

        $title = 'Specification Details';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
//				$('#type_id option:selected').val('0');
//				$('#model_id option:selected').val('0');
//				$('#brand_id option:selected').val('0');
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

        $model = $this->modelList(true);
        $spec_category = $this->SpecList(true);
        $row = Vehicle::with('model')->findOrFail($id);

        $rows = SpecDetails::Search(Session::get('search'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/spec_details/index', compact('rows', 'title', 'type','model','spec_category','extrajs','row'));
    }


    public function create($id)
    {
        $title = 'Add Specification Details';

        $model = $this->modelList(true);
        $spec_category = $this->SpecList(true);

        $row = Vehicle::with('model')->findOrFail($id);

        return view('admin.spec_details.create', compact('title','model','spec_category','row') );
    }


    public function store(Request $request){

        $rules = [
            'model_id'       => 'not_in:0',
            'cat_id'        => 'not_in:0',
//            'title'  => 'required',
//            'spec_value'  => 'required',
        ];

        $messages = [
            'model_id.required'   => 'Model is required!',
            'cat_id.required'     => 'Category is required!',
//            'title.required'      => 'Title is required!',
//            'spec_value.required'      => 'Value is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/spec/details/create')->withErrors($validator)->withInput();
        }

        $vehicle = Vehicle::with('model')->where('model_id','=',$request->input('model_id'))->first();
        $category = SpecCategory::where('title', 'like', '%' . $request->input('cat_id') . '%')->first();

//        foreach($request->all() as $key=>$value){
//            for($i=5; $i > count($request->all()); $i++) {
        $data =
                [
                    'cat_id'         =>  $category['id'],
                   // 'cat_id'         => $request->input('cat_id'),
                    'vehicle_id'     =>  $vehicle['id'],
                    'title'          =>  $request->input('title'),
                    'spec_value'     =>  $request->input('spec_value'),
                ];
//        }
        $spec_details = SpecDetails::create($data);

        if ($spec_details->id > 0) {
            $message = 'Successfully added.';
            $error = false;
        } else {
            $message = ' Adding fail.';
            $error = true;
        }

        return redirect('admin/spec/details')->with(['message' => $message, 'error' => $error]);

    }


    public function edit($id)
    {
        $title = 'Edit details';

        $row = SpecDetails::findOrFail($id);

        $model = $this->modelList(true);
        $spec_category = $this->SpecList(true);


        return view('admin.spec_details.edit',compact('title', 'row','model','spec_category'));
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
        $model = SpecDetails::findOrFail($id);

        $rules = [
            'model_id'       => 'not_in:0',
            'cat_id'        => 'not_in:0',
            'title'  => 'required',
            'spec_value'  => 'required',
        ];

        $messages = [
            'model_id.required'   => 'Model is required!',
            'cat_id.required'     => 'Category is required!',
            'title.required'      => 'Title is required!',
            'spec_value.required'      => 'Value is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/spec/details/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $model->update($input);


        if ($model->id > 0) {
            $message = ucfirst($model->title).'Successfully updated.';
            $error = false;
        } else {
            $message =  $request->get('title') .'Updating fail.';
            $error = true;
        }

        return redirect('admin/spec/details')->with(['message' => $message, 'error' => $error]);
    }


    public function show($id){

        $row = SpecDetails::findOrFail($id);

        $title = 'Specification Details';
        return view('admin.spec_details.view',compact('title', 'row'));
    }


    public function delete($id)
    {

        $model = SpecDetails::where('id',$id)->first();

        $message =  $model->title.' deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

    }

    private function modelList($boolean = false)
    {
        $rows = VehicleModel::orderBy('id', 'ASC')->get();

        $modellist[0] = ($boolean == true ? 'Select a model' : 'All model');

        foreach($rows as $row):
            $modellist[$row->id] = $row->name;
        endforeach;

        return $modellist;
    }


    private function SpecList($boolean = false)
    {
        $rows = SpecCategory::orderBy('id', 'ASC')->get();

        $catlist[0] = ($boolean == true ? 'Select a Specification Category' : 'All Category');

        foreach($rows as $row):
            $catlist[$row->title] = ucfirst($row->title);
        endforeach;

        return $catlist;
    }

}
