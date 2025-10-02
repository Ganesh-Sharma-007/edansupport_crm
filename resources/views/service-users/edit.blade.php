@extends('layouts.app')

@section('title','Edit Service User')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Edit Service User: {{ $serviceUser->first_name }} {{ $serviceUser->last_name }}</h5>
    <a href="{{ route('service-users.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

<ul class="nav nav-tabs mb-3" id="suTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general">General</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact">Contact</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#invoice">Invoice</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#appointment">Appointment</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#health">Health Records</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#docs">Documents</button>
    </li>
</ul>

<div class="tab-content" id="suTabContent">
    <div class="tab-pane fade show active" id="general" role="tabpanel">
        <form action="{{ route('service-users.update', $serviceUser) }}" method="POST">
            @csrf @method('PUT')
            @include('service-users._form')
            <div class="d-grid gap-2 mt-3">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <div class="tab-pane fade" id="contact" role="tabpanel">
        @include('service-users._contact')
    </div>

    <div class="tab-pane fade" id="invoice" role="tabpanel">
        @include('service-users._invoice')
    </div>

    <div class="tab-pane fade" id="appointment" role="tabpanel">
        <div id="suCalendar"></div>
    </div>

    <div class="tab-pane fade" id="health" role="tabpanel">
        @include('service-users._health')
    </div>

    <div class="tab-pane fade" id="docs" role="tabpanel">
        @include('service-users._documents')
    </div>
</div>

@push('scripts')
<script>
window.suId = {{ $serviceUser->id }};
</script>
<script src="{{ asset('assets/js/service-user-tabs.js') }}"></script>
@endpush
@endsection