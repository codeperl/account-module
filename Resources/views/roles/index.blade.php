@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Roles') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('roles.create')
                    <a class="btn btn-success" href="{{ route('roles.create') }}">{{ __('Create New Role') }}</a>
                @endacl
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th class="text-center">{{ __('Role') }}</th>
                <th class="text-center">{{ __('Guard name') }}</th>
                <th class="text-center">{{ __('Updated at') }}</th>
                <th class="text-center">{{ __('Created at') }}</th>
                <th class="text-center">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
                @if ($roles)
                    @foreach ($roles as $role)
                    <tr>
                        <td class="text-center">{{ $role->name }}</td>
                        <td class="text-center">{{ $role->guard_name }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($role->updated_at)->format('d F, Y') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($role->created_at)->format('d F, Y') }}</td>
                        <td class="text-center">
                            @acl('roles.show', 'id' => $role->id)
                            <a href="{{ route('roles.show', ['id' => $role->id]) }}" class="btn btn-link custom-color"><i class="fa fa-lg fa-eye"></i></a>
                            @endacl
                            @acl('roles.edit', 'id' => $role->id)
                            <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="btn btn-link custom-color"><i class="fa fa-lg fa-edit"></i></a>
                            @endacl
                            @acl('roles.destroy', 'id' => $role->id, 'DELETE')
                                <form action="{{ route('roles.destroy', ['id' => $role->id]) }}" method="POST" class="d-inline delete">
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
                        <td colspan="5">{{ __('No resource found!') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {!! $roles->render() !!}
    </div>
</div>
@endsection