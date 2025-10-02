@props(['title', 'subtitle' => null])

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">{{ $title }}</h5>
        @if($subtitle)
            <small class="text-muted">{{ $subtitle }}</small>
        @endif
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>