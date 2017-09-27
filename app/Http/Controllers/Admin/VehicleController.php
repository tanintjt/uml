<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Vehicle;
use App\VehicleColor;
use App\VehicleFeature;
use App\VehicleModel;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
use File;
use Image;
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
        TypeId(Session::get('type_id'))->
        ModelId(Session::get('model_id'))->
        BrandId(Session::get('brand_id'))->

       // Status(Session::get('status'))->
        orderBy('id', 'asc')->
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

        $rules = [
            'type_id'   => 'not_in:0',
            'model_id'   => 'not_in:0',
            'brand_id'   => 'not_in:0',
            'production_year'      => 'required',
            'chesis_no'      => 'required|digits:17',
            'engine_no'      => 'required',
            'engine_displacement'      => 'required',
            'engine_details'      => 'required',
            'fuel_system'      => 'required',
            'vehicle_image'      => 'required',
//            'features'      => 'required',
//            'brochure'      => 'mimes:pdf',
        ];

        $messages = [
            'type_id.not_in'    => 'Type is required!',
            'model_id.required'     => 'Model is required!',
            'brand_id.required'    => 'Brand is required!',
            'production_year.required' => 'Production Year is required!',
            'chesis_no.required' => 'Chassis no is required!',
            'chesis_no.digits' => 'Chassis no is 17 Digit Mandatory!',
            'engine_no.required' => 'Engine no is required!',
            'engine_displacement.required' => 'Engine Displacement is required!',
            'engine_details.required' => 'Engine Details is required!',
            'fuel_system.required' => 'Fuel System is required!',
            'vehicle_image.required' => 'Vehicle Image is required!',
//            'features.required' => 'Features is required!',
//            'brochure.mimes' => 'Invalid file format ! Please Upload brochure as pdf format.',

        ];

        $file = Input::file('vehicle_image');
        $brochure = Input::file('brochure');


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/vehicle/create')->withErrors($validator)->withInput();
        }

        // Files destination for vehicle image.....
        $destinationPath = 'public/uploads/vehicle/';

        // Create folders if they don't exist

        if (!file_exists($destinationPath)) {
            mkdir('public/uploads/vehicle/', 775);
        }

        $file_name = time(). '_'. str_random(4).'.'.$file->getClientOriginalExtension();
        $file->move($destinationPath, $file_name);
        $input['vehicle_image'] = $destinationPath . $file_name;

        $input = [
            'type_id' => $request->input('type_id'),
            'model_id' => $request->input('model_id'),
            'brand_id' => $request->input('brand_id'),
            'production_year' => $request->input('production_year'),
            'chesis_no' => $request->input('chesis_no'),
            'engine_no' => $request->input('engine_no'),
            'reg_no' => $request->input('reg_no'),
            'engine_displacement' => $request->input('engine_displacement'),
            'engine_details' => $request->input('engine_details'),
            'fuel_system' => $request->input('fuel_system'),
        ];

        $vehicle = Vehicle::create($input);


        if ($vehicle->id > 0) {
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

        $model = Vehicle::findOrFail($id);

        $rules = [
            'type_id'   => 'not_in:0',
            'model_id'   => 'not_in:0',
            'brand_id'   => 'not_in:0',
            'production_year'      => 'required',
            'chesis_no'      => 'required',
            'engine_no'      => 'required',
            'engine_displacement'      => 'required',
            'engine_details'      => 'required',
            'fuel_system'      => 'required',
            'brochure'      => 'mimes:pdf',

        ];

        $messages = [
            'type_id.not_in'    => 'Type is required!',
            'model_id.required'     => 'Model is required!',
            'brand_id.required'    => 'Brand is required!',
            'production_year.required' => 'Production Year is required!',
            'chesis_no.required' => 'Chassis no is required!',
            'engine_no.required' => 'Engine no is required!',
            'engine_displacement.required' => 'Engine Displacement is required!',
            'engine_details.required' => 'Engine Details is required!',
            'fuel_system.required' => 'Fuel System is required!',
            'brochure.mimes' => 'Invalid file format ! Please Upload brochure as pdf format.',

        ];

        $file = Input::file('vehicle_image');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/vehicle/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $input = [
            'type_id' =>          $request->input('type_id'),
            'model_id' =>         $request->input('model_id'),
            'brand_id' =>         $request->input('brand_id'),
            'production_year' =>  $request->input('production_year'),
            'chesis_no' =>        $request->input('chesis_no'),
            'engine_no' =>        $request->input('engine_no'),
            'reg_no' =>           $request->input('reg_no'),
            'engine_displacement' => $request->input('engine_displacement'),
            'engine_details' =>      $request->input('engine_details'),
            'fuel_system' =>         $request->input('fuel_system'),
            //'color_code' =>         $request->input('color_code'),
        ];

     //vehicle_image.......
        if($request->hasFile('vehicle_image')){
            $file = Input::file('vehicle_image');
            //Delete previous image from folder
            if (File::exists('public/uploads/vehicle/'.$model->vehicle_image)) {
                File::delete('public/uploads/vehicle/'.$model->vehicle_image);
            }

            // Files destination
            $destinationPath = 'public/uploads/vehicle/';
            $file_name = time(). '_'. str_random(4).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $file_name);
            $input['vehicle_image'] = 'public/uploads/vehicle/' . $file_name;
        }

     //brochure.......
        if($request->hasFile('brochure')){
            $brochure = Input::file('brochure');
            //Delete previous image from folder
            if (File::exists('public/uploads/vehicle/brochure/'.$model->brochure)) {
                File::delete('public/uploads/vehicle/brochure/'.$model->brochure);
            }

            // Files destination
            $brochurePath = 'public/uploads/vehicle/brochure/';
            $brochure_name = time(). '_'. str_random(4).'.'.$brochure->getClientOriginalExtension();
            $brochure->move($brochurePath, $brochure_name);
            $input['brochure'] = 'public/uploads/vehicle/brochure/' . $brochure_name;
        }

        $model->update($input);

        if ($model->id > 0) {

            $colors = Input::file('available_colors');
            $features = Input::file('features');

            if($colors){
                $colorPath = 'public/uploads/vehicle/colors/';
                // Create folders if they don't exist
                if ( !file_exists($colorPath) ) {
                    mkdir ($colorPath, 0777);
                }
                $vehicle_colors = VehicleColor::where('vehicle_id',$model->id)->get();

                foreach($vehicle_colors as $vehicle_color) {

                    if (File::exists($colorPath.$vehicle_color->available_colors)) {
                        File::delete($colorPath.$vehicle_color->available_colors);
                    }

                    $vehicle_color->delete();
                }

                foreach($colors as $color) {

                    $file_name = time(). '_'. str_random(4).'.'.$color->getClientOriginalExtension();
                    $color->move($colorPath, $file_name);

                    VehicleColor::create([
                        'vehicle_id'       =>   $model->id,
                        'available_colors' =>   $colorPath . $file_name,
                    ]);
                }
            }

            if($features){
                $featurePath = 'public/uploads/vehicle/features/';
                // Create folders if they don't exist
                if ( !file_exists($featurePath) ) {
                    mkdir ($featurePath, 0777);
                }
                $vehicle_features = VehicleFeature::where('vehicle_id',$model->id)->get();

                foreach($vehicle_features as $vehicle_feature) {

                    if (File::exists($featurePath.$vehicle_feature->features)) {
                        File::delete($featurePath.$vehicle_feature->features);
                    }
                    $vehicle_feature->delete();
                }

                foreach($features as $feature) {

                    $feature_name = time(). '_'. str_random(4).'.'.$feature->getClientOriginalExtension();
                    $feature->move($featurePath, $feature_name);


                    VehicleFeature::create([
                        'vehicle_id' =>   $model->id,
                        'features' =>   $featurePath . $feature_name,
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


    public function color($id)
    {
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
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

        $rows = VehicleColor::where('vehicle_id',$id)->get();

        $row = Vehicle::with('model')->findOrFail($id);

        $title = 'Add Colors : '.''.$row['model']['name'];

        return view('admin.vehicle.color',compact('title', 'rows','row','extrajs'));
    }

    public function create_color($id){

       $title = 'Add Color';
       $rows = VehicleColor::where('vehicle_id',$id)->get();

       return view('admin.vehicle.add_color', compact('title','rows','id') );

    }

    public function store_color(Request $request){

        $rules = [
            'files'      => 'required',
            'color_code'      => 'required',
        ];

        $messages = [
            'color_code.required' => 'Color code is required!',
            'files.required' => ' color image is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('vehicle-create-color',$request->input('vehicle_id')))->withErrors($validator)->withInput();
        }

         $colors = $request->file('files');
         $color_codes = $request->input('color_code');

         if($colors){
             foreach($colors as $key=>$color) {

                 // Create folders if they don't exist
                 if ( !file_exists(config('image.vc_path')) ) {
                     mkdir (config('image.vc_path'), 775);
                 }

                 // Set the image name over the request image
                 $color_name = time(). '_'. str_random(4).'.'.$color->getClientOriginalExtension();
                 // Make the intervention image over the request image
                 $interventionImage = \Image::make($color->getPathname());
                 // Resize the intervention image over the request image
                 $interventionImage->resize(config('image.vc_width'), config('image.vc_height'));
                 // Save the intervention image over the request image
                 $interventionImage->save(config('image.vc_path'). $color_name, 100);

                 $data =  VehicleColor::create([
                     'vehicle_id' => $request->input('vehicle_id'),
                     'color_code' => $color_codes[$key],
                     'available_colors' =>  $color_name
                 ]);
             }
         }
        if ($data) {
            $message = 'Successfully Added';
            $error = false;
        } else {
            $message =  'Adding fail.';
            $error = true;
        }

        return redirect(route('vehicle.color',$request->input('vehicle_id')))->with(['message' => $message, 'error' => $error]);
    }

    public function edit_color($id)
    {
        $row = VehicleColor::findOrFail($id);
        $title = 'Edit ';

        return view('admin.vehicle.edit_color',compact('title', 'row', 'extrajs','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_color(Request $request, $id)
    {

        $model = VehicleColor::findOrFail($id);

        $rules = [
            'color_code'      => 'required',
        ];

        $messages = [

            'color_code.required' => 'Color Code is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            //return redirect('admin/vehicle/color/'.$id.'/edit')->withErrors($validator)->withInput();
            return redirect(route('vehicle-color-edit',$model->vehicle_id))->withErrors($validator)->withInput();

        }
        $input = [
            'vehicle_id' =>    $model->vehicle_id,
            'color_code' =>    $request->input('color_code'),
        ];

        if($request->hasFile('files')){

            $file = $request->file('files');

            //Delete previous image from folder
            if (File::exists('public/uploads/vehicle/colors/'.$model->available_colors)) {
                File::delete('public/uploads/vehicle/colors/'.$model->available_colors);
            }

            // Set the image name over the request image
            $color_name = time(). '_'. str_random(4).'.'.$file->getClientOriginalExtension();
            // Make the intervention image over the request image
            $interventionImage = \Image::make($file->getPathname());
            // Resize the intervention image over the request image
            $interventionImage->resize(config('image.vc_width'), config('image.vc_height'));
            // Save the intervention image over the request image
            $interventionImage->save(config('image.vc_path'). $color_name, 100);
            $input['available_colors'] = $color_name;
        }

        $model->update($input);

        if ($model->id > 0) {

            $message = 'Successfully Updated';
            $error = false;
        } else {
            $message =  'Adding fail.';
            $error = true;
        }

        return redirect(route('vehicle.color',$model->vehicle_id))->with(['message' => $message, 'error' => $error]);
    }


    public function destroy($id){

        $vehicles = VehicleColor::findOrFail($id);

        $vehicles->delete();
        $message =  ' Successfully deleted';
        $error = true ;

        return redirect()->back()->with(['message' => $message, 'error' => $error]);


    }

    public function vehicle_colors($id){

        $rows = VehicleColor::where('vehicle_id',$id)->get();

        $row = Vehicle::findOrFail($id);
        $title =  "Available Colors" ;


        return view('admin.vehicle.available_colors',compact('title', 'rows','row'));

    }




    public function features($id)
    {
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
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


        $rows = VehicleFeature::where('vehicle_id',$id)->get();

        $row = Vehicle::with('model')->findOrFail($id);

        $title = 'Add Feature : '.''.$row['model']['name'];

        return view('admin.vehicle.features',compact('title', 'rows','row','extrajs'));
    }


    public function create_features($id){

        $title = 'Add Features';
        $rows = VehicleFeature::where('vehicle_id',$id)->get();

        return view('admin.vehicle.add_feature', compact('title','rows','id') );

    }

    public function store_features(Request $request){

        $rules = [
            'files'      => 'required',
            'title'      => 'required',
        ];

        $messages = [
            'title.required' => 'Title is required!',
            'files.required' => ' feature image is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('vehicle-create-features',$request->input('vehicle_id')))->withErrors($validator)->withInput();
        }

        $features = $request->file('files');
        $title = $request->input('title');

        if($features){
            foreach($features as $key=>$feature) {

                // Create folders if they don't exist
                if ( !file_exists(config('image.fc_path')) ) {
                    mkdir (config('image.fc_path'), 775);
                }

                $feature_name = time(). '_'. str_random(4).'.'.$feature->getClientOriginalExtension();
                $feature->move(config('image.fc_path'), $feature_name,100);

                $data =  VehicleFeature::create([
                    'vehicle_id' =>  $request->input('vehicle_id'),
                    'title'      =>  $title[$key],
                    'features'   =>  $feature_name,
                ]);
            }
        }
        if ($data) {
            $message = 'Successfully Added';
            $error = false;
        } else {
            $message =  'Adding fail.';
            $error = true;
        }

        return redirect(route('vehicle.features',$request->input('vehicle_id')))->with(['message' => $message, 'error' => $error]);
    }


    public function edit_features($id)
    {
        $row = VehicleFeature::findOrFail($id);
        $title = 'Edit ';

        return view('admin.vehicle.edit_feature',compact('title', 'row', 'extrajs','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_features(Request $request, $id)
    {

        $model = VehicleFeature::findOrFail($id);

        $rules = [
            'title'      => 'required',
        ];

        $messages = [

            'title.required' => 'Title is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('vehicle-features-edit',$model->vehicle_id))->withErrors($validator)->withInput();
        }

        $input = [
            'vehicle_id' =>    $model->vehicle_id,
            'title'      =>    $request->input('title'),
        ];

        if($request->hasFile('files')){

            $file = $request->file('files');

            //Delete previous image from folder
            if (File::exists('public/uploads/vehicle/features/'.$model->features)) {
                File::delete('public/uploads/vehicle/features/'.$model->features);
            }

            // Set the image name over the request image
            $features_name = time(). '_'. str_random(4).'.'.$file->getClientOriginalExtension();
            // Make the intervention image over the request image
            $interventionImage = \Image::make($file->getPathname());
            // Resize the intervention image over the request image
            $interventionImage->resize(config('image.fc_width'), config('image.fc_height'));
            // Save the intervention image over the request image
            $interventionImage->save(config('image.fc_path'). $features_name, 100);
            $input['features'] = $features_name;
        }

        $model->update($input);

        if ($model->id > 0) {

            $message = 'Successfully Updated';
            $error = false;
        } else {
            $message =  'Adding fail.';
            $error = true;
        }

        return redirect(route('vehicle.features',$model->vehicle_id))->with(['message' => $message, 'error' => $error]);
    }


    public function feature_delete($id){

        $vehicles = VehicleFeature::findOrFail($id);

        $vehicles->delete();
        $message =  ' Successfully deleted';
        $error = true ;

        return redirect()->back()->with(['message' => $message, 'error' => $error]);


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
