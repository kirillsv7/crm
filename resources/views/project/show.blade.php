@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Project details') }}</div>
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
                            <dd>{{ $project->status_id }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">{{ __('Project tasks') }}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($project->tasks as $task)
                                    <tr>
                                        <td>{{ $task->id }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->status_id }}</td>
                                        <td>{{ $task->created_at }}</td>
                                        <td>{{ $task->updated_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
