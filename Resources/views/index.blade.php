@extends('layouts.app')
@section('content')
    <ul class="nav nav-tabs nav-pills nav-fill" id="authorization" role="authorizationlist">
        <li class="nav-item">
            <a class="nav-link tab active" id="resources-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.resources.tab') }}" data-target="#resources" role="tab" aria-controls="resources" aria-selected="true"><em>{{ __('Resources') }}</em></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="permissions-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.permissions.tab') }}" data-target="#permissions" role="tab" aria-controls="permissions" aria-selected="false"><em>{{ __('Permissions') }}</em></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="assign-resource-to-permission-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.assign-resource-to-permission.tab') }}" data-target="#assign-resource-to-permission" role="tab" aria-controls="assign-resource-to-permission" aria-selected="false"><em>{{ __('Assign resource to permission') }}</em></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="roles-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.roles.tab') }}" data-target="#roles" role="tab" aria-controls="roles" aria-selected="false"><em>{{ __('Roles') }}</em></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="assign-role-to-user-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.assign-role-to-user.tab') }}" data-target="#assign-role-to-user" role="tab" aria-controls="assign-role-to-user" aria-selected="false"><em>{{ __('Assign role to user') }}</em></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="assign-permission-to-user-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.assign-permission-to-user.tab') }}" data-target="#assign-permission-to-user" role="tab" aria-controls="assign-permission-to-user" aria-selected="false"><em>{{ __('Assign permission to user') }}</em></a>
        </li>
    </ul>
    <div class="tab-content" id="authorizationContent">
        <div class="tab-pane fade show active" id="resources" role="tabpanel" aria-labelledby="resources-tab">
            <br />
            <div id="resources-placeholder">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="float-left">
                                <h1>{{ __('Resources') }}</h1>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="float-right">
                                @acl('resources.generate')
                                <a class="btn btn-success" id="generate-resources" href="#" data-href="{{ route('account.resources.generate') }}">{{ __('Generate resources') }}</a>
                                @endacl
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="bg-primary">
                            <tr>
                                <th class="text-center">{{ __('HTTP command') }}</th>
                                <th class="text-center">{{ __('URI') }}</th>
                                <th class="text-center">{{ __('Resource') }}</th>
                                <th class="text-center">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($resources))
                                @foreach ($resources as $resource)
                                    <tr>
                                        <td>{{ $resource->http_command }}</td>
                                        <td>{{ $resource->uri }}</td>
                                        <td>{{ $resource->resource }}</td>
                                        <td class="text-center" width="15%">
                                            @acl('resources.show', 'resource' => $resource->resource)
                                            <a href="#" data-href="{{ route('resources.show', ['resource' => $resource->resource]) }}" class="btn btn-link custom-color"><i class="fa fa-lg fa-eye"></i></a>
                                            @endacl
                                            @acl('resources.destroy', 'resource' => $resource->resource, 'DELETE')
                                            <form action="{{ route('resources.destroy', ['resource' => $resource->resource]) }}" method="POST" class="d-inline delete">
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
                                    <td colspan="4">{{ __('No resource found!') }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {!! $resources->render() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="permissions-tab"></div>
        <div class="tab-pane fade" id="assign-resource-to-permission" role="tabpanel" aria-labelledby="assign-resource-to-permission-tab"></div>
        <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab"></div>
        <div class="tab-pane fade" id="assign-role-to-user" role="tabpanel" aria-labelledby="assign-role-to-user-tab"></div>
        <div class="tab-pane fade" id="assign-permission-to-user" role="tabpanel" aria-labelledby="assign-permission-to-user-tab"></div>
    </div>
@endsection
@section('extrascripts')
    <script src="{{ asset('/js/resources.js') }}"></script>
@stop