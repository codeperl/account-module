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
                <th>{{ __('User') }}</th>
                <th>{{ __('Role') }}</th>

            </tr>
            </thead>
            <tbody>
            @if (count($usersHasRoles))
                @foreach ($usersHasRoles as $userHasRole)
                    <tr>
                        <td> {{ $userHasRole->user_name  }} - {{ $userHasRole->user_email  }} </td>
                        <td> {{ $userHasRole->role_name  }} ({{ $userHasRole->role_guard_name  }}) </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">{{ __('No resource found!') }}</td>
                </tr>
            @endif
            </tbody>
        </table>
        {!! $usersHasRoles->render() !!}
    </div>
</div>
@endsection