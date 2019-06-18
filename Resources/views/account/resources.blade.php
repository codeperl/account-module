@extends('account::layouts.ajax')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="float-left">
                <h1>{{ __('Resources') }}</h1>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="float-right">
                @acl('account.resources.generate', '', 'POST')
                    <a class="btn btn-success" id="generate-resources" href="#" data-href="{{ route('account.resources.generate') }}">{{ __('Generate resources') }}</a>
                @endacl
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-primary">
            <tr>
                <th class="text-center">{{ __('HTTP command') }}</th>
                <th class="text-center">{{ __('URI') }}</th>
                <th class="text-center">{{ __('Resource') }}</th>
                <th class="text-center">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
                @if (count($resources))
                    @foreach ($resources as $resource)
                    <tr>
                        <td>{{ $resource->http_command }}</td>
                        <td>{{ $resource->uri }}</td>
                        <td>{{ $resource->resource }}</td>
                        <td class="text-center" width="15%">
                            @acl('account.resources.show', 'resource' => $resource->resource)
                                <a  href="#" data-href="{{ route('account.resources.show', ['resource' => $resource->resource]) }}" class="btn btn-link custom-color show-resource"><i class="fa fa-lg fa-eye"></i></a>
                            @endacl
                            @acl('resources.destroy', 'resource' => $resource->resource, 'DELETE')
                                <form action="{{ route('resources.destroy', ['resource' => $resource->resource]) }}" method="POST" class="d-inline delete">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-link custom-color"><i class="fa fa-lg fa-trash"></i></button>
                                </form>
                            @endacl
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">{{ __('No resource found!') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {!! $resources->render() !!}
    </div>
</div>

<div class="modal fade" id="bootstrap-modal-placeholder" tabindex="-1" role="dialog" aria-labelledby="bootstrap-modal-placeholder-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="modal-content">
        </div>
    </div>
</div>
@endsection
@section('extrascripts')
    <script src="{{ asset('/js/resources.js') }}"></script>
@stop