@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6"><div class="float-left"><strong>{{ __('Show resource') }}</strong></div></div>
                                <div class="col-md-6"><div class="float-right"><a class="btn btn-primary" href="{{ route('resources.index') }}">{{ __('Back') }}</a></div></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row col-md-12"><h3>{{ __('HTTP commands') }}</h3></div>
                            <div class="col-md-12">{{ $resource->http_command     }}</div>
                            <div class="row col-md-12"><h3>{{ __('URI') }}</h3></div>
                            <div class="col-md-12">{{ $resource->uri }}</div>
                            <div class="row col-md-12"><h3>{{ __('Resource') }}</h3></div>
                            <div class="col-md-12">{{ $resource->resource }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection