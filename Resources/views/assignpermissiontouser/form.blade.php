@extends('layouts.app')
@section('content')
<div class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Assign permission to user') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('assignPermissionToUser.assign') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="user"
                                       class="col-sm-3 col-form-label text-md-right">{{ __('User') }}</label>
                                <div class="col-md-7">
                                    <select name="user" id="user" class="form-control">
                                        @foreach($users as $user)
                                            <option id="{{ $user->name }}"
                                                    value="{{ $user->id }}">{{ $user->name }} {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('user') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permission" class="col-sm-3 col-form-label text-md-right">{{ __('Permission') }}</label>
                                <div class="col-md-7">
                                    <select name="permission" id="permission" class="form-control">
                                        @foreach($permissions as $permission)
                                            <option id="{{ $permission->name }}" value="{{ $permission->id }}" title="{{ $permission->name }}">
                                                {{ $permission->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('permission'))
                                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('permission') }}</strong></span>
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
</div>
@endsection