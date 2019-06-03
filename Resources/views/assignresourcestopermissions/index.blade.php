@extends('layouts.app')
@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Permissions has Resources') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                {{--@can('permission-create')--}}
                <a class="btn btn-success" href="{{ route('assignResourcesToPermissions.form') }}">{{ __('Assign resource to permission') }}</a>
                {{--@endcan--}}
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th>{{ __('Permission') }}</th>
                <th>{{ __('Resource') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (count($permissionsHasResources))
                @foreach ($permissionsHasResources as $permissionHasResource)
                    <tr>
                        <td>{{ $permissionHasResource->permission->name }}</td>
                        <td>{{ $permissionHasResource->resource }}</td>
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