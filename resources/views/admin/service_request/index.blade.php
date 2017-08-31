@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/service-request', 'method' => 'POST', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                {!! Form::text('search', old('search', Session::get('search')), ['class' => 'form-control input-sm', 'placeholder' => 'Search for...', 'id' => 'search']) !!}
                <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-sm go"><span class="glyphicon glyphicon-search"></span> Go</button>
                    <button type="button" class="btn btn-info btn-sm clear"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
                    {{--<a href="{!! url(Request::segment(1).'/service-center/create')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> New</a>--}}
                </span>
            </div>
            <div class="pull-right">
                {!! Form::select('status', ['0' => 'All Status', '1' => 'Pending','2' => 'Accept','3'=>'Reject','4'=>'Rescheduled','5'=>'Done'], old('status', Session::get('status') ), ['class' => 'form-control input-sm', 'id' => 'status']) !!}
            </div>

        </div>
        <div class="box-body">

            @if(Session::has('message'))
                <div class="alert {{ Session::get('error') == true ? 'alert-danger' : 'alert-success' }} alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="table-responsive">
                <p><strong> Requested Services :</strong></p>
                <table class="table table-bordered">
                    <thead>
                    <tr class="active">
                        <th width="5%">#</th>
                        <th width="10%">Customer Name</th>
                        <th width="10%">Service</th>
                        <th width="8%">Requested Date</th>
                        <th width="8%">Requested Time</th>
                        {{--<th width="5%">Servicing Date</th>--}}
                        {{--<th width="5%">Time</th>--}}
                        <th width="10%">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }} </td>
                            <td>{{ ucfirst($row->users->name)}}</td>
                            <td>{{ $row->service_package->name}}</td>
                            <td>{{ date("jS F, Y", strtotime($row->request_date))}}</td>
                            <td>{{ date( 'g:i A', strtotime($row->request_time))}}</td>
                            <td>
                                <a href="{!! url(Request::segment(1).'/service-request/'.$row->id.'/edit') !!}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit"></span>
                                    @if($row->status==1)
                                        {{'Pending'}}
                                    @elseif($row->status==2)
                                        {{ 'Accept'}}
                                    @elseif($row->status==3)
                                        {{'Reject'}}
                                    @elseif($row->status==4)
                                        {{'Rescheduled'}}
                                     @else
                                        {{'Done'}}
                                    @endif
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            {{ $rows->links() }}
        </div>
    </div>
    {!! Form::close() !!}


    <div class="box box-primary">
        <div class="box-header with-border">
            {{--<div class="input-group">
                {!! Form::text('search', old('search', Session::get('search')), ['class' => 'form-control input-sm', 'placeholder' => 'Search for...', 'id' => 'search']) !!}
                <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-sm go"><span class="glyphicon glyphicon-search"></span> Go</button>
                    <button type="button" class="btn btn-info btn-sm clear"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
                    --}}{{--<a href="{!! url(Request::segment(1).'/service-center/create')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> New</a>--}}{{--
                </span>
            </div>
            <div class="pull-right">
                {!! Form::select('status', ['0' => 'All Status', '1' => 'Pending','2' => 'Accept','3'=>'Reject','4'=>'Rescheduled','5'=>'Done'], old('status', Session::get('status') ), ['class' => 'form-control input-sm', 'id' => 'status']) !!}
            </div>--}}

        </div>
        <div class="box-body">

            @if(Session::has('message'))
                <div class="alert {{ Session::get('error') == true ? 'alert-danger' : 'alert-success' }} alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="table-responsive">
                <p><strong> Scheduled Appointments :</strong></p>
                <table class="table table-bordered">
                    <thead>
                    <tr class="active">
                        <th width="5%">#</th>
                        <th width="10%">Customer Name</th>
                        <th width="10%">Service</th>
                        {{--<th width="10%">Vehicle</th>--}}
                        <th width="8%"> Date</th>
                        <th width="8%"> Time</th>
                        <th width="8%"> Status</th>
                        <th width="5%">Assigned To</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($datas as $data)
                        <tr>
                            <td>{{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }} </td>
                            <td>{{ ucfirst($data->users->name)}}</td>
                            <td>{{ $data->service_package->name}}</td>
                            <td>{{ date("jS F, Y   g:i A", strtotime($data->updated_at))}}</td>
                            <td>{{ date("g:i A", strtotime($data->updated_at))}}</td>
                            <td>
                                @if($data->status==1)
                                    {{'Pending'}}
                                @elseif($data->status==2)
                                    {{ 'Accept'}}
                                @elseif($data->status==3)
                                    {{'Reject'}}
                                @elseif($data->status==4)
                                    {{'Rescheduled'}}
                                @else
                                    {{'Done'}}
                                @endif
                            </td>

                            <td>
                                {{isset($data->employee->name)?ucfirst($data->employee->name):''}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            {{ $datas->links() }}
        </div>
    </div>

    <div class="modal modal-danger" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove-circle"></span></button>
                    <h4 class="modal-title">Delete Parmanently</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure about this ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-flat btn-default" id="confirm"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                    <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

