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

        $date1 = date("jS F, Y", strtotime($model->request_date));
        $time1 = date("jS F, Y", strtotime($model->request_time));
        $date2 = date("jS F, Y", strtotime($model->updated_at));
//        date("jS F, Y", strtotime($rows[$i]->issue_date));


		if($model->status==2){
		    $status = 'Accepted';
            $message =  nl2br('Your Service request is '.$status.'.'.' '. 'Scheduled Date :'. $date1.'.'.' '. ' Time :'.$time1, false);
        }elseif ($model->status==3){
            $status = 'Reject';
            $message =  nl2br('Your Service request is '.$status.'.'.' '. 'Please Try Again.',false);
        }elseif ($model->status==4){
            $status = 'Rescheduled';
            $message =  nl2br('Your Service request is '.$status.'.'.' '. 'Scheduled Date :'. $date2.'.'.' '. ' Time :'.date("h:m:s", strtotime($model->updated_at)), false);
        }else{
            $status = 'Done';
            $message =  nl2br('Your Service request is '.$status.'.'.' '. 'Thank You.',false);
        }

//print_r($message);exit;

        $token = UserDevices::where('user_id',$model->user_id)->first();
		//print_r($token);exit;
        if($token){
            
            $token=$token->id;
            $this->sendNotification($token,$message);
        }
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


   public function sendNotification($token,$message){


       $optionBuilder = new OptionsBuilder();
       $optionBuilder->setTimeToLive(60*20);

       $notificationBuilder = new PayloadNotificationBuilder('Uttara Motors');
       $notificationBuilder->setClickAction('FCM_PLUGIN_ACTIVITY')
           ->setBody($message)
           ->setSound('default');

       $dataBuilder = new PayloadDataBuilder();

       $dataBuilder
           ->addData(['title' => 'Uttara Motors'])
           ->addData(['body' => $message]);


       $option = $optionBuilder->build();
       $notification = $notificationBuilder->build();
       $data = $dataBuilder->build();


       $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);


       return $downstreamResponse->numberSuccess();
   }
}
