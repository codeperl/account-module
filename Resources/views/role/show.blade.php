@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6"><div class="float-left"><strong>{{ __('Show role') }}</strong></div></div>
                                <div class="col-md-6"><div class="float-right"><a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a></div></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row col-md-4"><h3>{{ __('Role') }}</h3></div>
                            <div class="col-md-6">{{ $role->name }}</div>
                            @if(!empty($rolePermissions))
                                <div class="row col-md-4"><strong>{{ __('Permissions') }}</strong></div>
                                <div class="col-md-6">
                                    @foreach($rolePermissions as $perm)
                                        <label class="label label-success">{{ $perm->name }}</label><br />
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection