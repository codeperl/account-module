@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6"><div class="float-left"><h3>{{ __('Create role') }}</h3></div></div>
                                <div class="col-md-6"><div class="float-right"><a class="btn btn-primary" href="{{ route('roles.index') }}">{{ __('Back') }}</a></div></div>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('role.name') }}</label>

                                <div class="col-md-6">
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('role.guard_name') }}</label>

                                <div class="col-md-6">
                                    {!! Form::text('guard_name', null, array('placeholder' => 'Guard name','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('role.permissions') }}</label>

                                <div class="col-md-6">
                                    @foreach($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                            {{ $value->name }} ({{$value->guard_name}})</label>
                                        <br/>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary"> {{ __('Submit') }} </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection