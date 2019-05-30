@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Assign resource to permission') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('assignResourceToPermission.assign') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="permission"
                                       class="col-sm-3 col-form-label text-md-right">{{ __('Permission') }}</label>
                                <div class="col-md-7">
                                    <select name="permission" id="permission" class="form-control">
                                        @foreach($permissions as $permission)
                                            <option id="{{ $permission->name }}"
                                                    value="{{ $permission->id }}">{{ $permission->name }}
                                                ({{ $permission->guard_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('permission'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('permission') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="resource" class="col-sm-3 col-form-label text-md-right">{{ __('Resource') }}</label>
                                <div class="col-md-7">
                                    <select name="resource" id="resource" class="form-control">
                                        @foreach($resources as $resource)
                                            <option id="{{ $resource->resource }}" value="{{ $resource->resource }}" title="{{ $resource->resource }}">
                                                {{ $resource->resource }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('resource'))
                                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('resource') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-7 offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        {{ __('Assign') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection