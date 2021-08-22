@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Client list') }}
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            @can('create', \App\Models\Client::class)
                                <a class="btn btn-secondary mb-1" href="{{ route('client.create') }}">
                                    Create client
                                </a>
                            @endcan
                            <a class="btn btn-light mb-1" href="{{ route('client.deleted') }}">
                                Show deleted
                            </a>
                        </div>
                        @if(session('created'))
                            <div class="alert alert-success" role="alert">
                                Client created!
                            </div>
                        @endif
                        @if(session('deleted'))
                            <div class="alert alert-success" role="alert">
                                Client deleted!
                            </div>
                        @endif
                        @include('client.partials.clients-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
