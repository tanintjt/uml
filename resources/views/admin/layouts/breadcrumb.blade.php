<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{!! isset($title)?$title:'' !!}</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(Request::segment(1).'/dashboard') !!}"><i class="fa fa-home"></i> Home</a></li>
    @if( !empty( Request::segment(4) ) )
        <li><a href="{!! url(Request::segment(1). '/' .Request::segment(2)) !!}">{!! title_case(Request::segment(2))!!}</a></li>
        <li class="active">{!! title_case(Request::segment(4) . ' ' . Request::segment(2))!!}</li>
    @elseif( !empty( Request::segment(3) ) )
        <li><a href="{!! url(Request::segment(1). '/' .Request::segment(2)) !!}">{!! title_case(Request::segment(2))!!}</a></li>
        <li class="active">{!! title_case( (is_numeric(Request::segment(3)) ? 'View' : Request::segment(3)) . ' ' . Request::segment(2))!!}</li>
    @else
        <li class="active">{!! title_case(Request::segment(2))!!}</li>
    @endif
    </ol>
</section>