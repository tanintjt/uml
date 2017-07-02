<?php

namespace App\Http\Controllers\Admin;

use App\SpareParts;
use App\SparePartsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;

class SparePartsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $title = 'Spare Parts';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#sp_cat_id option:selected').val('0');
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
            Session::put('sp_cat_id', $request->input('sp_cat_id'));
        }

        $sp_cat_list = $this->SpCategoryList();


        $rows = SpareParts::with('sp_cat')->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));


        return view('admin/spare_parts/index', compact('rows', 'title','sp_cat_list', 'extrajs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Spare Parts';

        $sp_cat_list = $this->SpCategoryList(true);

        return view('admin.spare_parts.create', compact('title', 'sp_cat_list') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();


        $rules = [
            'sp_cat_id'   => 'not_in:0',
            'name'      => 'required',
            'part_id'      => 'required',
            'rate'      => 'numeric|required',
        ];

        $messages = [
            'sp_cat_id.not_in'    => 'Spare Parts Category is required!',
            'name.required'    => 'Name is required!',
            'part_id.required' => 'Part ID is required!',
            'rate.required' => 'Rate is required!',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/spare-parts/create')->withErrors($validator)->withInput();
        }

        $vehicle = SpareParts::create($input);

        if ($vehicle->id > 0) {
            $message = 'Successfully Added';
            $error = false;
        } else {
            $message =  'Adding fail.';
            $error = true;
        }

        return redirect('admin/spare-parts')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Vehicle::findOrFail($id);

        $title = 'Vehicle details';
        return view('admin.vehicle.view',compact('title', 'row'));
    }


    public function vehicle_image($id){

        $row = Vehicle::findOrFail($id);
        $title =  $row->vehicle_image ;

        return view('admin.vehicle.vehicle_image',compact('title', 'row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Vehicle::findOrFail($id);
        $title = 'Edit details';

        $type = $this->typeList(true);
        $model = $this->modelList(true);
        $brand = $this->brandList(true);

        return view('admin.vehicle.edit',compact('title', 'row', 'type', 'model','brand'));
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

        $model = Vehicle::findOrFail($id);

        $rules = [
            'type_id'   => 'not_in:0',
            'model_id'   => 'not_in:0',
            'brand_id'   => 'not_in:0',
            'production_year'      => 'required',
            'engine_displacement'      => 'required',
            'engine_details'      => 'required',
            'fuel_system'      => 'required',
//            'vehicle_image'      => 'required',
        ];

        $messages = [
            'type_id.not_in'    => 'Type is required!',
            'model_id.required'     => 'Model is required!',
            'brand_id.required'    => 'Brand is required!',
            'production_year.required' => 'Production Year is required!',
            'engine_displacement.required' => 'Engine Displacement is required!',
            'engine_details.required' => 'Engine Details is required!',
            'fuel_system.required' => 'Fuel System is required!',
//            'vehicle_image.required' => 'Vehicle Image is required!',

        ];

        $file = Input::file('vehicle_image');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/vehicle/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        // Files destination
        $destinationPath = 'public/uploads/vehicle/';

        // Create folders if they don't exist
        if ( !file_exists($destinationPath) ) {
            mkdir ($destinationPath, 0777);
        }

        $file_original_name = $file->getClientOriginalName();
        $file_name = rand(11111, 99999) . $file_original_name;
        $file->move($destinationPath, $file_name);
        //$input['store_image'] = date('Y-m-d h:i:s', time()).'  '.$file_name;
        $input['vehicle_image'] = 'public/uploads/vehicle/' . $file_name;


        $model->update($input);

        if ($model->id > 0) {
            $message = $file_original_name. 'vehicle Successfully updated.';
            $error = false;
        } else {
            $message =  'vehicle updating fail.';
            $error = true;
        }

        return redirect('admin/vehicle')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $user = Vehicle::findOrFail($id);

        $user->delete();
        $message =  ' Successfully deleted';
        $error = true ;

        return redirect('admin/vehicle')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function SpCategoryList($boolean = false)
    {
        $rows = SparePartsCategory::orderBy('id', 'ASC')->get();

        $sp_cat_list[0] = ($boolean == true ? 'Select a Category' : 'All Category');

        foreach($rows as $row):
            $sp_cat_list[$row->id] = $row->name;
        endforeach;

        return $sp_cat_list;
    }
}
