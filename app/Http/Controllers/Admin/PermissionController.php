<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Validator;
use Session;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Permissions';

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

        $rows = Permission::Search(Session::get('search'))->
                Status(Session::get('status'))->
                orderBy('id', 'asc')->
                paginate(config('app.limit'));

        return view('admin/permission/index', compact('rows', 'title', 'extrajs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Permission';
        return view('admin.permission.create', compact('title') );
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
            'name' => 'required|unique:permissions',
        ];

        $messages = [
            'name.required'     => 'Permission name is required!',
            'name.unique'       => 'Permission name already exists!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/permission/create')->withErrors($validator)->withInput();
        }
        // empty($input['parent_id']) ? 0 : $input['parent_id'];
        $permission = Permission::create(
            [
                'display_name'  => $request->get('name'),
                'name'          => str_slug($request->get('name'), '-'),
                'description'   => $request->get('description'),
                'status'        => $request->get('status')
            ]
        );

        if ($permission->id > 0) {
            $message = 'New '.  $permission->display_name.' permission added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .' permission adding fail.';
            $error = true;
        }

        return redirect('admin/permission')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Permission::findOrFail($id);
        $title = 'Permission '. $row->display_name . ' details';
        return view('admin.permission.view',compact('title', 'row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Permission::findOrFail($id);
        $title = 'Edit '. $row->display_name . ' details';
        return view('admin.permission.edit',compact('title', 'row'));
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
        $permission = Permission::findOrFail($id);

        $rules = [
            'name' => 'required|unique:permissions,name,'.$id.',id'
        ];

        $messages = [
            'name.required'     => 'Permission name is required!',
            'name.unique'       => 'Permission name already exists!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/permission/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $input =  [
            'display_name'  => $request->get('name'),
            'name'          => str_slug($request->get('name'), '-'),
            'description'   => $request->get('description'),
            'status'        => $request->get('status')
        ];

        if ($permission->update($input)) {
            $message = $permission->display_name.' permission updated.';
            $error = false;
        } else {
            $message =  $permission->display_name.' permission update fail.';
            $error = true;
        }

        return redirect('admin/permission')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $message =  $permission->display_name.' permission deleted.';
        $error = false;
        $permission->delete();
        return redirect('admin/permission')->with(['message' => $message, 'error' => $error]);
    }
}
