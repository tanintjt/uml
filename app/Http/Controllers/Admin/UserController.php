<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
use Session;
use Auth;
use App\Activation;
use App\Notifications\SendActivationEmail;

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
        $users = $this->userList();


        if(Auth::user()->hasRole(['sales-manager'])){

            $rows = User::Role()->whereNotIn('role_id', [1,2,3])->Search(Session::get('search'))->
            RoleId(Session::get('role_id'))->
            Status(Session::get('status'))->
            orderBy('id', 'desc')->
            paginate(config('app.limit'));
        }
        else{
            $rows = User::Role()->Search(Session::get('search'))->
            RoleId(Session::get('role_id'))->
            Status(Session::get('status'))->
            orderBy('id', 'desc')->
            paginate(config('app.limit'));
        }

       /* $role = Auth::user()->roles()->pluck('id');
        print_r($role);exit;*/

        return view('admin/user/index', compact('rows', 'title', 'roles','users', 'extrajs'));
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
        $users = $this->userList(true);

        //user list : except super admin/admin...
        //$user_list = $this->userAnotherList(true);

        return view('admin.user.create', compact('title', 'roles','users') );

        //return redirect()->route('login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SendActivationEmail $mailer)
    {

        $rules = [
            'role_id'   => 'not_in:0',
            'name'      => 'required',
            'phone' => 'required|regex:/^[0]{1}[1]{1}[5-9]{1}\d{8}$/',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:4|confirmed',
        ];

        $messages = [
            'role_id.not_in'    => 'Role is required!',
            'name.required'     => 'Name is required!',
            'email.required'    => 'Email is required!',
            'email.email'       => 'Not a valid e-mail address!',
            'email.unique'      => 'Email is already registered!',
            'phone.required' => 'Phone is required!',
            'phone.regex' => 'Not a valid mobile number!',
            'password.required' => 'Your password is required!',
            'password.min'      => 'Password should be min 4 characters long',
            'password.confirmed'=> 'Your password didn\'t match!',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/user/create')->withErrors($validator)->withInput();
        }
        $user = User::create(
            [
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'phone'         => $request->input('phone'),
                'password'      => bcrypt($request->input('password')),
                'provider'      => 'uml',
                'provider_id'   => bcrypt($request->input('password')),
                'status'        => $request->input('status'),
                'parent_id'        => $request->input('parent_id'),
            ]
        );

        if ($user->id > 0) {
            $user->attachRole($request->input('role_id'));

            $activation = new Activation;
            $activation->user_id = $user->id;
            $activation->token = str_random(64);
            $activation->save();

            $mailer->sendActivation($user, $activation);

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
        $roles = $this->roleList(true);
        $users = $this->userList(true);

        $userRoles = DB::table("role_user")
            ->where("user_id",$id)
            ->pluck('role_id')->toArray();

        return view('admin.user.edit',compact('title', 'row', 'roles','users', 'userRoles','user_list'));
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
            'role_id'   => 'not_in:0',
            'name'      => 'required',
            'phone' => 'required|regex:/^[0]{1}[1]{1}[5-9]{1}\d{8}$/',
        ];

        $messages = [
            'role_id.not_in'    => 'Role is required!',
            'name.required'     => 'Name is required!',
            'phone.required' => 'Phone is required!',
            'phone.regex' => 'Not a valid mobile number!',
        ];

        if ($request->has('password')) {
            $rules['password']  = 'min:4|confirmed';
            //$messages['password.alpha_num'] = 'Password should be alpha numeric!';
            $messages['password.min'] = 'Password should be min 4 characters long';
            $messages['password.confirmed'] = 'Your password didn\'t match!';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/user/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $input = array(
            'name'          => $request->input('name'),
            'status'        => $request->input('status'),
            'phone'        => $request->input('phone'),
            'parent_id'        => $request->input('parent_id'),
        );

        //update password
        if ($request->has('password')) {
            $input['password'] = bcrypt($request->input('password'));
        }

        if ($user->update($input)) {
            DB::table("role_user")->where("user_id",$user->id)->delete();

            $user->attachRole($request->input('role_id'));

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
    public function delete($id)
    {

        $user = User::findOrFail($id);

        $user->delete();
        $message =  $user->name.' user  delete.';
        $error = true ;

        return redirect('admin/user')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function roleList($boolean = false)
    {

        $UserRoles = DB::table('roles')->join('role_user','role_id', '=', 'roles.id')
            ->where('user_id', '=', Auth::user()->id)->first();

        if($UserRoles->name == 'sales-manager'){

            $rows = Role::where('status', 1)->whereIn('name',['registered'])->orderBy('id', 'ASC')->get();

        }else{
            $rows = Role::where('status', 1)->orderBy('id', 'ASC')->get();
        }

        $rolelist[0] = ($boolean == true ? 'Select a role' : 'All role');

        foreach($rows as $row):
            $rolelist[$row->id] = $row->display_name;
        endforeach;

        return $rolelist;
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


    public function profile()
    {

        $title = "User Profile";
        return view('admin.user.profile',compact('title'));
    }
}
