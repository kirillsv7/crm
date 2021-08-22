@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Task details') }}</div>
                    <div class="card-body">
                        <dl>
                            <dt>Title</dt>
                            <dd>{{ $task->title }}</dd>
                            <dt>Description</dt>
                            <dd>{{ $task->description }}</dd>
                            <dt>Project</dt>
                            <dd>{{ $task->project->title ?? '' }}</dd>
                            <dt>Client</dt>
                            <dd>{{ $task->project->client->company ?? '' }}</dd>
                            <dt>Assigned user</dt>
                            <dd>{{ $task->project->user->name ?? '' }}</dd>
                            <dt>Status</dt>
                            <dd>{{ $task->status_id }}</dd>
                        </dl>
                    </div>
                </div>
                @foreach($task->responses as $response)
                    <div class="card">
                        <div class="card-header">
                            {{ __('Response by: ') . $response->user->name }} |
                            {{ __('at: ') . $response->created_at }}
                        </div>
                        <div class="card-body">
                            {{ $response->content }}
                        </div>
                    </div>
                @endforeach
                <form action="{{ route('response.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                    <textarea class="form-control @error('content') is-invalid @enderror" name="content"
                              required>{{ old('content') }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
