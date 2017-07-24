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

        $title = 'User Vehicle';
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

        $type = $this->typeList(true);
        $model = $this->modelList(true);
        $brand = $this->brandList(0,0);
        //$users = $this->userList();

        $rows = UserVehicle::with('users')->
       // TypeId(Session::get('type_id'))->
       // ModelId(Session::get('model_id'))->
        //BrandId(Session::get('brand_id'))->

        // Status(Session::get('status'))->
        orderBy('created_at', 'asc')->get();
        //paginate(config('app.limit'));

        return view('admin/user_vehicle/index', compact('rows', 'title', 'type','model','brand','users','extrajs'));
    }


    public function create()
    {
        $title = 'Add User Vehicle';
        /*$extrajs = "<script>
            $(function() {
              //  $('#outlet_id').select2();


                $('#model_id').bind('load change', function(e){
                    var typeid =  $('#type_id').val();
                    var modelid =  $(this).val();

                    getVehicle(typeid, modelid);


                });


                $('#type_id').bind('load change', function(e){
                    var modelid =  $('#model_id').val();
                    var typeid =  $(this).val();

                    getVehicle(typeid, modelid);

                });


                function getVehicle(id, cid) {
                    $('#brand_id').empty();
                    $.get('" . url('admin/user-vehicle/vehicle') . "/' + id + '/' + cid, function(data)
                    {
                        $.each(data, function(idx, el) {
                            $('#brand_id').append('<option value=\"' + el.id + '\">' + el.name + '</option>');
                        });
                    });
                }



            });
		</script>";
        $js = '<script src="'.asset('public/themes/default/js/select2.min.js').'"></script>';
        $css = '<link href="'.asset('public/themes/default/css/select2.min.css').'" rel="stylesheet">';*/

        $type = $this->typeList(true);
        $model = $this->modelList(true);
        $brand = $this->brandList(0,0);
        $users = $this->userList();

        return view('admin.user_vehicle.create', compact('title', 'users', 'brand', 'model', 'type', 'js', 'css', 'extrajs') );
    }


    public function vehicle($typeid, $modelid)
    {

        $rows = Vehicle::where('vehicle.type_id', $typeid)
            ->where('vehicle.model_id', $modelid)
            ->join('vehicle_type', 'vehicle.type_id', '=', 'vehicle_type.id')
            ->join('vehicle_model', 'vehicle.model_id', '=', 'vehicle_model.id')
            ->join('brands', 'vehicle.brand_id', '=', 'brands.id')

            ->select('vehicle.id',
                 'vehicle_type.name as type',
                 'vehicle_model.name as model',
                 'brands.name as brand_name'
            )->get();

        if($rows){
            foreach($rows as $row):
                $vehiclelist[$row->brand_name] = ['id' => $row->id, 'name' => $row->brand_name];
            endforeach;
        }
        else{
            $vehiclelist[0] = ['id' => 0, 'name' => 'None'];
        }
        return response()->json($vehiclelist);
    }


    public function store(Request $request){

        //print_r($request->all());exit;
        $rules = [
            'model_id'       => 'not_in:0',
            'user_id'        => 'not_in:0',
            'purchase_date'  => 'required',
        ];

        $messages = [
            'model_id.required'       => 'Model is required!',
            'user_id.required'        => 'User is required!',
            'purchase_date.required'  => 'Purchase Date is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/user-vehicle/create')->withErrors($validator)->withInput();
        }

        if($request->input('model_id')){

            $vehicle_id = Vehicle::with('model')->where('model_id','=',$request->input('model_id'))->get(array('vehicle.id'));

            $user_vehicle = UserVehicle::create(
                [
                    'user_id'        => $request->input('user_id'),
                    'vehicle_id'     => $vehicle_id,
                    'purchase_date'  => $request->input('purchase_date'),
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
            return redirect('admin/user-vehicle/create')->with(['message' => 'Selected Vehicle Model does not exists.Please try another one.']);
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



}
