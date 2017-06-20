<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Vehicle;
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

        return view('admin.vehicle.create', compact('title', 'type','model','brand') );
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
            'type_id'   => 'not_in:0',
            'model_id'   => 'not_in:0',
            'brand_id'   => 'not_in:0',
            'production_year'      => 'required',

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
            mkdir ($destinationPath, 0777);
        }

        $file_original_name = $file->getClientOriginalName();
        $file_name = rand(11111, 99999) . $file_original_name;
        $file->move($destinationPath, $file_name);
        $input['vehicle_image'] = date('Y-m-d h:i:s', time()).'  '.$file_name;

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
        $row = User::findOrFail($id);

        $title = 'User '. $row->name . ' details';
        return view('admin.user.view',compact('title', 'row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = User::findOrFail($id);
        $title = 'Edit '. $row->name . ' details';
        $roles = $this->roleList(true);
        $userRoles = DB::table("role_user")
            ->where("user_id",$id)
            ->pluck('role_id')->toArray();
        return view('admin.user.edit',compact('title', 'row', 'roles', 'userRoles'));
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
        $user = User::findOrFail($id);

        $rules = [
            'role_id'   => 'not_in:0',
            'name'      => 'required',
        ];

        $messages = [
            'role_id.not_in'    => 'Role is required!',
            'name.required'     => 'Name is required!',
        ];

        if ($request->has('password')) {
            $rules['password']  = 'min:4|confirmed';
            //$messages['password.alpha_num'] = 'Password should be alpha numeric!';
            $messages['password.min'] = 'Password should be min 4 characters long';
            $messages['password.confirmed'] = 'Your password didn\'t match!';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/user/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $input = array(
            'name'          => $request->input('name'),
            'status'        => $request->input('status')
        );

        //update password
        if ($request->has('password')) {
            $input['password'] = bcrypt($request->input('password'));
        }

        if ($user->update($input)) {
            DB::table("role_user")->where("user_id",$user->id)->delete();

            $user->attachRole($request->input('role_id'));

            $message = $user->name.' user updated.';
            $error = false;
        } else {
            $message =  $user->name.' user update fail.';
            $error = true;
        }

        return redirect('admin/user')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $user = User::findOrFail($id);

        $user->delete();
        $message =  $user->name.' user failed to delete, user exists.';
        $error = true ;

        return redirect('admin/user')->with(['message' => $message, 'error' => $error]);
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
