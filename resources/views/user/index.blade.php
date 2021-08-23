@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                @if(session('created') || session('deleted') || session('restored'))
                    <div class="alert alert-success" role="alert">
                        @if(session('created')) User created! @endif
                        @if(session('deleted')) User deleted! @endif
                        @if(session('restored')) User restored! @endif
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        @include('user.partials.users-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
