<!-- jQuery 2.2.3 -->
<script src="{!! asset('public/themes/default/plugins/jQuery/jquery-2.2.3.min.js') !!}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{!! asset('public/themes/default/js/bootstrap.min.js') !!}"></script>
<!-- src -->
<script src="{!! asset('public/themes/default/plugins/iCheck/icheck.min.js') !!}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>

@if(isset($js))
    {!!  $js !!}
@endif

@if(isset($extrajs))
    {!! $extrajs !!}
@endif