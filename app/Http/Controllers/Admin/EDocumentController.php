<?php

namespace App\Http\Controllers\Admin;

use App\EDocType;
use App\EDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EDocumentController extends Controller
{


    public function index(Request $request)
    {
        $title = 'E Documents';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#type_id option:selected').val('0');
				$('#model_id option:selected').val('0');
				$('#brand_id option:selected').val('0');
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
            Session::put('doc_type_id', $request->input('doc_type_id'));
        }

        $doc_type = $this->docTypeList();
        //print_r($doc_type);exit;

        $rows = EDocument::with('doc_type')->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/e_documents/index', compact('rows', 'title', 'doc_type','model','brand','extrajs'));
    }



    public function create()
    {
        $title = 'Add E Document';

        $doc_type = $this->docTypeList(true);

        return view('admin.e_documents.create', compact('title', 'doc_type') );
    }




    private function docTypeList($boolean = false)
    {
        $rows = EDocType::orderBy('id', 'ASC')->get();

        $type[0] = ($boolean == true ? 'Select a type' : 'All type');

        foreach($rows as $row):
            $type[$row->id] = $row->name;
        endforeach;

        return $type;
    }
}
