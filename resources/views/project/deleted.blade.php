@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Deleted projects list') }}
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a class="btn btn-light mb-1" href="{{ route('project.index') }}">
                                Show active
                            </a>
                        </div>
                        @if(session('restored'))
                            <div class="alert alert-success" role="alert">
                                Project restored!
                            </div>
                        @endif
                        @include('project.partials.projects-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
