@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Client create') }}</div>
                    <div class="card-body">
                        @include('client.partials.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
