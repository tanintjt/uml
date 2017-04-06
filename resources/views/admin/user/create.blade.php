@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/user', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/user') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
                    <button class="btn btn-flat btn-primary pull-right" type="submit"><i class="fa fa-check"></i> Save</button>
                </span>
            </div>
        </div>
        <div class="box-body">
            <div class="col-xs-6">
                <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                    {!! Form::label('role_id', 'Role :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('role_id', $roles, old('role_id'), ['class' => 'form-control', 'id' => 'role_id']) !!}
                        @if ($errors->has('role_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('role_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Name :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Full name']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('status', 'Status :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        <label class="radio-inline">
                            {!! Form::radio('status', '1', true, ['id' => 'statuson']) !!} Yes
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('status', '2', false, ['id' => 'statusoff']) !!} No
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->has('msisdn') ? ' has-error' : '' }}">
                    {!! Form::label('msisdn', 'Mobile # :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        <div class="input-group">
                            <span class="input-group-addon">+880</span>
                            {!! Form::text('msisdn', old('msisdn'), ['class' => 'form-control', 'id' => 'msisdn', 'placeholder' => '17XXXXXXXX']) !!}
                        </div>
                        @if ($errors->has('msisdn'))
                            <span class="help-block">
                                <strong>{{ $errors->first('msisdn') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
                    {!! Form::label('pin', 'PIN :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::password('pin', ['class' => 'form-control', 'id' => 'pin', 'placeholder' => 'PIN']) !!}
                        @if ($errors->has('pin'))
                            <span class="help-block">
                                <strong>{{ $errors->first('pin') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pin_confirmation') ? ' has-error' : '' }}">
                    {!! Form::label('pin_confirmation', 'Confirmed PIN :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::password('pin_confirmation', ['class' => 'form-control', 'id' => 'pin_confirmation', 'placeholder' => 'PIN Confirmed']) !!}
                        @if ($errors->has('pin'))
                            <span class="help-block">
                                <strong>{{ $errors->first('pin_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@endsection
