<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\User;
use App\UserVehicle;
use App\Vehicle;
use App\VehicleModel;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Validator;
class UserVehicleController extends Controller
{

    public function index(Request $request)
    {

        $title = 'Customer Vehicle';
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
           // Session::put('model_id', $request->input('model_id'));
            Session::put('user_id', $request->input('user_id'));
        }

        $model = $this->modelList(true);
        $users = $this->userList();

        $rows = UserVehicle::Search(Session::get('search'))->with('users')->
        UserId(Session::get('user_id'))->
        orderBy('user_vehicles.created_at', 'asc')->
        paginate(config('app.limit'));

        return view('admin/user_vehicle/index', compact('rows', 'title', 'type','model','brand','users','vehicle','parent_data','extrajs'));
    }



    public function parentId(){

        $query = User::where('parent_id','id')->get();

        return $query;
    }

    public function create()
    {
        $title = 'Add Customer Vehicle';

        $model = $this->modelList(true);
        $users = $this->userList(true);

        return view('admin.user_vehicle.create', compact('title', 'users', 'brand', 'model', 'type', 'js', 'css', 'extrajs') );
    }


    public function store(Request $request){

        $rules = [
            //'model_id'       => 'not_in:0',
            'user_id'        => 'not_in:0',
            'purchase_date'  => 'required',
            'chesis_no'      => 'required',
            'engine_no'      => 'required',
        ];

        $messages = [
           // 'model_id.required'       => 'Model is required!',
            'user_id.required'        => 'User is required!',
            'purchase_date.required'  => 'Purchase Date is required!',
            'chesis_no.required' => 'Chassis no is required!',
            'engine_no.required' => 'Engine no is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/user-vehicle/create')->withErrors($validator)->withInput();
        }
         $vehicle = Vehicle::where('engine_no',$request->input('engine_no'))
                            ->where('chesis_no',$request->input('chesis_no'))
                            ->first();

         if($vehicle){

              $user_vehicle = UserVehicle::create(
                  [
                      'user_id'        => $request->input('user_id'),
                      'vehicle_id'     => $vehicle['id'],
                      'purchase_date'  => $request->input('purchase_date'),
                      'color'  => $request->input('color'),
                  ]
              );

              if ($user_vehicle->id > 0) {
                  $message = 'Successfully added.';
                  $error = false;
              } else {
                  $message = ' Adding fail.';
                  $error = true;
              }
         }else{
              return redirect('admin/user-vehicle/create')->with(['message' => 'Not exists.Please try another vehicle.']);
         }

        return redirect('admin/user-vehicle')->with(['message' => $message, 'error' => $error]);

    }


    private function userList($boolean = false)
    {
        $rows = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_id','=',4)
            ->select('users.id',
                'users.name')->get();

        $userlist[0] = ($boolean == true ? 'Select a User' : 'All User');

        foreach($rows as $row):
            $userlist[$row->id] = $row->name;
        endforeach;

        return $userlist;
    }


    public function brand($brandid)
    {
        $rows = Brand::where('brand_id', $brandid)->
        orderBy('name', 'ASC')->get();

        $brandlist = [];
        foreach($rows as $row):
            $brandlist[$row->id] = ['id' => $row->id, 'name' => $row->name];
        endforeach;

        return response()->json($brandlist);
    }


    public function view($id){

        $row = UserVehicle::findOrFail($id);

        $title =  $row->vehicles->model->name ;

        return view('admin.user_vehicle.view',compact('title', 'row'));
    }


    public function edit($id)
    {
        $title = 'Edit details';

        $row = UserVehicle::findOrFail($id);

        $model = $this->modelList(true);
        $users = $this->userList(true);

        return view('admin.user_vehicle.edit',compact('title', 'row','model','users'));
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


        $model = UserVehicle::findOrFail($id);

        $rules = [
//            'model_id'       => 'not_in:0',
            'user_id'        => 'not_in:0',
            'purchase_date'  => 'required',
            'chesis_no'      => 'required|digits:17',
            'engine_no'      => 'required',
        ];

        $messages = [
//            'model_id.required'       => 'Model is required!',
            'user_id.required'        => 'User is required!',
            'purchase_date.required'  => 'Purchase Date is required!',
            'chesis_no.required' => 'Chassis no is required!',
            'chesis_no.digits' => 'Chassis no is 17 Digit Mandatory!',
            'engine_no.required' => 'Engine no is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/user-vehicle/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $vehicle = Vehicle::where('engine_no',$request->input('engine_no'))
            ->where('chesis_no',$request->input('chesis_no'))
            ->first();

        if($vehicle){

            $user_vehicle =
                [
                    'user_id'        => $request->input('user_id'),
                    'vehicle_id'     => $vehicle['id'],
                    'purchase_date'  => $request->input('purchase_date'),
                    'color'  => $request->input('color'),
                ];

            $model->update($user_vehicle);

            if ($model->id > 0) {
                $message = 'Successfully added.';
                $error = false;
            } else {
                $message = ' Adding fail.';
                $error = true;
            }
        }else{
            return redirect('admin/user-vehicle/'.$id.'/edit')->with(['message' => 'Not exists.Please try another vehicle model.']);
        }
        return redirect('admin/user-vehicle')->with(['message' => $message, 'error' => $error]);
    }


    public function delete($id)
    {

        $user = UserVehicle::findOrFail($id);

        $user->delete();
        $message =  ' Successfully deleted.';
        $error = true ;

        return redirect('admin/user-vehicle')->with(['message' => $message, 'error' => $error]);
    }




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

        $brandlist[0] = ($boolean == true ? 'Select a brand' : 'All');

        foreach($rows as $row):
            $brandlist[$row->id] = $row->name;
        endforeach;

        return $brandlist;
    }

    public function vehicle_engine_no(){

        $input_chassis_no = Input::get('chesis_no');
        try{
            $data = Vehicle::where('chesis_no',$input_chassis_no)->get();
            if($data){
                return  Response::make($data['engine_no']);
            }
        }catch(\Exception $e){
            return  Response::make($e->getMessage());
        }
    }



}
