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
                <h1>{{ __('Permissions') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                {{--@can('permission-create')--}}
                <a class="btn btn-success" href="{{ route('permissions.create') }}">{{ __('Create Permission') }}</a>
                {{--@endcan--}}
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th>{{ __('Permission') }}</th>
                <th>{{ __('Guard Name') }}</th>
                <th>{{ __('Updated at') }}</th>
                <th>{{ __('Created at') }}</th>
            </tr>
            </thead>
            <tbody>
                @if (count($permissions))
                    @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($permission->updated_at)->format('d F, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('d F, Y') }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">{{ __('No resource found!') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {!! $permissions->render() !!}
    </div>
</div>
@endsection