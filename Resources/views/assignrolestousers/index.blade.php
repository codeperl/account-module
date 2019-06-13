@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Users has roles') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('assignRolesToUsers.form')
                    <a class="btn btn-success" href="{{ route('assignRolesToUsers.form') }}">{{ __('Assign role to user') }}</a>
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
@endsection