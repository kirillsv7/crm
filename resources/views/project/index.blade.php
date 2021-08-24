@extends('layouts.app')

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                @if(session('created') || session('deleted') || session('restored'))
                    <div class="alert alert-success" role="alert">
                        @if(session('created')) Project created! @endif
                        @if(session('deleted')) Project deleted! @endif
                        @if(session('restored')) Project restored! @endif
                    </div>
                @endif
                <div class="card m-0">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        @include('project.partials.projects-table')
                    </div>
                    @if($projects->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $projects->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
