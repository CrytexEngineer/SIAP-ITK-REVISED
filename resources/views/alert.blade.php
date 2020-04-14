@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@if (session('status_failed'))
    <div class="alert alert-danger" role="alert">
        {{ session('status_failed') }}
    </div>
@endif
