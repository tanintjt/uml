@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/user/'.$row->id, 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!! $title !!}
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    <a href="{!! url('admin/user/'.$row->id.'/edit')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    <a href="{!! url('admin/user')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="10%" class="active">Name</th>
                            <td>{!! $row->name !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Email</th>
                            <td>{!! $row->email !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Phone</th>
                            <td>{!! $row->phone !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Roles</th>
                            <td>
                                @if(!empty($row->roles))
                                    @foreach($row->roles as $v)
                                        <label class="label label-success">{{ $v->display_name }}</label>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                       {{-- <tr>
                            <th class="active">Client</th>
                            --}}{{--<td>{!! $row->dealers->clients->name !!}</td>--}}{{--
                        </tr>--}}
                        {{--<tr>
                            <th class="active">Dealer</th>
                            --}}{{--<td>{!! $row->dealers->name !!}</td>--}}{{--
                        </tr>--}}
                        {{--<tr>
                            <th class="active">API Key</th>
                            <td>{!! $row->api_token !!}</td>
                        </tr>--}}
                        <tr>
                            <th class="active">Status</th>
                            <td>{!! $row->status == 1 ? '<span class="label label-primary">Active</span>':'<span class="label label-danger">Inactive</span>' !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
