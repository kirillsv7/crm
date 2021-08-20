@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Deleted clients list') }}
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between">
                            <a class="btn btn-light mb-3 ml-auto" href="{{ route('client.index') }}">
                                Show active
                            </a>
                        </div>
                        @if(session('restored'))
                            <div class="alert alert-success" role="alert">
                                Client restored!
                            </div>
                        @endif
                        @include('client.partials.clients-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
