@extends('account::layouts.ajax')
@section('content')
<div class="modal-header bg-primary">
    <strong class="modal-title" id="show-resource"><strong>{{ __('Show role') }}</strong></strong>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-4"><strong>{{ __('Role') }}</strong></div>
        <div class="col-6"><p>{{ $role->name }}</p></div>
        <div class="col-4"><strong>{{ __('Guard') }}</strong></div>
        <div class="col-6"><p>{{ $role->guard_name }}</p></div>
        @if(!empty($rolePermissions))
            <div class="col-4"><strong>{{ __('Permissions') }}</strong></div>
            <ul id="permission-list" class="col-6">
                @foreach($rolePermissions as $perm)
                    <li>{{ $perm->name }} ({{$perm->guard_name}})</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
<div class="modal-footer"></div>
@endsection