@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('Resources') }}</h1>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th>{{ __('Resource') }}</th>
            </tr>
            </thead>
            <tbody>
                @if ($resources)
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
            <tfoot>
                <tr>
                    <th>{!! $resources->render() !!}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection