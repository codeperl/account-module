@extends('account::layouts.ajax')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Roles') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('roles.create')
                    <button type="button" class="btn btn-success" id="create-role-btn" data-toggle="modal" data-target="#create-role-modal">
                        {{ __('Create new role') }}
                    </button>
                @endacl
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th class="text-center">{{ __('Role') }}</th>
                <th class="text-center">{{ __('Guard name') }}</th>
                <th class="text-center">{{ __('Updated at') }}</th>
                <th class="text-center">{{ __('Created at') }}</th>
                <th class="text-center">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
                @if ($roles)
                    @foreach ($roles as $role)
                    <tr>
                        <td class="text-center">{{ $role->name }}</td>
                        <td class="text-center">{{ $role->guard_name }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($role->updated_at)->format('d F, Y') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($role->created_at)->format('d F, Y') }}</td>
                        <td class="text-center">
                            @acl('account.roles.show', 'id' => $role->id)
                                <a href="#" data-href="{{ route('account.roles.show', ['id' => $role->id]) }}" class="btn btn-link custom-color show-role"><i class="fa fa-lg fa-eye"></i></a>
                            @endacl
                            @acl('roles.edit', 'id' => $role->id)
                            <a href="#" data-href="{{ route('roles.edit', ['id' => $role->id]) }}" class="btn btn-link custom-color"><i class="fa fa-lg fa-edit"></i></a>
                            @endacl
                            @acl('roles.destroy', 'id' => $role->id, 'DELETE')
                                <form action="{{ route('roles.destroy', ['id' => $role->id]) }}" method="POST" class="d-inline delete">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-link custom-color"><i class="fa fa-lg fa-trash"></i></button>
                                </form>
                            @endacl
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">{{ __('No resource found!') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {!! $roles->render() !!}
    </div>
</div>
@acl('roles.create')
    <div class="modal fade" id="create-role-modal" tabindex="-1" role="dialog" aria-labelledby="create-role-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 850px!important;">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Roles') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    {!! Form::open(array('id' => 'role', 'name' => 'role', 'route' => 'account.roles.store','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-6 mx-auto">
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Role name') }}</label>
                                        <div class="col-md-6">
                                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'id' => 'name', 'autofocus' => true)) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="guard_name" class="col-md-4 col-form-label text-md-right">{{ __('Guard name') }}</label>

                                        <div class="col-md-6">
                                            {!! Form::text('guard_name', null, array('placeholder' => 'Guard name','class' => 'form-control', 'id' => 'guard_name')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="mx-auto">
                                    <h4><label for="name" class="mx-auto col-md-4 col-form-label text-md-right">{{ __('Permissions') }}</label></h4>
                                </div>
                                <br />
                                <div class="row" style="padding: 0 30px 0;">
                                    @foreach($permission as $value)
                                        <div class="col-4 py-1 my-1" style="border-bottom: 1px solid #CCCCCC;">
                                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'custom-control-input', 'id' => "permission[$value->id]")) }}
                                                <label  class="custom-control-label" for="{{ "permission[$value->id]" }}">{{ $value->name }} ({{$value->guard_name}})</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-5 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-lg"> {{ __('Create role and assign permissions') }} </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endacl
@endsection
@section('extrascripts')
    <script src="{{ asset('/js/roles.js') }}"></script>
@stop