@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Task list') }}
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            @can('create', \App\Models\Task::class)
                                <a class="btn btn-secondary mb-1" href="{{ route('task.create') }}">
                                    Create task
                                </a>
                            @endcan
                            <a class="btn btn-light mb-1" href="{{ route('task.deleted') }}">
                                Show deleted
                            </a>
                        </div>
                        @if(session('created'))
                            <div class="alert alert-success" role="alert">
                                Task created!
                            </div>
                        @endif
                        @if(session('deleted'))
                            <div class="alert alert-success" role="alert">
                                Task deleted!
                            </div>
                        @endif
                        @include('task.partials.tasks-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
