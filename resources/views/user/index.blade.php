@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('User list') }}
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            @can('create', \App\Models\User::class)
                                <a class="btn btn-secondary mb-1" href="{{ route('user.create') }}">
                                    Create user
                                </a>
                            @endcan
                            <a class="btn btn-light mb-1" href="{{ route('user.deleted') }}">
                                Show deleted
                            </a>
                        </div>
                        @if(session('created'))
                            <div class="alert alert-success" role="alert">
                                User created!
                            </div>
                        @endif
                        @if(session('deleted'))
                            <div class="alert alert-success" role="alert">
                                User deleted!
                            </div>
                        @endif
                        @include('user.partials.users-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
