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
                <h1>{{ __('Roles') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                {{--@can('role-create')--}}
                <a class="btn btn-success" href="{{ route('roles.create') }}">{{ __('Create New Role') }}</a>
                {{--@endcan--}}
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th>{{ __('Role') }}</th>
                <th>{{ __('Guard Name') }}</th>
                <th>{{ __('Updated at') }}</th>
                <th>{{ __('Created at') }}</th>
                <th>{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
                @if ($roles)
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->guard_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($role->updated_at)->format('d F, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d F, Y') }}</td>
                        <td>
                            @acl('roles.edit', "['id' => $role->id]")
                                <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="btn btn-link">Edit</a> |
                            @endacl
                            @acl('roles.destroy', "['id' => $role->id]", 'destroy')
                                <form action="{{ route('roles.destroy', ['id' => $role->id]) }}" method="POST">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-link">Delete</button>
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
        {!! $roles->render() !!}
    </div>
</div>
@endsection