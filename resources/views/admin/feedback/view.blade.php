@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/feedback/'.$row->id, 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!! $title !!}
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    {{--<a href="{!! url('admin/news-events/'.$row->id.'/edit')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</a>--}}
                    <a href="{!! url('admin/feedback')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th width="10%" class="active">Customer Name</th>
                        <td>{!!isset($row->users->name)?ucfirst($row->users->name):'' !!}</td>
                    </tr>
                    <tr>
                        <th width="10%" class="active">Subject</th>
                        <td>{!!isset($row->subject)?$row->subject:'' !!}</td>
                    </tr>
                    <tr>
                        <th width="10%" class="active">Feedback Details</th>
                        <td>{!!isset($row->feedback_details)?$row->feedback_details:'' !!}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
