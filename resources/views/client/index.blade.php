@extends('layouts.app')

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                @if(session('created') || session('deleted') || session('restored'))
                    <div class="alert alert-success" role="alert">
                        @if(session('created')) Client created! @endif
                        @if(session('deleted')) Client deleted! @endif
                        @if(session('restored')) Client restored! @endif
                    </div>
                @endif
                <div class="card m-0">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        @include('client.partials.clients-table')
                    </div>
                    @if($clients->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $clients->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
