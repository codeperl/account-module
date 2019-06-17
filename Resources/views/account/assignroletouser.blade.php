@extends('account::layouts.ajax')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Users has roles') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('assignRolesToUsers.form')
                    <button type="button" class="btn btn-success" id="assign-role-to-user-btn" data-toggle="modal" data-target="#assign-role-to-user-modal">
                        {{ __('Assign role to user') }}
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
                <th class="text-center">{{ __('Role') }}</th>
                <th class="text-center">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($usersHasRoles))
                @foreach ($usersHasRoles as $userHasRole)
                    <tr>
                        <td> {{ $userHasRole->user_name  }} - {{ $userHasRole->user_email  }} </td>
                        <td> {{ $userHasRole->role_name  }} ({{ $userHasRole->role_guard_name  }}) </td>
                        <td class="text-center">
                            @acl('assignRolesToUsers.unassign', 'user' => $userHasRole->user_id|'role' => $userHasRole->role_id, 'DELETE')
                                <form name="{{$userHasRole->user_id}}{{$userHasRole->role_id}}" action="{{ route('assignRolesToUsers.unassign') }}" method="POST" class="d-inline delete">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <input type="hidden" id="user" name="user" value="{{$userHasRole->user_id}}" />
                                    <input type="hidden" id="role" name="role" value="{{$userHasRole->role_id}}" />
                                    <button type="submit" class="btn btn-link custom-color"><i class="fa fa-lg fa-trash"></i></button>
                                </form>
                            @endacl
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">{{ __('No resource found!') }}</td>
                </tr>
            @endif
            </tbody>
        </table>
        {!! $usersHasRoles->render() !!}
    </div>
</div>
@acl('assignRolesToUsers.form')
    <div class="modal fade" id="assign-role-to-user-modal" tabindex="-1" role="dialog" aria-labelledby="assign-role-to-user-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Assign role to user') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    <form id="assign-role-to-user" name="assign-role-to-user" method="POST" action="{{ route('account.assignRolesToUsers.assign') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="user" class="col-sm-3 col-form-label text-md-right">{{ __('User') }}</label>
                            <div class="col-md-7">
                                <select name="user" id="user" class="form-control">
                                    @foreach($users as $user)
                                        <option id="{{ $user->name }}" value="{{ $user->id }}" title="{{ $user->name }}">
                                            {{ $user->identity }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('user'))
                                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('user') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role"
                                   class="col-sm-3 col-form-label text-md-right">{{ __('Role') }}</label>
                            <div class="col-md-7">
                                <select name="role" id="role" class="form-control">
                                    @foreach($roles as $role)
                                        <option id="{{ $role->name }}"
                                                value="{{ $role->id }}">{{ $role->name }} ({{ $role->guard_name }})
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
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
    <script src="{{ asset('/js/assignroletouser.js') }}"></script>
@stop