<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
class EmployeeController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Employee';

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
            Session::put('search', $request->input('search'));
        }

        $rows = Employee::Search(Session::get('search'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/employee/index', compact('rows', 'title', 'extrajs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add employee';
        return view('admin.employee.create', compact('title') );
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
            'name' => 'required|unique:employee',
        ];

        $messages = [
            'name.required'     => 'Employee name is required!',
            'name.unique'       => 'Employee name already exists!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/employee/create')->withErrors($validator)->withInput();
        }

        $permission = Employee::create(
            [
                'name'          => $request->get('name'),
                'designation'   => $request->get('designation'),
                'phone'        => $request->get('phone')
            ]
        );

        if ($permission->id > 0) {
            $message = 'New '.  $permission->name.'  added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .'  adding fail.';
            $error = true;
        }

        return redirect('admin/employee')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Employee::findOrFail($id);
        $title = 'Employee '. $row->name . ' details';
        return view('admin.employee.view',compact('title', 'row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Employee::findOrFail($id);
        $title = 'Edit '. $row->name . ' details';

        return view('admin.employee.edit',compact('title', 'row'));
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
        $employee = Employee::findOrFail($id);

        $rules = [
            'name' => 'required|unique:employee,name,'.$id.',id'
        ];

        $messages = [
            'name.required'     => 'Employee name is required!',
            'name.unique'       => 'Employee name already exists!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/employee/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $input =  [
            'name'          => $request->get('name'),
            'designation'   => $request->get('designation'),
            'phone'        => $request->get('phone')
        ];

        if ($employee->update($input)) {
            $message = $employee->name.'  updated.';
            $error = false;
        } else {
            $message =  $employee->name.'  update fail.';
            $error = true;
        }

        return redirect('admin/employee')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function delete(Request $request, $id)
    {

        $employee = Employee::findOrFail($id);

        $message =  $employee->name.'  deleted.';
        $error = true;
        $employee->delete();

        return redirect('admin/employee')->with(['message' => $message, 'error' => $error]);
    }
}
