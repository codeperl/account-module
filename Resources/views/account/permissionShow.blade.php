@extends('account::layouts.ajax')
@section('content')
<div class="modal-header bg-primary">
    <strong class="modal-title" id="show-permission"><strong>{{ __('Show permission') }}</strong></strong>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-4"><strong>{{ __('Permission') }}</strong></div>
        <div class="col-6"><p>{{ $permission->name }}</p></div>
        <div class="col-4"><strong>{{ __('Guard') }}</strong></div>
        <div class="col-6"><p>{{ $permission->guard_name }}</p></div>
    </div>
</div>
<div class="modal-footer"></div>
@endsection