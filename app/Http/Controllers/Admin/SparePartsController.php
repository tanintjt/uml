<?php

namespace App\Http\Controllers\Admin;

use App\SpareCategory;
use App\SpareParts;
use App\SparePartsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use Illuminate\Support\Facades\Input;
class SparePartsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $title = 'Spare Parts';
        $extrajs = "<script>
		$(function() {

			$('.go').click(function(){
				$('#admin-form').submit();
			});

			$('.clear').click(function(){
				$('#search').val('');
				$('#sp_cat_id option:selected').val('0');
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
           // Session::put('sp_cat_id', $request->input('sp_cat_id'));
        }

//        $sp_cat_list = $this->SpCategoryList();


        /*$rows = SpareParts::with('sp_cat')->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));*/

        $rows = SpareParts::Search(Session::get('search'))->
        orderBy('id', 'asc')->
        paginate(config('app.limit'));

        return view('admin/spare_parts/index', compact('rows', 'title','sp_cat_list', 'extrajs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Spare Parts';

//        $sp_cat_list = $this->SpCategoryList(true);

        return view('admin.spare_parts.create', compact('title', 'sp_cat_list') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();

        $file = Input::file('file');

        $rules = [
            //'sp_cat_id'   => 'not_in:0',
            'name'      => 'required',
            'part_id'      => 'required',
            'rate'      => 'numeric|required',
        ];

        $messages = [
            //'sp_cat_id.not_in'    => 'Spare Parts Category is required!',
            'name.required'    => 'Name is required!',
            'part_id.required' => 'Part ID is required!',
            'rate.required' => 'Rate is required!',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('admin/spare-parts/create')->withErrors($validator)->withInput();
        }


        $destinationPath = 'public/uploads/spare_parts/';

        $file_original_name = $file->getClientOriginalName();
        $file_name = rand(11111, 99999) . $file_original_name;
        $file->move($destinationPath, $file_name);

        $input['file'] = 'public/uploads/spare_parts/'.$file_name;

        $sp = SpareParts::create($input);

        if ($sp->id > 0) {

            $message = 'Successfully Added';
            $error = false;
        } else {
            $message =  'Adding fail.';
            $error = true;
        }


        return redirect('admin/spare-parts')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = SpareParts::findOrFail($id);

        $title = 'Spare Parts details';
        return view('admin.spare_parts.view',compact('title', 'row'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = SpareParts::findOrFail($id);
        $title = 'Edit details';

        $sp_cat_list = $this->SpCategoryList(true);

        return view('admin.spare_parts.edit',compact('title', 'row', 'sp_cat_list'));
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
        $input = $request->all();

        $model = SpareParts::findOrFail($id);

        $rules = [
            'sp_cat_id'   => 'not_in:0',
            'name'      => 'required',
            'part_id'      => 'required',
            'rate'      => 'numeric|required',
        ];

        $messages = [
            'sp_cat_id.not_in'    => 'Spare Parts Category is required!',
            'name.required'    => 'Name is required!',
            'part_id.required' => 'Part ID is required!',
            'rate.required' => 'Rate is required!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('admin/spare-parts/'.$id.'/edit')->withErrors($validator)->withInput();
        }


        $model->update($input);

        if ($model->id > 0) {
            $message =' Successfully updated.';
            $error = false;
        } else {
            $message =  'Updating fail.';
            $error = true;
        }

        return redirect('admin/spare-parts')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $user = SpareParts::findOrFail($id);

        $user->delete();
        $message =  ' Successfully deleted';
        $error = true ;

        return redirect('admin/spare-parts')->with(['message' => $message, 'error' => $error]);
    }

    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function SpCategoryList($boolean = false)
    {
        $rows = SparePartsCategory::orderBy('id', 'ASC')->get();

        $sp_cat_list[0] = ($boolean == true ? 'Select a Category' : 'All Category');

        foreach($rows as $row):
            $sp_cat_list[$row->id] = $row->name;
        endforeach;

        return $sp_cat_list;
    }
}
