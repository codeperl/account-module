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
    {!! Form::model($permission, ['method' => 'PATCH','route' => ['account.permissions.update', $permission->id]]) !!}
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
            <button type="submit" class="btn btn-primary btn-block btn-lg"> {{ __('Update') }} </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div class="modal-footer">
</div>
@endsection