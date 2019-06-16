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
                {{--@acl('assignPermissionsToUsers.form')--}}
                    <a class="btn btn-success" id="assign-permission-to-user-btn" href="#" data-href="{{ route('assignPermissionsToUsers.form') }}">{{ __('Assign permission to user') }}</a>
                {{--@endacl--}}
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
@endsection
@section('extrascripts')
    <script src="{{ asset('/js/assignpermissiontouser.js') }}"></script>
@stop