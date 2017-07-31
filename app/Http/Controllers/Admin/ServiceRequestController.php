<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\ServiceRequest;
use App\UserDevices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Admin\PushNotificationController;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
class ServiceRequestController extends Controller
{

    public function index(Request $request){

       /* $title = "Service Request";
        $user = $request->user();

        $rows = ServiceRequest::with('users','service_center','service_package')->get();

        return view('admin/service_request/index', compact('rows','title'));*/

        $title = 'Service Request';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
//				$('#status option:selected').val('0');
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

        $employee = $this->employeeList(true);

        if ($request->isMethod('post')) {
             Session::put('status', $request->input('status'));
             Session::put('search', $request->input('search'));
        }

         $rows = ServiceRequest::whereIn('status', [1,2,3,4])->Search(Session::get('search'))->
         Status(Session::get('status'))->
         orderBy('id', 'asc')->paginate(config('app.limit'));


		return view('admin/service_request/index', compact('rows', 'title','employee', 'extrajs'));
    }




	public function edit($id)
	{


		$row = ServiceRequest::findOrFail($id);
		$title = 'Edit Status';

        $employee = $this->employeeList(true);

		return view('admin.service_request.status_form',compact('title', 'row', 'extrajs','employee'));
	}


	public function update(Request $request, $id)
	{

		$model = ServiceRequest::findOrFail($id);

		$date = Carbon::parse($request->input('updated_at'));

		$rules = [
			'status' => 'required',
		];

		$messages = [
			'status.required' => 'Status is required!',
		];

		$validator = Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {

			return redirect('admin/service-request/'.$id.'/edit')->withErrors($validator)->withInput();
		}

		//$model->update($input);
		$data = [
			'status' => $request->input('status'),
			'employee_id' => $request->input('employee_id'),
			'updated_at' => $date,
		];


		$model->update($data);

		//$message = "Your Service request is .";

        $token = UserDevices::where('user_id',$model->user_id)->first()->device_id;
		//print_r($token);exit;


        $this->sendNotification($token);

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


    public function create($id)
    {
        $title = 'Assign Employee';

        $row = ServiceRequest::findOrFail($id);

        $employee = $this->employeeList(true);

        return view('admin.service_request.assign_form', compact('title', 'employee','row') );
    }


    public function assign(Request $request,$id){

        $model = ServiceRequest::findOrFail($id);

        //print_r($request->all());exit;
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

        //print_r($data);exit;

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


   public function sendNotification($token){


       $optionBuilder = new OptionsBuilder();
       $optionBuilder->setTimeToLive(60*20);

       $notificationBuilder = new PayloadNotificationBuilder('Service Request');
       $notificationBuilder->setClickAction('FCM_PLUGIN_ACTIVITY')
           ->setBody('Thank You. Request Accepted !!!')
           ->setSound('default');
       // ->setClickAction('FCM_PLUGIN_ACTIVITY');

       $dataBuilder = new PayloadDataBuilder();

       $dataBuilder
           ->addData(['title' => 'Service Request'])
           //->addData(['click_action' => 'FCM_PLUGIN_ACTIVITY'])
           ->addData(['body' => 'Thank You. Request Accepted !!!']);
       //->addData(['a_data' => 'Uml']);

       $option = $optionBuilder->build();
       $notification = $notificationBuilder->build();
       //print_r($notification);exit;
       $data = $dataBuilder->build();

       //$token = "dtZIjFb32zE:APA91bGmAonLp_U7iNM0t1Vzd8loFYr_16CL-CLOK0T958GpQZVR0gmoC_EEOy4uuSQhzHRQSbEYL6_KbZzzQSJYTiV-ft8KWITxHfy2p0LjP8mcvWcCvvqZxS3iyWQZ4pc9yrSn1ao-";
//        $token = "861105030067461";

       $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

       /*$downstreamResponse->numberSuccess();
       $downstreamResponse->numberFailure();
       $downstreamResponse->numberModification();*/
       return $downstreamResponse->numberSuccess();
   }
}
