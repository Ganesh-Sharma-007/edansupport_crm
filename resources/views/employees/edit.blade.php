@extends('layouts.app')

@section('title','Edit Employee')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Edit Employee: {{ $employee->first_name }} {{ $employee->last_name }}</h5>
    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

<ul class="nav nav-tabs mb-3" id="empTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-pane">General</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="timesheet-tab" data-bs-toggle="tab" data-bs-target="#timesheet-pane">Timesheet</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="rosters-tab" data-bs-toggle="tab" data-bs-target="#rosters-pane">Rosters</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files-pane">Files</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="docs-tab" data-bs-toggle="tab" data-bs-target="#docs-pane">Documents</button>
    </li>
</ul>

<div class="tab-content" id="empTabContent">
    {{-- General --}}
    <div class="tab-pane fade show active" id="general-pane" role="tabpanel">
        <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('employees._form')
            <div class="d-grid gap-2 mt-3">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    {{-- Timesheet --}}
    <div class="tab-pane fade" id="timesheet-pane" role="tabpanel">
        @include('employees._timesheet')
    </div>

    {{-- Rosters --}}
    <div class="tab-pane fade" id="rosters-pane" role="tabpanel">
        <div id="empCalendar"></div>
    </div>

    {{-- Files --}}
    <div class="tab-pane fade" id="files-pane" role="tabpanel">
        @include('employees._files')
    </div>

    {{-- Documents --}}
    <div class="tab-pane fade" id="docs-pane" role="tabpanel">
        @include('employees._documents')
    </div>
</div>

@push('scripts')
<script>
window.empId = {{ $employee->id }};
</script>
<script src="{{ asset('assets/js/employee-tabs.js') }}"></script>
@endpush
@endsection