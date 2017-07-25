
<div class="modal-header">
    <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"><span class="glyphicon glyphicon-remove-sign"></span></a>
    <h4 class="modal-title text-center" id="myModalLabel">Vehicle : {{isset($row->model->name)?$row->model->name:''}}</h4>
</div>

   <div class="modal-body">

       <img src="{!! asset(isset($row->vehicle_image)?$row->vehicle_image:'') !!}" class="text-center">

   </div>
   <div class="modal-footer">
       <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Close</button>
   </div>
