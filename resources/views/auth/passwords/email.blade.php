{{--
@extends('auth.layouts.master')

@section('content')
<div class="container">
    <div class="login-box">

        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{!! config('app.name') !!}</b></a>
        </div>

        <div class="login-box-body">
            <h3 class="login-box-msg">Reset Password</h3>

            {!! Form::open(array('route' => 'password.email', 'name' => 'login-form', 'id' => 'login-form')) !!}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Send Password Reset Link
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

        <div class="text-center">
            <img src="{!! asset('public/themes/default/img/UML-Color-03-04.svg') !!}"style="width:52%">
        </div>
    </div>
</div>
@endsection
--}}
@extends('auth.layouts.master')

@section('content')

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{!! config('app.name') !!}</b></a>
        </div>

        <div class="login-box-body">
            <h3 class="login-box-msg">Reset Password</h3>
            {!! Form::open(array('route' => 'password.email', 'name' => 'login-form', 'id' => 'login-form')) !!}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-6 control-label">E-Mail Address</label>

                <div class="col-xs-12">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <div class="row">
                <div class="col-xs-8 ">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" style="background-color:#f05283;border-color:#f05283;margin-left:50% ">Send Password Reset Link</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

        <div class="text-center">
            <img src="{!! asset('public/themes/default/img/UML-Color-03-04.svg') !!}"style="width:52%">
        </div>
    </div>

@endsection
