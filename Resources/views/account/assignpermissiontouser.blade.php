@extends('account::layouts.ajax')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Users has permissions') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('assignPermissionsToUsers.form')
                    <button type="button" class="btn btn-success" id="assign-permission-to-user-btn" data-toggle="modal" data-target="#assign-permission-to-user-modal">
                        {{ __('Assign permission to user') }}
                    </button>
                @endacl
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th class="text-center">{{ __('User') }}</th>
                <th class="text-center">{{ __('Permission') }}</th>
                <th class="text-center">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($usersHasPermissions))
                @foreach ($usersHasPermissions as $userHasPermission)
                    <tr>
                        <td class="text-center"> {{ $userHasPermission->user_name  }} - {{ $userHasPermission->user_email  }} </td>
                        <td class="text-center"> {{ $userHasPermission->permission_name  }} ({{ $userHasPermission->permission_guard_name  }}) </td>
                        <td class="text-center">
                            @acl('assignPermissionsToUsers.unassign', '', 'DELETE')
                                <form name="{{$userHasPermission->userId}}{{$userHasPermission->permissionId}}" action="{{ route('assignPermissionsToUsers.unassign') }}" method="POST" class="d-inline delete">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <input type="hidden" id="user" name="user" value="{{$userHasPermission->userId}}" />
                                    <input type="hidden" id="permission" name="permission" value="{{$userHasPermission->permissionId}}" />
                                    <button type="submit" class="btn btn-link custom-color"><i class="fa fa-lg fa-trash"></i></button>
                                </form>
                            @endacl
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">{{ __('No resource found!') }}</td>
                </tr>
            @endif
            </tbody>
        </table>
        {!! $usersHasPermissions->render() !!}
    </div>
</div>
@acl('assignPermissionsToUsers.form')
    <div class="modal fade" id="assign-permission-to-user-modal" tabindex="-1" role="dialog" aria-labelledby="assign-permission-to-user-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Assign permission to user') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    <form id="assign-permission-to-user" name="assign-permission-to-user" method="POST" action="{{ route('account.assignPermissionsToUsers.assign') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="user"
                                   class="col-sm-3 col-form-label text-md-right">{{ __('User') }}</label>
                            <div class="col-md-7">
                                <select name="user" id="user" class="form-control">
                                    @foreach($users as $user)
                                        <option id="{{ $user->name }}"
                                                value="{{ $user->id }}">{{ $user->identity }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('user'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('user') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="permission" class="col-sm-3 col-form-label text-md-right">{{ __('Permission') }}</label>
                            <div class="col-md-7">
                                <select name="permission" id="permission" class="form-control">
                                    @foreach($permissions as $permission)
                                        <option id="{{ $permission->name }}" value="{{ $permission->id }}" title="{{ $permission->name }}">
                                            {{ $permission->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('permission'))
                                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('permission') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{ __('Assign') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endacl
@endsection
@section('extrascripts')
    <script src="{{ asset('/js/assignpermissiontouser.js') }}"></script>
@stop