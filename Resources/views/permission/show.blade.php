@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6"><div class="float-left"><strong>{{ __('Show permission') }}</strong></div></div>
                                <div class="col-md-6"><div class="float-right"><a class="btn btn-primary" href="{{ route('permissions.index') }}">{{ __('Back') }}</a></div></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row col-md-4"><h3>{{ __('Permission') }}</h3></div>
                            <div class="col-md-6">{{ $permission->name }}</div>
                            <div class="row col-md-4"><h3>{{ __('Guard') }}</h3></div>
                            <div class="col-md-6">{{ $permission->guard_name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection