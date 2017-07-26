@extends('auth.layouts.master')

@section('content')

    <div class="login-box">
        <img src="{!! asset('public/themes/default/img/UML-Color-03-04.svg') !!}" style="margin-left: 10%">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{!! config('app.name') !!}</b></a>
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            {!! Form::open(array('url' => 'login', 'name' => 'login-form', 'id' => 'login-form')) !!}

            {{--{!! Form::open(array('route' => 'login', 'name' => 'login-form', 'id' => 'login-form')) !!}--}}
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" style="background-color:#f05283;border-color:#f05283 ">Sign In</button>
                    </div>
                </div>
            {!! Form::close() !!}


        </div>
    </div>

@endsection
