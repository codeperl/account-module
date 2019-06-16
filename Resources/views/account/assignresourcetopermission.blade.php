@extends('account::layouts.ajax')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Permissions has resources') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('assignResourcesToPermissions.form')
                    <a class="btn btn-success" id="assign-resource-to-permission-btn" href="#" data-href="{{ route('assignResourcesToPermissions.form') }}">{{ __('Assign resource to permission') }}</a>
                @endacl
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th class="text-center">{{ __('Permission') }}</th>
                <th class="text-center">{{ __('HTTP command') }}</th>
                <th class="text-center">{{ __('URI') }}</th>
                <th class="text-center">{{ __('Resource') }}</th>
                <th class="text-center">{{ __('Actions') }}</th>
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
        {!! $permissionsHasResources->render() !!}
    </div>
</div>
@endsection
@section('extrascripts')
    <script src="{{ asset('/js/assignresourcetopermission.js') }}"></script>
@stop