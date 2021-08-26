@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if(session('responseCreated'))
                    <div class="alert alert-success" role="alert">
                        Response published!
                    </div>
                @endif
                @if(session('responseDeleted'))
                    <div class="alert alert-success" role="alert">
                        Response deleted!
                    </div>
                @endif
                @if ($errors->has('task_id'))
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->get('task_id') as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

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
                            <dd>{{ $task->status }}</dd>
                        </dl>
                    </div>
                </div>
                @foreach($task->responses as $response)
                    <div class="card">
                        <div class="card-header">
                            {{ __('Response by: ') . $response->user->name }} |
                            {{ __('at: ') . $response->created_at }}
                            <a class="float-right text-muted" id="response-{{ $loop->iteration }}"
                               href="#response-{{ $loop->iteration }}">#{{ $loop->iteration }}</a>
                        </div>
                        <div class="card-body">
                            {{ $response->content }}
                        </div>
                    </div>
                @endforeach
                @can('addResponse', $task)
                    <hr>
                    <form action="{{ route('task.add-response', $task->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="task_id"
                               value="{{ encrypt($task->id) }}">
                        <div class="form-group">
                            <label>Your response</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content"
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Send</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
@endsection
