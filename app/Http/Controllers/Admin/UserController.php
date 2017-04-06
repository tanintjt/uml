<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Session;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Users';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#role_id option:selected').val('0');
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
            Session::put('role_id', $request->input('role_id'));
        }

        $roles = $this->roleList();

        $rows = User::Search(Session::get('search'))->
                Role(Session::get('role_id'))->
                Status(Session::get('status'))->
                orderBy('name', 'asc')->
                paginate(config('app.limit'));

        return view('admin/user/index', compact('rows', 'title', 'roles', 'extrajs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add User';
        $roles = $this->roleList(true);
        return view('admin.user.create', compact('title', 'roles') );
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
            'role_id'   => 'not_in:0',
            'name'      => 'required',
            'msisdn'    => 'required|unique:users,msisdn',
            'pin'       => 'required|numeric|between:4,4|confirmed',
        ];

        $messages = [
            'role_id.not_in'    => 'Role is required!',
            'name.required'     => 'Name is required!',
            'msisdn.required'   => 'Mobile # is required!',
            'msisdn.unique'     => 'Mobile # is already registered!',
            'pin.required'      => 'Your PIN is reuired!',
            'pin.numeric'       => 'Your PIN should be numeric!',
            'pin.between'       => 'PIN should be min 4 & max 4',
            'pin.confirmed'     => 'Your PIN didn\'t match!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/user/create')->withErrors($validator)->withInput();
        }
        $user = User::create(
            [
                'role_id'   => $request->input('role_id'),
                'name'      => $request->input('name'),
                'msisdn'    => $request->input('msisdn'),
                'password'  => bcrypt($request->input('pin')),
                'status'    => $request->input('status')
            ]
        );

        if ($user->id > 0) {
            $message = 'New '.  $user->name.' user added.';
            $error = false;
        } else {
            $message =  'New '. $request->get('name') .' user adding fail.';
            $error = true;
        }

        return redirect('admin/user')->with(['message' => $message, 'error' => $error]);
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
        $extrajs = "<script>
            
            $(function() {
                $('#role_id').select2();
                
                $('#checkbox').click(function(){
                    if($('#checkbox').is(':checked') ){
                        $('#role_id > option').prop('selected','selected');
                        $('#role_id').trigger('change');
                    }else{
                        $('#role_id > option').removeAttr('selected');
                         $('#role_id').trigger('change');
                     }
                });
                
                $(window).on('load', function() {
                    var clientid =  $('#client_id').val();
                   
                    $('#dealer_id').empty().append('<option value=\"0\">Select a dealer</option>');
                    $.get('".url('admin/user/dealer')."/'+this.value, function(data)
                    {                
                        $.each(data, function(index, el) {
                            $('#dealer_id').append('<option value=\"' + el.id + '\">' + el.name + '</option>');
                        });
                    });
                });
                
                $('#client_id').on('change', function() {
                    
                    $('#dealer_id').empty().append('<option value=\"0\">Select a dealer</option>');
                    $.get('".url('admin/user/dealer')."/'+this.value, function(data)
                    {                
                        $.each(data, function(index, el) {
                            $('#dealer_id').append('<option value=\"' + el.id + '\">' + el.name + '</option>');
                        });
                    });
                });
                
            });
		</script>";
        $js = '<script src="'.asset('public/themes/default/js/select2.min.js').'"></script>';
        $css = '<link href="'.asset('public/themes/default/css/select2.min.css').'" rel="stylesheet">';
        $roles = $this->roleList(true);
        $clients = $this->clientList(true);
        $dealers = $this->dealerList(true, 0);
        $userRoles = \DB::table("role_user")
            ->where("user_id",$id)
            ->pluck('role_id')->toArray();
        return view('admin.user.edit',compact('title', 'row', 'roles', 'clients', 'dealers', 'userRoles', 'js', 'css', 'extrajs'));
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
            'group_id'  => 'not_in:0',
            'client_id' => 'not_in:0',
            'name'      => 'required',
        ];

        $messages = [
            'group_id.not_in'    => 'Group is required!',
            'client_id.not_in'   => 'Client is required!',
            'name.required'      => 'Name is required!',
        ];

        if ($request->has('password')) {
            $rules['password']  = 'between:8,15|confirmed';
            //$messages['password.alpha_num'] = 'Password should be alpha numeric!';
            $messages['password.between'] = 'Password should be min 8 & max 15 characters long';
            $messages['password.confirmed'] = 'Your password didn\'t match!';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/user/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $input = array(
            'group_id'  => $request->get('group_id'),
            'client_id' => $request->get('client_id'),
            'name'      => $request->get('name'),
            'status'    => $request->get('status')
        );

        //update password
        if ($request->has('password')) {
            $input['password'] = bcrypt($request->get('password'));
        }

        if ($user->update($input)) {
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
    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $users = User::where('user_id', $user->id)->count();
        if($users > 0):
            $message =  $user->name.' user failed to delete, user exists.';
            $error = true;
        else :
            $message =  $user->name.' user deleted.';
            $error = true;
            $user->delete();

        endif;

        return redirect('admin/user')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function roleList($boolean = false)
    {
        $rows = Role::where('status', 1)->orderBy('id', 'ASC')->get();

        $rolelist[0] = ($boolean == true ? 'Select a role' : 'All role');

        foreach($rows as $row):
            $rolelist[$row->id] = $row->display_name;
        endforeach;

        return $rolelist;
    }
}
