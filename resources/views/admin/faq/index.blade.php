
@extends('admin.layouts.master')

<style>
    /*FAQS*/
    .faq_question {
        margin: 0px;
        padding: 0px 0px 5px 0px;
        /*display: inline-block;*/
        cursor: pointer;
        font-weight: bold;
    }

    .faq_answer_container {
        height: 0px;
        overflow: hidden;
        padding: 0px;
    }
    .panel-body1 {
        padding: 0px 30px;

    }
    .panel-title1 {
        margin-top: 0;
        margin-bottom: 0;
        font-size: 13px;
        color: inherit;
    }
    .more-less {
        float: right;
        color: #212121;
    }
    .faq_question:hover {
        color:#F288A4;
    }

</style>

@section('content')

    {!! Form::open(array('url' => Request::segment(1).'/faq', 'method' => 'POST', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                {!! Form::text('search', old('search', Session::get('search')), ['class' => 'form-control input-sm', 'placeholder' => 'Search for...', 'id' => 'search']) !!}
                <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-sm go"><span class="glyphicon glyphicon-search"></span> Go</button>
                    <button type="button" class="btn btn-info btn-sm clear"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
                    <a href="{!! url(Request::segment(1).'/faq/create')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
                </span>
            </div>

        </div>
        <div class="box-body">

            @if(Session::has('message'))
                <div class="alert {{ Session::get('error') == true ? 'alert-danger' : 'alert-success' }} alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <?php $i = 1; ?>
                    @foreach ($rows as $row)

                        <div class="panel panel-default faq_container" id="panel1">
                            <div class="faq">
                                <div class="faq_question panel-title1 panel-heading" style="background-color:#fff0f5;" onclick="toggleColor();" >
                                    {{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }}  . {{ ucfirst($row->question)}}
                                    {{--<span class="more-less glyphicon glyphicon-plus" ></span>--}}
                                    {{--<span class="more-less glyphicon glyphicon-minus" style="display: none" id="minus"></span>--}}
                                    <a href="{!! route('faq-delete',$row->id) !!}" title="Delete {!! $row->display_name !!}" user="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete {!!  $row->display_name !!}" data-message="Are you sure you want to delete {!!  $row->display_name !!} ?"><span class="glyphicon glyphicon-trash pull-right" style="margin-left: 1%"></span></a>

                                    <a href="{!! url(Request::segment(1).'/faq/'.$row->id.'/edit') !!}" ><span class="glyphicon glyphicon-edit pull-right"></span></a>
                                </div>
                                <div class="faq_answer_container">
                                    <div class="panel-body1 faq_answer">{{ ucfirst($row->answer)}}</div>
                                </div>
                            </div>
                         </div>

                    @endforeach
                </table>
            </div>
        </div>
        <div class="box-footer">
            {{ $rows->links() }}
        </div>
    </div>
    {!! Form::close() !!}

    <div class="modal modal-danger" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove-circle"></span></button>
                    <h4 class="modal-title">Delete Parmanently</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure about this ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-flat btn-default" id="confirm"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                    <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Close</button>
                </div>
            </div>
        </div>
    </div>


    {{--<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>--}}
    <script src="{!! asset('public/themes/default/js/jquery-1.11.0.min.js') !!}"></script>

    <script>
        $(document).ready(function() {

            $('.faq_question').click(function() {

                if ($(this).parent().is('.open')){
                    $(this).closest('.faq').find('.faq_answer_container').animate({'height':'0'},500);
                    $(this).closest('.faq').removeClass('open');
//                    $(this).toggleClass('<span class="more-less glyphicon glyphicon-plus" >');
                }else{
                    var newHeight =$(this).closest('.faq').find('.faq_answer').height() +'px';
                    $(this).closest('.faq').find('.faq_answer_container').animate({'height':newHeight},500);
                    $(this).closest('.faq').addClass('open');
//                    $(this).toggleClass('<span class="more-less glyphicon glyphicon-minus" >');
                }

            });

            function toggleIcon(e) {
                $(e.target)
                    .prev('.panel-heading')
                    .find(".more-less")
                    .toggleClass('glyphicon-plus glyphicon-minus');
            }
            $('.panel-group').on('hidden.bs.collapse', toggleIcon);
            $('.panel-group').on('shown.bs.collapse', toggleIcon);

        });


        function toggleColor() {
            var x = document.getElementById('myDIV');
            x.classList.toggle("mystyle");
        }
    </script>

    <script>
        $("#plus").click(function(){
            $("#minus").show();
            $("#plus").hide();
        });

        $("#minus").click(function(){
            $("#plus").show();
            $("#minus").hide();
        });
    </script>

@endsection



