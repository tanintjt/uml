<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\NotificationHistory;
use App\ServiceRequest;
use App\UserDevices;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Admin\PushNotificationController;
use DB;
class ServiceRequestController extends Controller
{

    public function index(Request $request){

        $title = 'Service Request';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#status option:selected').val('0');
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
             Session::put('status', $request->input('status'));
             Session::put('search', $request->input('search'));
        }

         $rows = ServiceRequest::whereIn('status', [1,2,4])->Search(Session::get('search'))->
         Status(Session::get('status'))->
         orderBy('id', 'desc')->paginate(config('app.limit'));

        $datas = ServiceRequest::whereIn('status', [3,5])->Search(Session::get('search'))->
        Status(Session::get('status'))->
        orderBy('id', 'desc')->paginate(config('app.limit'));

		return view('admin/service_request/index', compact('rows', 'title','employee', 'extrajs','datas'));
    }


	public function edit($id)
	{

		$row = ServiceRequest::findOrFail($id);
		$title = 'Edit Status';

        $employee = $this->employeeList(true);
        $vehicle = $this->vehicleList(true);

		return view('admin.service_request.status_form',compact('title', 'row', 'extrajs','employee','vehicle'));
	}


	public function update(Request $request, $id)
	{

		$model = ServiceRequest::findOrFail($id);

		$date = Carbon::parse($request->input('updated_at'));

		$rules = [
			'status' => 'required',
            'updated_at' => 'required|date|after_or_equal:request_time'
		];

		$messages = [
			'status.required' => 'Status is required!',
			'updated_at.after_or_equal' => 'Service date must be after or equal to the request date.',
		];

		$validator = Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {

			return redirect('admin/service-request/'.$id.'/edit')->withErrors($validator)->withInput();
		}

		$data = [
			'status' => $request->input('status'),
			'employee_id' => $request->input('employee_id'),
			'vehicle_id' => $request->input('vehicle_id'),
			'updated_at' => $date,
		];

		$model->update($data);

        $date1 = date("jS F, Y", strtotime($model->request_date));
        $date2 = date("jS F, Y", strtotime($model->updated_at));

		if($model->status==2){
		    $status = 'accepted';
            $message = ('Your Service request has been '.$status.' to '. 'scheduled date/time :'. $date1.'.'.' ' .date('h:i:s a', strtotime($model->request_time)));
        }elseif ($model->status==3){
            $status = 'rejected';
            $message =  ('Your Service request has been '.$status.' ' . 'Please book another service time as per convenience.');
        }elseif ($model->status==4){
            $status = 'rescheduled';
            $message =  ('Your Service request has been '.$status.' to '. 'scheduled date/time :'. $date2.'.'.' '. date("h:i:s a", strtotime($model->updated_at)));
        }else{
            $status = 'completed';
            $message =  ('Your Service has been '.$status.' . '. 'Thank you for being with Uttara Motors.');
        }

        $token = UserDevices::where('user_id',$model->user_id)->first()->device_id;

        ServiceRequest::sendNotification($token,$message);

        $data = [
            'user_id'     => $model->user_id,
            'message'     => $message,

        ];
        NotificationHistory::create($data);

		if ($model->id > 0) {

			$message = ' Status Successfully updated.';
			$error = false;
		} else {
			$message = ' Status updating fail.';
			$error = true;
		}

		return redirect('admin/service-request')->with(['message' => $message, 'error' => $error]);
	}


    private function employeeList($boolean = false)
    {
        $rows = Employee::orderBy('id', 'ASC')->get();

        $list[0] = ($boolean == true ? 'Select Employee' : 'All Employee');

        foreach($rows as $row):
            $list[$row->id] = $row->name;
        endforeach;

        return $list;
    }


    private function vehicleList($boolean = false)
    {

        $list[0] = ($boolean == true ? 'Select Vehicle' : 'All Vehicle');

        $rows = Vehicle::join('vehicle_type', 'vehicle.type_id', '=', 'vehicle_type.id')
            ->join('vehicle_model', 'vehicle.model_id', '=', 'vehicle_model.id')

            ->select('vehicle.id','vehicle.engine_no','vehicle.chesis_no',
                'vehicle_type.name as type', 'vehicle_model.name as model')
            ->orderBy('id', 'desc')
            ->get();

        foreach($rows as $row):
            $list[$row->id] = $row->model;
        endforeach;

        return $list;
    }

    public function create($id)
    {
        $title = 'Assign Employee';

        $row = ServiceRequest::findOrFail($id);

        $employee = $this->employeeList(true);

        return view('admin.service_request.assign_form', compact('title', 'employee','row') );
    }


    public function assign(Request $request,$id){

        $model = ServiceRequest::findOrFail($id);

        $rules = [
            'employee_id'   => 'not_in:0',
        ];

        $messages = [
            'employee_id.not_in'    => 'Employee is required!',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/employee-assign/create')->withErrors($validator)->withInput();
        }


        $data = [
            'employee_id' => $request->input('employee_id'),

        ];

        $model->update($data);

        if ($model->id > 0) {
            $message = ' Successfully added.';
            $error = false;
        } else {
            $message =  ' adding fail.';
            $error = true;
        }

        return redirect('admin/service-request')->with(['message' => $message, 'error' => $error]);
    }



}
