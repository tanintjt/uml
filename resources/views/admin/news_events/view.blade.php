@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/news-events/'.$row->id, 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!! $title !!}
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    <a href="{!! url('admin/news-events/'.$row->id.'/edit')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    <a href="{!! url('admin/news-events')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="10%" class="active">Title</th>
                            <td>{!!isset($row->title)?$row->title:'' !!}</td>
                        </tr>
                        {{--<tr>
                            <th class="active">Start Date</th>
                            <td>{!! isset($row->start_date)?date('Y-m-d', strtotime($row->start_date)):'' !!}</td>
                        </tr>
                        <tr>
                            <th class="active">End Date</th>
                            <td>
                                {!! isset($row->end_date)?date('Y-m-d', strtotime($row->end_date)):'' !!}
                            </td>
                        </tr>--}}
                        <tr>
                            <th class="active">Details</th>
                            <td>{!! $row->details !!}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
