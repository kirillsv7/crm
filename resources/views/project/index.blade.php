@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Project list') }}
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            @can('create', \App\Models\Project::class)
                                <a class="btn btn-secondary mb-1" href="{{ route('project.create') }}">
                                    Create project
                                </a>
                            @endcan
                            <a class="btn btn-light mb-1" href="{{ route('project.deleted') }}">
                                Show deleted
                            </a>
                        </div>
                        @if(session('created'))
                            <div class="alert alert-success" role="alert">
                                Project created!
                            </div>
                        @endif
                        @if(session('deleted'))
                            <div class="alert alert-success" role="alert">
                                Project deleted!
                            </div>
                        @endif
                        @include('project.partials.projects-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
