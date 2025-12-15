@extends('layouts.app')


{{-- @push('styles')
    <style>
        .fc-event.bg-holiday {
            background-color: #69bf3e !important;
            color: #fff !important;
            align-content: center;
            text-align: center;
            opacity: 1 !important;
        }
 
        .fc .fc-daygrid-day-number, .fc .fc-col-header-cell-cushion  { 
            text-decoration: none;
            color: #000;
        }

        .fc-theme-standard td, .fc-theme-standard th {
            height: 120px;
        }
    </style>
@endpush --}}

@push('styles')
    <style>
        /* .fc-theme-standard td, .fc-theme-standard th {
        height: 140px !important;
        vertical-align: top;
    } */

        .fc-daygrid-day-frame.fc-scrollgrid-sync-inner {
            height: 120px;
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

        .fc-event.bg-holiday {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            font-style: normal;
        }
    </style>
@endpush


@section('title', 'Rostering')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h5>Rostering Calendar</h5>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddRoster">Add
                Roster</button>
            <button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()">Refresh</button>
        </div>
    </div>

    <div id="calendar"></div>

    {{-- Off-canvas add roster --}}
    <x-offcanvas id="offcanvasAddRoster" title="Add Roster Shift">
        <form action="{{ route('rostering.store') }}" method="POST">
            @csrf
            @include('rostering._form')
            <div class="d-grid gap-2 mt-3">
                <button class="btn btn-primary">Submit</button>
                {{-- <button class="btn btn-primary" type="submit">Submit</button> --}}

                <button type="reset" class="btn btn-outline-secondary">Reset</button>
            </div>
        </form>
    </x-offcanvas>

    
@endsection


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




{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: "{{ route('rostering.index', ['ajax' => true]) }}",

                eventDidMount: info => new bootstrap.Tooltip(info.el, {
                    title: info.event.extendedProps.tooltip,
                    container: 'body'
                }),

                eventClick: info => showRosterDetails(info.event)
            });

            calendar.render();

            function showRosterDetails(event) {
                Swal.fire({
                    title: 'Roster Details',
                    html: `
            <strong>Task:</strong> ${event.title}<br>
            <strong>Status:</strong> <span class="badge bg-${event.extendedProps.badge}">
                ${event.extendedProps.status}
            </span><br>
            <strong>Start:</strong> ${event.startStr}<br>
            <strong>End:</strong> ${event.endStr}<br><br>
            <div class="text-center mt-3">
                <button id="editRosterBtn" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-edit me-1"></i> Edit
                </button>
            </div>
        `,
                    showCloseButton: true,
                    showConfirmButton: false,
                    didOpen: () => {
                        const btn = document.getElementById('editRosterBtn');
                        if (btn) {
                            btn.addEventListener('click', () => openEditRoster(event.id));
                        }
                    }
                });
            }


            function openEditRoster(id) {
                Swal.close();
                fetch(`/rostering/${id}/edit`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('editRosterFormBody').innerHTML = data.form;
                        document.getElementById('editRosterForm').action = data.update_url;
                        new bootstrap.Offcanvas(document.getElementById('offcanvasEditRoster')).show();
                    })
                    .catch(() => Swal.fire('Error', 'Failed to load edit form.', 'error'));
            }
        });
    </script>
@endpush --}}
