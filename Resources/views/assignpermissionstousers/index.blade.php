@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Users has Permissions') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('assignPermissionsToUsers.form')
                    <a class="btn btn-success" href="{{ route('assignPermissionsToUsers.form') }}">{{ __('Assign permission to user') }}</a>
                @endacl
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th>{{ __('User') }}</th>
                <th>{{ __('Permission') }}</th>

            </tr>
            </thead>
            <tbody>
            @if (count($usersHasPermissions))
                @foreach ($usersHasPermissions as $userHasPermission)
                    <tr>
                        <td> {{ $userHasPermission->user_name  }} - {{ $userHasPermission->user_email  }} - {{ $userHasPermission->user_phone  }} </td>
                        <td> {{ $userHasPermission->permission_name  }} ({{ $userHasPermission->permission_guard_name  }}) </td>
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
@endsection