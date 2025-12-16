@extends('layouts.app')

@section('title','Edit Service User')


@push('styles')
    <style>
        /* .fc-theme-standard td, .fc-theme-standard th {
        height: 140px !important;
        vertical-align: top;
    } */

        .fc-daygrid-day-frame.fc-scrollgrid-sync-inner {
            height: 120px !important;
            vertical-align: top;
        }

        .fc-daygrid-day-events {
            max-height: 85px;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        .fc-daygrid-day-events::-webkit-scrollbar {
            width: 6px;
        }

        .fc-daygrid-day-events::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        .fc-event {
            /* font-size: 0.85rem; */
            /* margin: 2px 0; */
            /* border-radius: 3px; */
            padding: 2px 4px;
        }

        .fc-event.bg-holiday {
            background-color: #69bf3e !important;
            color: #fff !important;
            text-align: center;
            align-content: center;
            opacity: 1 !important;
        }
#appointment.show #suCalendar {
    width: 100% !important;
    /* min-height: 500px; */
}

        .fc-event.bg-holiday {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            font-style: normal;
        }
    </style>
@endpush

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





{{-- Off-canvas edit --}}
<x-offcanvas id="offcanvasEditRoster" title="Edit Roster">
    <form id="editRosterForm" method="POST">
        @csrf
        @method('PUT')
        <div id="editRosterFormBody">
            <!-- AJAX loaded form fields will go here -->
        </div>
        <div class="d-grid gap-2 mt-3">
            <button class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Close</button>
        </div>
    </form>
</x-offcanvas>




@push('scripts')
<script>
    window.suId = {{ $serviceUser->id }};
</script>

@php
    /* =========================
       ROSTER EVENTS
    ========================== */
    $events = $service_user_roster->map(function ($r) {
        return [
            'id'    => $r->id,
            'title' => 'Shift (' . $r->shift_hours . ' hrs)',
            'start' => $r->start->toDateTimeString(),
            'end'   => $r->end->toDateTimeString(),
            'allDay' => false,
            'display' => 'block',
            'backgroundColor' => match ($r->status) {
                'cancelled'   => '#dc3545',
                'complete'    => '#28a745',
                'in-progress' => '#ffc107',
                default       => '#0d6efd',
            },
            'borderColor' => 'transparent',
            'textColor' => '#fff',
            'extendedProps' => [
                'type'   => 'roster',
                'status' => $r->status,
                'tooltip' =>
                    "Employee: {$r->employee?->first_name}\n" .
                    "User: {$r->serviceUser?->first_name}",
            ],
        ];
    });

    /* =========================
       HOLIDAY EVENTS
    ========================== */
    $holidayEvents = $service_user_holiday->map(function ($h) {
        return [
            'id'    => 'holiday-' . $h->id,
            'title' => $h->name,
            'start' => $h->date->toDateString(),
            'allDay' => true,
            'display' => 'background',
            'classNames' => ['bg-holiday'],
            'extendedProps' => [
                'type'    => 'holiday',
                'tooltip' => "Public Holiday: {$h->name}",
            ],
        ];
    });

    /* =========================
       MERGE EVENTS
    ========================== */
    $allEvents = $events->merge($holidayEvents);
@endphp

<script>
    window.suRosterEvents = @json($allEvents);
</script>

<script src="{{ asset('assets/js/service-user-tabs.js') }}"></script>
@endpush

@endsection