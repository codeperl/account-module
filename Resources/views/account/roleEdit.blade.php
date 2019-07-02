@extends('account::layouts.ajax')
@section('content')
    <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalCenterTitle">{{__('Edit permission') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
    <div id="message"></div>
    {!! Form::model($role, ['id' => 'role', 'name' => 'role', 'method' => 'PATCH','route' => ['account.roles.update', $role->id]]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-6 mx-auto">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Role name') }}</label>
                        <div class="col-md-6">
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'id' => 'name', 'autofocus' => true)) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="guard_name" class="col-md-4 col-form-label text-md-right">{{ __('Guard name') }}</label>

                        <div class="col-md-6">
                            {!! Form::text('guard_name', null, array('placeholder' => 'Guard name','class' => 'form-control', 'id' => 'guard_name')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="mx-auto">
                    <h4><label for="name" class="mx-auto col-md-4 col-form-label text-md-right">{{ __('Permissions') }}</label></h4>
                </div>
                <br />
                <div class="row" style="padding: 0 30px 0;">
                    @foreach($permission as $value)
                        <div class="col-4 py-1 my-1" style="border-bottom: 1px solid #CCCCCC;">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'custom-control-input', 'id' => "permission[$value->id]")) }}
                                <label  class="custom-control-label" for="{{ "permission[$value->id]" }}">{{ $value->name }} ({{$value->guard_name}})</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-5 offset-md-4">
            <button type="submit" class="btn btn-primary btn-lg"> {{ __('Create role and assign permissions') }} </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div class="modal-footer">
</div>
@endsection