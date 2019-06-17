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
                    <button type="button" class="btn btn-success" id="assign-resource-to-permission-btn" data-toggle="modal" data-target="#assign-resource-to-permission-modal">
                        {{ __('Assign resource to permission') }}
                    </button>
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
@acl('assignResourcesToPermissions.form')
    <div class="modal fade" id="assign-resource-to-permission-modal" tabindex="-1" role="dialog" aria-labelledby="assign-resource-to-permission-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Assign resource to permission') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    <form id="assign-resource-to-permission" name="assign-resource-to-permission" method="POST" action="{{ route('account.assignResourcesToPermissions.assign') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="permission"
                                   class="col-sm-3 col-form-label text-md-right">{{ __('Permission') }}</label>
                            <div class="col-md-7">
                                <select name="permission" id="permission" class="form-control">
                                    @foreach($permissions as $permission)
                                        <option id="{{ $permission->name }}"
                                                value="{{ $permission->id }}">{{ $permission->name }}
                                            ({{ $permission->guard_name }})
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('permission'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('permission') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="resource" class="col-sm-3 col-form-label text-md-right">{{ __('Resource') }}</label>
                            <div class="col-md-7">
                                <select name="resource" id="resource" class="form-control">
                                    @foreach($resources as $resource)
                                        <option id="{{ $resource->resource }}" value="{{ $resource->resource }}" title="{{ $resource->uri }}">
                                            {{ $resource->http_command }} - {{ $resource->uri }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('resource'))
                                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('resource') }}</strong></span>
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
    <script src="{{ asset('/js/assignresourcetopermission.js') }}"></script>
@stop