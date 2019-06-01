@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Assign role to user') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('assignPermissionsToRoles.assign') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="user" class="col-sm-3 col-form-label text-md-right">{{ __('User') }}</label>
                                    <div class="col-md-7">
                                        <select name="user" id="user" class="form-control">
                                            @foreach($users as $user)
                                                <option id="{{ $user->name }}" value="{{ $user->id }}" title="{{ $user->name }}">
                                                    {{ $user->name }} {{ $user->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('user'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('user') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="role"
                                           class="col-sm-3 col-form-label text-md-right">{{ __('Role') }}</label>
                                    <div class="col-md-7">
                                        <select name="role" id="role" class="form-control">
                                            @foreach($roles as $role)
                                                <option id="{{ $role->name }}"
                                                        value="{{ $role->id }}">{{ $role->name }} ({{ $role->guard_name }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('role'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
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