
<div style="padding:60px;">
    <table id="" class="table table-bordered table-hover">
        <tr>
            <td><img src="{!! asset(isset($row->vehicle_image)?$row->vehicle_image:'') !!}" width="50%" height="80%"></td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <a href="{!! url('admin/vehicle') !!}" class="btn btn-default" type="button"> Close </a>
</div>
