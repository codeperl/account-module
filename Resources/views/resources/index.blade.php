@extends('layouts.app')
@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Resources') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('resources.generate')
                    <a class="btn btn-success" href="{{ route('resources.generate') }}">{{ __('Generate resources') }}</a>
                @endacl
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th>{{ __('Resource') }}</th>
            </tr>
            </thead>
            <tbody>
                @if (count($resources))
                    @foreach ($resources as $resource)
                    <tr>
                        <td>{{ $resource->resource }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ __('No resource found!') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {!! $resources->render() !!}
    </div>
</div>
@endsection