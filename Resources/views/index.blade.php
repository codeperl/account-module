@extends('layouts.app')
@section('content')
    <ul class="nav nav-tabs nav-pills nav-fill" id="authorization" role="authorizationlist">
        <li class="nav-item">
            <a class="nav-link tab active" id="resources-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.resources.tab') }}" data-target="#authorization-placeholder" role="tab" aria-selected="true"><strong>{{ __('Resources') }}</strong></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="permissions-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.permissions.tab') }}" data-target="#authorization-placeholder" role="tab" aria-selected="false"><strong>{{ __('Permissions') }}</strong></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="assign-resource-to-permission-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.assign-resource-to-permission.tab') }}" data-target="#authorization-placeholder" role="tab" aria-selected="false"><strong>{{ __('Assign resource to permission') }}</strong></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="roles-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.roles.tab') }}" data-target="#authorization-placeholder" role="tab" aria-selected="false"><strong>{{ __('Roles') }}</strong></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="assign-role-to-user-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.assign-role-to-user.tab') }}" data-target="#authorization-placeholder" role="tab" aria-selected="false"><strong>{{ __('Assign role to user') }}</strong></a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab" id="assign-permission-to-user-tab" data-toggle="ajaxtab" href="#" data-href="{{ route('account.assign-permission-to-user.tab') }}" data-target="#authorization-placeholder" role="tab" aria-selected="false"><strong>{{ __('Assign permission to user') }}</strong></a>
        </li>
    </ul>
    <div class="tab-content" id="authorizationContent">
        <div class="tab-pane fade show active" id="resources" role="tabpanel" aria-labelledby="resources-tab">
            <br />
            <div id="authorization-placeholder">
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
                                            @acl('account.resources.show', 'resource' => $resource->resource)
                                                <a href="#" data-href="{{ route('account.resources.show', ['resource' => $resource->resource]) }}" class="btn btn-link custom-color show-resource"><i class="fa fa-lg fa-eye"></i></a>
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
    </div>

    <div class="modal fade" id="bootstrap-modal-placeholder-account" tabindex="-1" role="dialog" aria-labelledby="bootstrap-modal-placeholder-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="modal-content">
            </div>
        </div>
    </div>
@endsection
@section('extrascripts')
    <script src="{{ asset('/js/account.js') }}"></script>
    <script src="{{ asset('/js/resources.js') }}"></script>
@stop