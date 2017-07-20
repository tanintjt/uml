<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserVehicle;
use App\Vehicle;
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

        $user = $this->userList();
        $vehicle = $this->vehicleList();


        $rows = UserVehicle::with('users','vehicle')->
       // TypeId(Session::get('type_id'))->
       // ModelId(Session::get('model_id'))->
        //BrandId(Session::get('brand_id'))->

        // Status(Session::get('status'))->
        orderBy('created_at', 'asc')->
        paginate(config('app.limit'));

        return view('admin/user_vehicle/index', compact('rows', 'title', 'type','model','brand', 'extrajs'));
    }




    private function userList($boolean = false)
    {
        $rows = User::where('status', 1)->orderBy('id', 'ASC')->get();

        $userlist[0] = ($boolean == true ? 'Select a User' : 'All User');

        foreach($rows as $row):
            $userlist[$row->id] = $row->name;
        endforeach;

        return $userlist;
    }

    private function vehicleList($boolean = false)
    {
        $rows = Vehicle::orderBy('id', 'ASC')->get();

        $vehiclelist[0] = ($boolean == true ? 'Select a Vehicle' : 'All Vehicle');

        foreach($rows as $row):
            $vehiclelist[$row->id] = $row->name;
        endforeach;

        return $vehiclelist;
    }
}
