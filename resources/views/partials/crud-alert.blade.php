@if(session('created') || session('deleted') || session('restored'))
    <div class="alert alert-success" role="alert">
        @if(session('created')) {{ $model }} created! @endif
        @if(session('deleted')) {{ $model }} deleted! @endif
        @if(session('restored')) {{ $model }} restored! @endif
    </div>
@endif
