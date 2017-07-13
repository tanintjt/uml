@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif


<div class='form-group'>
   <div class="col-sm-6">
       {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
       {!! Form::Select('status',array(
                                      '0'=>'Accept',
                                      '1'=>'Reject',
                                      '2'=>'Rescheduled',

       Input::old('status'),['class'=>'form-control ','placeholder'=>'Select One','required'=>'required']) !!}
   </div>
</div>




<div class='form-group' style="margin-left:70%;padding-top:15%">
        <a href="{!! url('admin/service-request') !!}" class="btn btn-default" type="button"> Close </a>
        {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
</div>



