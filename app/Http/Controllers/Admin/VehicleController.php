<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Vehicle;
use App\VehicleColor;
use App\VehicleModel;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
class VehicleController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Vehicle';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#type_id option:selected').val('0');
				$('#model_id option:selected').val('0');
				$('#brand_id option:selected').val('0');
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
            Session::put('type_id', $request->input('type_id'));
            Session::put('model_id', $request->input('model_id'));
            Session::put('brand_id', $request->input('brand_id'));
        }

        $type = $this->typeList();
        $model = $this->modelList();
        $brand = $this->brandList();


        $rows = Vehicle::with('types','model','brand')->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));


        /*$rows = User::Role()->Search(Session::get('search'))->
        RoleId(Session::get('role_id'))->
        Status(Session::get('status'))->
        orderBy('name', 'asc')->
        paginate(config('app.limit'));*/

        $rows = Vehicle::with('types','model','brand')->
        TypeId(Session::get('type_id'))->
        ModelId(Session::get('model_id'))->
        BrandId(Session::get('brand_id'))->

       // Status(Session::get('status'))->
        orderBy('created_at', 'asc')->
        paginate(config('app.limit'));

        return view('admin/vehicle/index', compact('rows', 'title', 'type','model','brand', 'extrajs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Vehicle';

        /*$extrajs = "<script>
            $(function() {
                var colpick = $('.color').each( function() {
                    $(this).minicolors({
                      control: $(this).attr('data-control') || 'hue',
                      inline: $(this).attr('data-inline') === 'true',
                      letterCase: 'lowercase',
                      opacity: false,
                      change: function(hex, opacity) {
                        if(!hex) return;
                        if(opacity) hex += ', ' + opacity;
                        try {
                          console.log(hex);
                        } catch(e) {}
                        $(this).select();
                      },
                      theme: 'bootstrap'
                    });
                });
            });
		</script>";

        $css = '<link href="'.asset('public/themes/default/css/colors.css').'" rel="stylesheet" type="text/css" media="screen">';
        $js = '<script src="'.asset('public/themes/default/js/colors.min.js').'"></script>';*/

        $type = $this->typeList(true);
        $model = $this->modelList(true);
        $brand = $this->brandList(true);

        return view('admin.vehicle.create', compact('title', 'type','model','brand','css', 'js', 'extrajs') );
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

//print_r($input);exit;
        $rules = [
            'type_id'   => 'not_in:0',
            'model_id'   => 'not_in:0',
            'brand_id'   => 'not_in:0',
            'production_year'      => 'required',
            'engine_displacement'      => 'required',
            'engine_details'      => 'required',
            'fuel_system'      => 'required',
            'vehicle_image'      => 'required',
           // 'color'      => 'required',
        ];

        $messages = [
            'type_id.not_in'    => 'Type is required!',
            'model_id.required'     => 'Model is required!',
            'brand_id.required'    => 'Brand is required!',
            'production_year.required' => 'Production Year is required!',
            'engine_displacement.required' => 'Engine Displacement is required!',
            'engine_details.required' => 'Engine Details is required!',
            'fuel_system.required' => 'Fuel System is required!',
            'vehicle_image.required' => 'Vehicle Image is required!',
           // 'color.required' => 'Vehicle Color is required!',

        ];

        $file = Input::file('vehicle_image');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/vehicle/create')->withErrors($validator)->withInput();
        }
        // Files destination
        $destinationPath = 'public/uploads/vehicle/';

        // Create folders if they don't exist
        if ( !file_exists($destinationPath) ) {
            mkdir ($destinationPath, 775);
        }

        $file_original_name = $file->getClientOriginalName();
        $file_name = rand(11111, 99999) . $file_original_name;
        $file->move($destinationPath, $file_name);
//        $input['vehicle_image'] = date('Y-m-d h:i:s', time()).'  '.$file_name;
        $input['vehicle_image'] = 'public/uploads/vehicle/' . $file_name;

        $vehicle = Vehicle::create($input);


        if ($vehicle->id > 0) {

            $colors = Input::file('available_colors');

            if($colors){
                foreach($colors as $color) {

                    $destinationPath = 'public/uploads/vehicle/';

                    $file_original_name = $color->getClientOriginalName();
                    $file_name = rand(11111, 99999) . $file_original_name;
                    $color->move($destinationPath, $file_name);

                    $input['available_colors'] = 'public/uploads/vehicle/'.$file_name;


                    VehicleColor::create([
                        'vehicle_id' => $vehicle->id,
                        'available_colors' => $input['available_colors']
                    ]);
                }

            }
            $message = 'Successfully Added';
            $error = false;
        } else {
            $message =  'Adding fail.';
            $error = true;
        }

        return redirect('admin/vehicle')->with(['message' => $message, 'error' => $error]);
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

        /*$extrajs = "<script>
            $(function() {
                var colpick = $('.color').each( function() {
                    $(this).minicolors({
                      control: $(this).attr('data-control') || 'hue',
                      inline: $(this).attr('data-inline') === 'true',
                      letterCase: 'lowercase',
                      opacity: false,
                      change: function(hex, opacity) {
                        if(!hex) return;
                        if(opacity) hex += ', ' + opacity;
                        try {
                          console.log(hex);
                        } catch(e) {}
                        $(this).select();
                      },
                      theme: 'bootstrap'
                    });
                });
            });
		</script>";

        $css = '<link href="'.asset('public/themes/default/css/colors.css').'" rel="stylesheet" type="text/css" media="screen">';
        $js = '<script src="'.asset('public/themes/default/js/colors.min.js').'"></script>';*/

        $type = $this->typeList(true);
        $model = $this->modelList(true);
        $brand = $this->brandList(true);

        return view('admin.vehicle.edit',compact('title', 'row', 'type', 'model','brand','css', 'js', 'extrajs'));
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

        ];

        $messages = [
            'type_id.not_in'    => 'Type is required!',
            'model_id.required'     => 'Model is required!',
            'brand_id.required'    => 'Brand is required!',
            'production_year.required' => 'Production Year is required!',
            'engine_displacement.required' => 'Engine Displacement is required!',
            'engine_details.required' => 'Engine Details is required!',
            'fuel_system.required' => 'Fuel System is required!',

        ];

        $file = Input::file('vehicle_image');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/vehicle/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        if(count($file)>0){
            //Delete previous image from folder
            //unlink($model->file);

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
        }

        $model->update($input);

        if ($model->id > 0) {

            $colors = Input::file('available_colors');

            if($colors){
                foreach($colors as $color) {

                    $destinationPath = 'public/uploads/vehicle/';

                    $file_original_name = $color->getClientOriginalName();
                    $file_name = rand(11111, 99999) . $file_original_name;
                    $color->move($destinationPath, $file_name);

                    $input['available_colors'] = 'public/uploads/vehicle/'.$file_name;


                    VehicleColor::update([
                        'vehicle_id' => $model->id,
                        'available_colors' => $input['available_colors']
                    ]);
                }
            }
            $message = 'Successfully Updated';
            $error = false;
        } else {
            $message =  'Adding fail.';
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
    private function typeList($boolean = false)
    {
        $rows = VehicleType::orderBy('id', 'ASC')->get();

        $typelist[0] = ($boolean == true ? 'Select a type' : 'All type');

        foreach($rows as $row):
            $typelist[$row->id] = $row->name;
        endforeach;

        return $typelist;
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


    private function brandList($boolean = false)
    {
        $rows = Brand::orderBy('id', 'ASC')->get();

        $brandlist[0] = ($boolean == true ? 'Select a brand' : 'All brand');

        foreach($rows as $row):
            $brandlist[$row->id] = $row->name;
        endforeach;

        return $brandlist;
    }



}
