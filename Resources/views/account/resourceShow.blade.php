@extends('account::layouts.ajax')
@section('content')
<div class="modal-header bg-primary">
    <strong class="modal-title" id="show-resource"><strong>{{ __('Show resource') }}</strong></strong>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-4"><strong>{{ __('HTTP commands') }}</strong></div>
        <div class="col-6"><p>{{ $resource->http_command }}</p></div>
        <div class="col-4"><strong>{{ __('URI') }}</strong></div>
        <div class="col-6"><p>{{ $resource->uri }}</p></div>
        <div class="col-4"><strong>{{ __('Resource') }}</strong></div>
        <div class="col-6"><p style="word-wrap:break-word;">{{ $resource->resource }}</p></div>
    </div>
</div>
<div class="modal-footer"></div>
@endsection