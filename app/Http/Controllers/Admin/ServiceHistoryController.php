<?php

namespace App\Http\Controllers\Admin;

use App\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
class ServiceHistoryController extends Controller
{
    public function index(Request $request){

        $title = 'Service History';
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

		$rows = ServiceRequest::Search(Session::get('search'))->
		Status(Session::get('status'))->
		orderBy('id', 'asc')->paginate(config('app.limit'));


        return view('admin/service_history/index', compact('rows', 'title', 'extrajs'));
    }
}
