<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Permission;
use Validator;
use Session;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Roles';
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

        $rows = Role::Search(Session::get('search'))->
                Status(Session::get('status'))->
                orderBy('id', 'asc')->
                paginate(config('app.limit'));

        return view('admin/role/index', compact('rows', 'title', 'extrajs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Role';
        $extrajs = "<script>
            $(function() {
                $('#checkbox').click(function(){
                    if($('#checkbox').is(':checked') ){
                        $('#permission_id > option').prop('selected','selected');
                        $('#permission_id').trigger('change');
                    }else{
                        $('#permission_id > option').removeAttr('selected');
                         $('#permission_id').trigger('change');
                     }
                });
                
                $('#permission_id').select2({
                      placeholder: 'Select a permission',
                      tag: true,
                  })
                
                
                
            });
		</script>";
        $js = '<script src="'.asset('public/themes/default/js/select2.min.js').'"></script>';
        //$css = '<link href="'.asset('public/themes/default/css/select2.min.css').'" rel="stylesheet">';

        $permissions = $this->permissionList(true);
        return view('admin.role.create', compact('title', 'permissions', 'js', 'extrajs') );
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
            'name' => 'required|unique:roles',
        ];

        $messages = [
            'name.required'     => 'Role name is required!',
            'name.unique'       => 'Role name already exists!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/role/create')->withErrors($validator)->withInput();
        }

        $role = new Role();
        $role->name = str_slug($request->input('name'), '-');
        $role->display_name = $request->input('name');
        $role->description = $request->input('description');
        $role->status = $request->input('status');
        $role->save();


        if ($role->id > 0) {
            foreach ($request->input('permission_id') as $key => $value) {
                $role->attachPermission($value);
            }
            $message = 'New '.  $role->display_name.' role added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .' role adding fail.';
            $error = true;
        }

        return redirect('admin/role')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Role::findOrFail($id);
        $permission = Permission::get();
        $rolePermissions = \DB::table("permission_role")->where("role_id",$id)
            ->pluck('permission_id')->toArray();
        $title = 'Role '. $row->display_name . ' details';
        return view('admin.role.view',compact('title', 'row', 'permission', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Role::findOrFail($id);
        $title = 'Edit '. $row->name . ' details';
        $extrajs = "<script>
            
            $(function() {
                $('#permission_id').select2( {
                    placeholder: 'Select a permission',
                    tag: true
                });
                $('#checkbox').click(function(){
                    if($('#checkbox').is(':checked') ){
                        $('#permission_id > option').prop('selected','selected');
                        $('#permission_id').trigger('change');
                    }else{
                        $('#permission_id > option').removeAttr('selected');
                         $('#permission_id').trigger('change');
                     }
                });
            });
		</script>";
        $js = '<script src="'.asset('public/themes/default/js/select2.min.js').'"></script>';
        $css = '<link href="'.asset('public/themes/default/css/select2.min.css').'" rel="stylesheet">';

        $permissions = $this->permissionList(true);
        $rolePermissions = \DB::table("permission_role")
            ->where("role_id",$id)
            ->pluck('permission_id')->toArray();
        return view('admin.role.edit',compact('title', 'row', 'permissions', 'rolePermissions', 'js', 'css', 'extrajs'));
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
        $role = Role::findOrFail($id);

        $rules = [
            'name' => 'required|unique:roles,name,'.$id.',id'
        ];

        $messages = [
            'name.required'     => 'Role name is required!',
            'name.unique'       => 'Role name already exists!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/role/'.$id.'/edit')->withErrors($validator)->withInput();
        }
        //dd($request->input('permission_id'));
        $input = array(
            'name'          => empty($request->input('slug')) ?  str_slug($request->input('name'), '-') : $request->input('slug'),
            'display_name'  => $request->input('name'),
            'status'        => $request->input('status')
        );

        if ($role->update($input)) {
            \DB::table("permission_role")->where("permission_role.role_id",$id)
                ->delete();

            foreach ($request->input('permission_id') as $key => $value) {
                $role->attachPermission($value);
            }
            $message = $role->display_name.' role updated.';
            $error = false;
        } else {
            $message =  $role->name.' role update fail.';
            $error = true;
        }

        return redirect('admin/role')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $message =  $role->name.' role deleted.';
        $error = true;
        $role->delete();

        return redirect('admin/role')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function permissionList($boolean = false)
    {
        $rows = Permission::where('status', 1)->orderBy('name', 'ASC')->get();
        $permissionlist = [];
        if ($boolean == false) {
            $permissionlist[0] = 'Select a client';
        }
        foreach($rows as $row):
            $permissionlist[$row->id] = $row->display_name;
        endforeach;

        return $permissionlist;
    }
}
