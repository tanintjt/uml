<script>
    function vehicleEngine() {

        var chassis_no = $('input[id=chesis_no]').val();
        alert(chassis_no);
        $.ajax({
            url: "{{Route('vehicle/engine')}}",
            type: 'POST',
            data: {_token: '{!! csrf_token() !!}',chassis_no: chassis_no },
            success: function(data){
                $('#engine_no').val(data);
            }
        });
    }
</script>