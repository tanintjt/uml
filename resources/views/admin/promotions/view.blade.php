@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/promotions/'.$row->id, 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/promotions') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Back</a>
                    <a href="{!! url(Request::segment(1).'/promotions/'.$row->id.'/edit') !!}" class="btn btn-flat btn-primary pull-right"><i class="fa fa-edit"></i> Edit</a>
                </span>
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th width="20%" class="active">Title</th>
                        <td>{!! $row->title !!}</td>
                    </tr>
                    <tr>
                            <th class="active">Start Date</th>
                            <td>{!! isset($row->start_date)?date('Y-m-d', strtotime($row->start_date)):'' !!}</td>
                        </tr>
                        <tr>
                            <th class="active">End Date</th>
                            <td>
                                {!! isset($row->end_date)?date('Y-m-d', strtotime($row->end_date)):'' !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
