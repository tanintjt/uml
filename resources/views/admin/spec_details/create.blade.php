
@extends('admin.layouts.master')

@section('content')
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    {!! Form::open(array('url' => Request::segment(1).'/spec/details/store', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form','files'=>'true')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">

            <div class="col-xs-5">
                <div class="form-group{{ $errors->has('model_id') ? ' has-error' : '' }}">
                    {!! Form::label('model_id', 'Vehicle :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('model_id', $model, old('model_id'), ['class' => 'form-control', 'id' => 'model_id']) !!}
                        @if ($errors->has('model_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('model_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
                    {!! Form::label('cat_id', 'Category:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('cat_id', $spec_category, old('cat_id'), ['class' => 'form-control','id'=>'category']) !!}
                        @if ($errors->has('cat_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('cat_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-xs-7">
                   {{--<div class="form-group{{ $errors->has('front_value') ? ' has-error' : '' }}" style="display: none" id="brakes_front">
                       {!! Form::label('front_value', 'Front :', ['class' => 'col-xs-3 control-label']) !!}
                       <div class="col-xs-9">
                           {!! Form::text('front',  old('front_value'),['class' => 'form-control', 'id' => 'front_value', 'placeholder' => 'front value']) !!}
                           @if ($errors->has('front_value'))
                               <span class="help-block">
                                <strong>{{ $errors->first('front_value') }}</strong>
                            </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group{{ $errors->has('rear_value') ? ' has-error' : '' }}" style="display: none" id="brakes_rear">
                       {!! Form::label('rear_value', 'Rear :', ['class' => 'col-xs-3 control-label']) !!}
                       <div class="col-xs-9">
                           {!! Form::text('rear', old('rear_value'), ['class' => 'form-control', 'id' => 'rear_value', 'placeholder' => 'rear value']) !!}
                           @if ($errors->has('rear_value'))
                               <span class="help-block">
                                <strong>{{ $errors->first('rear_value') }}</strong>
                            </span>
                           @endif
                       </div>
                   </div>


                    <div class="form-group{{ $errors->has('seating') ? ' has-error' : '' }}" style="display: none" id="seating">
                        {!! Form::label('seating', 'Seating :', ['class' => 'col-xs-3 control-label']) !!}
                        <div class="col-xs-9">
                            {!! Form::text('seating',  old('seating'),['class' => 'form-control', 'id' => 'seating', 'placeholder' => 'Seating']) !!}
                            @if ($errors->has('seating'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('seating') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('fuel_tank') ? ' has-error' : '' }}" style="display: none" id="fuel_tank">
                        {!! Form::label('fuel_tank', 'Fuel Tank :', ['class' => 'col-xs-3 control-label']) !!}
                        <div class="col-xs-9">
                            {!! Form::text('fuel_tank', old('fuel_tank'), ['class' => 'form-control', 'id' => 'fuel_tank', 'placeholder' => 'fuel tank']) !!}
                            @if ($errors->has('fuel_tank'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('fuel_tank') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('length') ? ' has-error' : '' }}" style="display: none" id="seating">
                        {!! Form::label('length', 'Length :', ['class' => 'col-xs-3 control-label']) !!}
                        <div class="col-xs-9">
                            {!! Form::text('length',  old('length'),['class' => 'form-control', 'id' => 'length', 'placeholder' => 'length']) !!}
                            @if ($errors->has('length'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('length') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('width_without_side_moulding') ? ' has-error' : '' }}" style="display: none" id="fuel_tank">
                        {!! Form::label('width_without_side_moulding', 'Width (Without side moulding) :', ['class' => 'col-xs-3 control-label']) !!}
                        <div class="col-xs-9">
                            {!! Form::text('width_without_side_moulding', old('width_without_side_moulding'), ['class' => 'form-control', 'id' => 'width_without_side', 'placeholder' => 'width without side moulding']) !!}
                            @if ($errors->has('width_without_side_moulding'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('width_without_side_moulding') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('width_without_side_moulding') ? ' has-error' : '' }}" style="display: none" id="fuel_tank">
                        {!! Form::label('width_without_side_moulding', 'Width (Without side moulding) :', ['class' => 'col-xs-3 control-label']) !!}
                        <div class="col-xs-9">
                            {!! Form::text('width_without_side_moulding', old('width_without_side_moulding'), ['class' => 'form-control', 'id' => 'width_without_side', 'placeholder' => 'width without side moulding']) !!}
                            @if ($errors->has('width_without_side_moulding'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('width_without_side_moulding') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
--}}

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Title :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title', old('title'), ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'title such as front/rear....']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('spec_value') ? ' has-error' : '' }}">
                    {!! Form::label('spec_value', 'Spec Value :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('spec_value', old('spec_value'), ['class' => 'form-control', 'id' => 'spec_value', 'placeholder' => ' value of front/rear.....']) !!}
                        @if ($errors->has('spec_value'))
                            <span class="help-block">
                                <strong>{{ $errors->first('spec_value') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
                        <a href="{!! url('admin/spec/details') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}


    {{--<script>
        $('select[id=category]').change(function () {

            if ($(this).val().toLowerCase() === 'brakes' || $(this).val().toLowerCase() ==='suspension') {

                $("#brakes_front").show();
                $("#brakes_rear").show();
                $("#seating").hide();
                $("#fuel_tank").hide();

            }
            if($(this).val().toLowerCase() === 'capacity'){

                $("#seating").show();
                $("#fuel_tank").show();
                $("#brakes_front").hide();
                $("#brakes_rear").hide();
            }
            if($(this).val().toLowerCase() === 'dimensions'){


            }
            if($(this).val().toLowerCase() === 'engine'){

            }
            if($(this).val().toLowerCase() === 'tyres'){

            }
            if($(this).val().toLowerCase() === 'weight'){

            }

        });
    </script>--}}

@endsection


