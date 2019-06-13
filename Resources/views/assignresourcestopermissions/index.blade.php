@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Permissions has resources') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('assignResourcesToPermissions.form')
                    <a class="btn btn-success" href="{{ route('assignResourcesToPermissions.form') }}">{{ __('Assign resource to permission') }}</a>
                @endacl
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th>{{ __('Permission') }}</th>
                <th>{{ __('HTTP command') }}</th>
                <th>{{ __('URI') }}</th>
                <th>{{ __('Resource') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($permissionsHasResources))
                @foreach ($permissionsHasResources as $permissionHasResource)
                    <tr>
                        <td>{{ $permissionHasResource->permission->name }}</td>
                        <td>{{ $permissionHasResource->http_command }}</td>
                        <td>{{ $permissionHasResource->uri }}</td>
                        <td>{{ $permissionHasResource->resource }}</td>
                        <td class="text-center">
                            @acl('assignResourcesToPermissions.unassign', 'permission' => $permissionHasResource->permission_id|'resource' => $permissionHasResource->resource, 'DELETE')
                                <form name="{{$permissionHasResource->permission_id}}{{$permissionHasResource->resource}}" action="{{ route('assignResourcesToPermissions.unassign') }}" method="POST" class="d-inline delete">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <input type="hidden" id="permission" name="permission" value="{{$permissionHasResource->permission_id}}" />
                                    <input type="hidden" id="resource" name="resource" value="{{$permissionHasResource->resource}}" />
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-lg fa-trash"></i></button>
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
        {!! $permissionsHasResources->render() !!}
    </div>
</div>
@endsection