@extends('account::layouts.ajax')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Permissions') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('permissions.create')
                    <button type="button" class="btn btn-success" id="create-permission-btn" data-toggle="modal" data-target="#create-permission-modal">
                        {{ __('Create Permission') }}
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
                <th class="text-center">{{ __('Guard name') }}</th>
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
                            @acl('permissions.show', 'id' => $permission->id)
                                <a href="#" data-href="{{ route('permissions.show', ['id' => $permission->id]) }}" class="btn btn-link custom-color"><i class="fa fa-lg fa-eye"></i></a>
                            @endacl
                            @acl('permissions.edit', 'id' => $permission->id)
                                <a href="#" data-href="{{ route('permissions.edit', ['id' => $permission->id]) }}" class="btn btn-link custom-color"><i class="fa fa-lg fa-edit"></i></a>
                            @endacl
                            @acl('permissions.destroy', 'id' => $permission->id, 'DELETE')
                                <form action="{{ route('permissions.destroy', ['id' => $permission->id]) }}" method="POST" class="d-inline delete">
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
        {!! $permissions->render() !!}
    </div>
</div>
@acl('permissions.create')
    <div class="modal fade" id="create-permission-modal" tabindex="-1" role="dialog" aria-labelledby="create-permission-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('Create permission') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    {!! Form::open(array('id' => 'permission', 'name' => 'permission', 'route' => 'account.permissions.store','method'=>'POST')) !!}
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('Permission name') }}</label>

                        <div class="col-md-6">
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'id' => 'name', 'autofocus' => true)) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="guard_name" class="col-sm-4 col-form-label text-md-right">{{ __('Guard name') }}</label>

                        <div class="col-md-6">
                            {!! Form::text('guard_name', null, array('placeholder' => 'Guard name','class' => 'form-control', 'id' => 'guard_name')) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-block btn-lg"> {{ __('Create and add new') }} </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endacl
@endsection
@section('extrascripts')
    <script src="{{ asset('/js/permissions.js') }}"></script>
@stop