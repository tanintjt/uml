<link href="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.css') !!}" rel="stylesheet">
<link href="{!! asset('public/themes/default/css/bootstrap.min.css') !!}" rel="stylesheet">
<script src="{!! asset('public/themes/default/plugins/jQuery/jquery-2.2.3.min.js') !!}"></script>

<script src="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.js') !!}"></script>


@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','url' => Request::segment(1).'/e-documents/'.$row->id,'class' => 'form-horizontal', 'id' => 'admin-form','files'=>'true' ]) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">

            <div class="col-xs-6">
                <div class="form-group{{ $errors->has('doc_type_id') ? ' has-error' : '' }}">
                    {!! Form::label('doc_type_id', 'E Doc Type :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('doc_type_id', $doc_type, old('doc_type_id'), ['class' => 'form-control', 'id' => 'doc_type_id']) !!}
                        @if ($errors->has('doc_type_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('doc_type_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('issue_date') ? ' has-error' : '' }}">
                    {!! Form::label('issue_date', 'Issue Date :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('issue_date',  old('issue_date',date('Y-m-d', strtotime($row->issue_date))),['class' => 'form-control datepicker', 'id' => 'issue_date', 'placeholder' => 'issue date']) !!}
                        @if ($errors->has('issue_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('issue_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-xs-6">

                <div class="form-group{{ $errors->has('expiry_date') ? ' has-error' : '' }}">
                    {!! Form::label('expiry_date', 'Expiry Date :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('expiry_date',  old('expiry_date',date('Y-m-d', strtotime($row->expiry_date))),['class' => 'form-control datepicker', 'id' => 'expiry_date', 'placeholder' => 'expiry date']) !!}
                        @if ($errors->has('expiry_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('expiry_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                    {!! Form::label('file', 'File:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('file',old('file'), [ 'class' => 'form-control','required']) !!}
                        @if ($errors->has('file'))
                            <span class="help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
                        <a href="{!! url('admin/e-documents') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            format:'yyyy-mm-dd'
        })
    </script>




@endsection
