

   {{-- <table id="" class="table table-bordered table-hover">
        <tr>
            <td><img src="{!! asset(isset($row->vehicle_image)?$row->vehicle_image:'') !!}"></td>
        </tr>
    </table>--}}

   <div class="modal-header">
       <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
       <h4 class="modal-title" id="myModalLabel">{{'657567'}}</h4>
   </div>


   <div class="modal-body">
       <table>
           <tr>
               <td><img src="{!! asset(isset($row->vehicle_image)?$row->vehicle_image:'') !!}"></td>
           </tr>
       </table>
   </div>
