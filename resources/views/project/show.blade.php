@extends('layouts.app')

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card m-0">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        <dl>
                            <dt>Title</dt>
                            <dd>{{ $project->title }}</dd>
                            <dt>Description</dt>
                            <dd>{{ $project->description }}</dd>
                            <dt>Deadline</dt>
                            <dd>{{ $project->deadline_inverted }}</dd>
                            <dt>Client</dt>
                            <dd>{{ $project->client->company ?? '' }}</dd>
                            <dt>Assigned user</dt>
                            <dd>{{ $project->user->name ?? '' }}</dd>
                            <dt>Status</dt>
                            <dd>{{ $project->status }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-3">
        <div class="row">
            <div class="col-12">
                <div class="card m-0">
                    <div class="card-header">{{ __('Project tasks') }}</div>
                    <div class="card-body">
                        @include('task.partials.tasks-table', ['tasks' => $project->tasks])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
