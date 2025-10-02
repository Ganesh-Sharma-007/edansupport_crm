@props(['type' => 'info', 'message'])

@php
    $colour = match($type) {
        'success' => 'alert-success',
        'danger'  => 'alert-danger',
        'warning' => 'alert-warning',
        'info'    => 'alert-info',
        default   => 'alert-info',
    };
@endphp

@if ($message)
    <div class="alert {{ $colour }} alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif