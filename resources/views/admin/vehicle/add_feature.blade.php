
<script src="{!! asset('public/themes/default/plugins/jQuery/jquery-2.2.3.min.js') !!}"></script>
@extends('admin.layouts.master')

@section('content')


    {!! Form::open(array('url' => Request::segment(1).'/store/features', 'class' => 'form-horizontal','id'=>'upload',
      'name' => 'admin-form', 'id' => 'admin-form','files' => true)) !!}

    <div class="panel panel-default">

        <div class="panel-heading">

            {{--<span style="color:red;">* </span>You have to upload five features.--}}

            <a href="{!! route('vehicle.features',$id)!!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
            <button class="btn btn-flat btn-primary pull-right" id="upload"><i class="fa fa-check"></i> Save</button>
            <div class="DivClass" id="myDiv"></div> <p>&nbsp;&nbsp;</p>
            {{--<p></p>--}}
        </div>

        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-5">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title[]',  old('title'),['multiple' => true,'class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name(required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-7">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">

                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::file('files[]', ['class'=>"imgControl1",'data-width'=>"400" ,'data-height'=>"600",'id'=>'file1','multiple' => true])!!} <small style="color:grey;font-weight: bold;">width 400px, height: 600px </small>
                    @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-5" id="feature">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title[]',  old('title'),['multiple' => true,'class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name (required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-7" id="title">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::file('files[]', ['class'=>"imgControl2",'data-width'=>"543" ,'data-height'=>"300",'id'=>'file2','multiple' => true]) !!}<small style="color:grey;font-weight: bold;">width 543px, height: 300px </small>
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-5" id="feature">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title[]',  old('title'),['multiple' => true,'class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name (required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-7" id="title">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::file('files[]', ['class'=>"imgControl3",'data-width'=>"268" ,'data-height'=>"300",'id'=>'file3','multiple' => true]) !!}<small style="color:grey;font-weight: bold;">width 268px, height: 300px </small>
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-5" id="feature">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title[]',  old('title'),['multiple' => true,'class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name (required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-7" id="title">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::file('files[]', ['class'=>"imgControl4",'data-width'=>"543" ,'data-height'=>"300",'id'=>'file4','multiple' => true]) !!}<small style="color:grey;font-weight: bold;">width 543px, height: 300px </small>
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-5" id="feature">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title[]',  old('title'),['multiple' => true,'class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name (required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-7" id="title">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::file('files[]', ['class'=>"imgControl5",'data-width'=>"268" ,'data-height'=>"300",'id'=>'file5','multiple' => true]) !!}<small style="color:grey;font-weight: bold;">width 268px, height: 300px </small>
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

    {!! Form::close() !!}

    <script type="text/javascript">
       $(document).ready(function(){

            $(".imgControl1").change(function(e){

                var file, img;
                var _URL   = window.URL || window.webkitURL;
                var width  = $(this).data('width');
                var height = $(this).data('height');
                var myId   = $(this).attr('id');

                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function () {

                        if(this.width != width || this.height != height){

                            if ($("#"+ myId + "-image-error").length > 0){
                                $("#"+ myId + "-image-error").show();

                            } else {
                                $('<label id="'+ myId +'-image-error" class="error-msg">Please select valid image with width 400px, height: 600px!</label>').insertAfter("#"+myId);
                            }
                            $("#"+ myId + "-image-msg").hide();
                        } else {
                            if ($("#"+ myId + "-image-msg").length > 0){
                                $("#"+ myId + "-image-msg").show();

                            }
                            /*else {
                                $('<label id="'+ myId +'-image-msg" class="success-msg">Valid image uploaded!</label>').insertAfter("#"+myId);
                            }*/
                            $("#"+ myId + "-image-error").hide();
                        }
                    };
                    img.src = _URL.createObjectURL(file);
                }
            });


           $(".imgControl2").change(function(e){

               var file, img;
               var _URL   = window.URL || window.webkitURL;
               var width  = $(this).data('width');
               var height = $(this).data('height');
               var myId   = $(this).attr('id');

               if ((file = this.files[0])) {

                   img = new Image();
                   img.onload = function () {

                       if(this.width != width || this.height != height){

                           if ($("#"+ myId + "-image-error").length > 0){
                               $("#"+ myId + "-image-error").show();

                           } else {
                               $('<label id="'+ myId +'-image-error" class="error-msg">Please select valid image with width 543px, height: 300px!</label>').insertAfter("#"+myId);
                           }
                           $("#"+ myId + "-image-msg").hide();
                       } else {
                           if ($("#"+ myId + "-image-msg").length > 0){
                               $("#"+ myId + "-image-msg").show();

                           }
                           /*else {
                               $('<label id="'+ myId +'-image-msg" class="success-msg">Valid image uploaded!</label>').insertAfter("#"+myId);
                           }*/
                           $("#"+ myId + "-image-error").hide();
                       }
                   };
                   img.src = _URL.createObjectURL(file);
               }
           });

           $(".imgControl3").change(function(e){

               var file, img;
               var _URL   = window.URL || window.webkitURL;
               var width  = $(this).data('width');
               var height = $(this).data('height');
               var myId   = $(this).attr('id');

               if ((file = this.files[0])) {

                   img = new Image();
                   img.onload = function () {

                       if(this.width != width || this.height != height){

                           if ($("#"+ myId + "-image-error").length > 0){
                               $("#"+ myId + "-image-error").show();

                           } else {
                               $('<label id="'+ myId +'-image-error" class="error-msg">Please select valid image with width 268px, height: 300px!</label>').insertAfter("#"+myId);
                           }
                           $("#"+ myId + "-image-msg").hide();
                       } else {
                           if ($("#"+ myId + "-image-msg").length > 0){
                               $("#"+ myId + "-image-msg").show();

                           }
                           /*else {
                               $('<label id="'+ myId +'-image-msg" class="success-msg">Valid image uploaded!</label>').insertAfter("#"+myId);
                           }*/
                           $("#"+ myId + "-image-error").hide();
                       }
                   };
                   img.src = _URL.createObjectURL(file);
               }
           });

           $(".imgControl4").change(function(e){

               var file, img;
               var _URL   = window.URL || window.webkitURL;
               var width  = $(this).data('width');
               var height = $(this).data('height');
               var myId   = $(this).attr('id');

               if ((file = this.files[0])) {

                   img = new Image();
                   img.onload = function () {

                       if(this.width != width || this.height != height){

                           if ($("#"+ myId + "-image-error").length > 0){
                               $("#"+ myId + "-image-error").show();

                           } else {
                               $('<label id="'+ myId +'-image-error" class="error-msg">Please select valid image with width 543px, height: 300px!</label>').insertAfter("#"+myId);
                           }
                           $("#"+ myId + "-image-msg").hide();
                       } else {
                           if ($("#"+ myId + "-image-msg").length > 0){
                               $("#"+ myId + "-image-msg").show();

                           }
                           /*else {
                               $('<label id="'+ myId +'-image-msg" class="success-msg">Valid image uploaded!</label>').insertAfter("#"+myId);
                           }*/
                           $("#"+ myId + "-image-error").hide();
                       }
                   };
                   img.src = _URL.createObjectURL(file);
               }
           });

           $(".imgControl5").change(function(e){

               var file, img;
               var _URL   = window.URL || window.webkitURL;
               var width  = $(this).data('width');
               var height = $(this).data('height');
               var myId   = $(this).attr('id');

               if ((file = this.files[0])) {

                   img = new Image();
                   img.onload = function () {

                       if(this.width != width || this.height != height){

                           if ($("#"+ myId + "-image-error").length > 0){
                               $("#"+ myId + "-image-error").show();

                           } else {
                               $('<label id="'+ myId +'-image-error" class="error-msg">Please select valid image with width 268px, height: 300px!</label>').insertAfter("#"+myId);
                           }
                           $("#"+ myId + "-image-msg").hide();
                       } else {
                           if ($("#"+ myId + "-image-msg").length > 0){
                               $("#"+ myId + "-image-msg").show();

                           }
                           /*else {
                               $('<label id="'+ myId +'-image-msg" class="success-msg">Valid image uploaded!</label>').insertAfter("#"+myId);
                           }*/
                           $("#"+ myId + "-image-error").hide();
                       }
                   };
                   img.src = _URL.createObjectURL(file);
               }
           });

       });
    </script>
    <style type="text/css">
        .error-msg{
            display: block;
            color: red;
        }
        .success-msg{
            display: block;
            color: green;
        }

    </style>

@endsection


