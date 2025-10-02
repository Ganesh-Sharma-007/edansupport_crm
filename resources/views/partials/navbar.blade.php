<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo.png') }}" height="30" alt="Logo" class="me-2">
            <span class="fw-bold">Laravel CRM</span>
        </a>

        <div class="ms-auto d-flex align-items-center">
            {{-- Notification bell --}}
            <div class="dropdown me-3">
                <a href="#" id="notiDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="text-dark position-relative">
                    <img src="{{ asset('assets/images/bell.svg') }}" height="20">
                    @php $unread = auth()->user()->notifications()->where('is_read',0)->count(); @endphp
                    @if($unread)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger small">{{ $unread }}</span>
                    @endif
                </a>
                @include('partials.notification-popup')
            </div>

            {{-- Profile avatar --}}
            <div class="dropdown">
                <a href="#" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('assets/images/user-placeholder.png') }}"
                         alt="Avatar" class="rounded-circle" height="35" width="35">
                </a>
                @include('partials.profile-popup')
            </div>
        </div>
    </div>
</nav>