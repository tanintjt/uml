<?php

namespace App\Http\Controllers\Admin;

use App\FeedBack;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
class FeedbackController extends Controller
{
    public function index(Request $request){

        $title = 'User Feedback';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#user_id option:selected').val('0');
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
//            Session::put('status', $request->input('status'));
            Session::put('search', $request->input('search'));
            Session::put('user_id', $request->input('user_id'));
        }

        $users = $this->userList();

        $rows = FeedBack::Search(Session::get('search'))->
        UserId(Session::get('user_id'))->
        orderBy('id', 'asc')->paginate(config('app.limit'));


        return view('admin/feedback/index', compact('rows', 'title','users', 'extrajs'));
    }


    public function show($id){

        $row = FeedBack::findOrFail($id);

        $title = 'FeedBack details';
        return view('admin.feedback.view',compact('title', 'row'));
    }


    public function reply($id)
    {

        $row = FeedBack::findOrFail($id);
        $title = 'Feedback Reply';

        return view('admin.feedback.reply',compact('title', 'row', 'extrajs'));
    }


    public function store_reply($id){


    }



    public function delete($id)
    {

        $model = FeedBack::where('id',$id)->first();

        $message =  $model->subject.'  deleted.';
        $error = false;

        $model->delete();

        return redirect()->back()->with(['message' => $message, 'error' => $error]);

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
}
