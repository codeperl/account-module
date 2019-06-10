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
                @acl('permissions.create')
                    <a class="btn btn-success" href="{{ route('permissions.create') }}">{{ __('Create Permission') }}</a>
                @endacl
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th class="text-center">{{ __('Permission') }}</th>
                <th class="text-center">{{ __('Guard Name') }}</th>
                <th class="text-center">{{ __('Updated at') }}</th>
                <th class="text-center">{{ __('Created at') }}</th>
                <th class="text-center">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
                @if (count($permissions))
                    @foreach ($permissions as $permission)
                    <tr>
                        <td class="text-center">{{ $permission->name }}</td>
                        <td class="text-center">{{ $permission->guard_name }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($permission->updated_at)->format('d F, Y') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($permission->created_at)->format('d F, Y') }}</td>
                        <td class="text-center">
                            @acl('permissions.show', "['id' => $permission->id]")
                                <a href="{{ route('permissions.show', ['id' => $permission->id]) }}" class="btn btn-link custom-color"><i class="fa fa-lg fa-eye"></i></a>
                            @endacl
                            @acl('permissions.edit', "['id' => $permission->id]")
                                <a href="{{ route('permissions.edit', ['id' => $permission->id]) }}" class="btn btn-link custom-color"><i class="fa fa-lg fa-edit"></i></a>
                            @endacl
                            @acl('permissions.destroy', "['id' => $permission->id]", 'destroy')
                            <form action="{{ route('permissions.destroy', ['id' => $permission->id]) }}" method="POST" class="d-inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-link custom-color"><i class="fa fa-lg fa-trash"></i></button>
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
        {!! $permissions->render() !!}
    </div>
</div>
@endsection