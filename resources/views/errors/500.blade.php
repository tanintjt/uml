@extends('errors.layouts.master')

@section('content')
    <div class="col-xs-6 col-xs-offset-3">
    <div class="error-template">
        <h1 class="text-danger">Oops! </h1>
        <h2 class="text-warning">500 Internal server error</h2>
        <div class="error-details">
            <div class="alert alert-danger" role="alert">Sorry, there is an internal server error. Please try later.</div>
        </div>
        <div class="error-actions">
            <?php
            $uri = 'client';
            $roles = array_pluck(Auth::user()->roles, 'id');
            if (in_array(1, $roles)) {
                $uri = 'admin';
            }
            ?>
            <a href="{!! url($uri . '/dashboard') !!}" class="btn btn-primary"><span class="glyphicon glyphicon-home"></span>
                Take Me Home </a><a href="{!! url('support') !!}" class="btn btn-default "><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
        </div>
    </div>
    </div>
@endsection

