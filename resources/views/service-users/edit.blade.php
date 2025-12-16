@extends('layouts.app')

@section('title', 'Edit Service User')


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
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Start Date & Time *</label>
        <input type="datetime-local" name="start" value="{{ old('start', isset($roster) && $roster->start ? $roster->start->format('Y-m-d\TH:i') : '') }}" class="form-control form-control-sm" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">End Date & Time *</label>
        <input type="datetime-local" name="end" value="{{ old('end', isset($roster) && $roster->end ? $roster->end->format('Y-m-d\TH:i') : '') }}" class="form-control form-control-sm" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Shift Hours</label>
        <input type="number" step="0.1" name="shift_hours" value="{{ old('shift_hours', $roster->shift_hours ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Status *</label>
        <select name="status" class="form-select form-select-sm" required>
            <option value="assigned"   @selected(old('status', $roster->status ?? '') == 'assigned')>Assigned</option>
            <option value="cancelled"  @selected(old('status', $roster->status ?? '') == 'cancelled')>Cancelled</option>
            <option value="complete"   @selected(old('status', $roster->status ?? '') == 'complete')>Complete</option>
            <option value="in-progress"@selected(old('status', $roster->status ?? '') == 'in-progress')>In-Progress</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Customer *</label>
        <select name="service_user_id" class="form-select form-select-sm" required>
            <option value="">--</option>
            @foreach(\App\Models\ServiceUser::where('is_active', true)->get() as $su)
            <option value="{{ $su->id }}" @selected(old('service_user_id', $roster->service_user_id ?? '') == $su->id)>{{ $su->first_name }} {{ $su->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Employee *</label>
        <select name="employee_id" class="form-select form-control-sm" required>
            <option value="">--</option>
            @foreach(\App\Models\Employee::where('is_active', true)->get() as $emp)
            <option value="{{ $emp->id }}" @selected(old('employee_id', $roster->employee_id ?? '') == $emp->id)>{{ $emp->first_name }} {{ $emp->last_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Travel Time (hours)</label>
        <input type="number" min="0" name="travel_hours" value="{{ old('travel_hours', $roster->travel_hours ?? '') }}" class="form-control form-control-sm">
    </div>
    <div class="col-md-6">
        <label class="form-label">Travel Time (minutes)</label>
        <input type="number" min="0" max="59" name="travel_minutes" value="{{ old('travel_minutes', $roster->travel_minutes ?? '') }}" class="form-control form-control-sm">
    </div>
</div>        </div>
        <div class="d-grid gap-2 mt-3">
            <button class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Close</button>
        </div>
    </form>
</x-offcanvas>





    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const calEl = document.getElementById('suCalendar');
                if (!calEl) return;

                const calendar = new FullCalendar.Calendar(calEl, {
                    // height: 600,
                    contentHeight: 550, // grid only
                    expandRows: false,
                    initialView: 'dayGridMonth',
                    themeSystem: 'bootstrap5',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },

                    // ✅ SAME resource route, just ajax flag
                    events: "{{ route('service-users.edit', [$serviceUser->id, 'ajax' => true]) }}",

                    dayMaxEvents: 3,

                    eventDidMount: info => {
                        if (info.event.extendedProps?.tooltip) {
                            new bootstrap.Tooltip(info.el, {
                                title: info.event.extendedProps.tooltip,
                                container: 'body'
                            });
                        }
                    },
                    eventClick: info => {
                        const event = info.event;
                        const props = event.extendedProps;

                        if (props.type === 'holiday') {
                            Swal.fire({
                                title: `<strong>Public Holiday</strong>`,
                                html: `
                        <div class="text-start">
                            <p><b>Name:</b> ${event.title}</p>
                            <p><b>Date:</b> ${event.start.toLocaleDateString()}</p>
                        </div>
                    `,
                                icon: 'success',
                                confirmButtonText: 'Close',
                                confirmButtonColor: '#198754',
                            });
                            return;
                        }
                        // ✅ Check event type (roster or holiday)
                        if (props.type === 'holiday') {
                            // 🎉 Holiday popup
                            Swal.fire({
                                title: `<strong>Public Holiday</strong>`,
                                html: `
                        <div class="text-start">
                            <p><b>Name:</b> ${event.title}</p>
                            <p><b>Date:</b> ${event.start.toLocaleDateString()}</p>
                        </div>
                    `,
                                icon: 'success',
                                confirmButtonText: 'Close',
                                confirmButtonColor: '#198754',
                            });
                        }


                        Swal.fire({
                            title: 'Appointment Details',
                            html: `
                                <strong>Title:</strong> ${event.title}<br>
                                <strong>Date:</strong> ${event.startStr}<br>
                                <strong>Status:</strong> ${props.status ?? 'NA'}<br>
                                <strong>Notes:</strong> ${props.notes ?? 'No notes'}<br><br>

                                <div class="text-center mt-3">
                                    <button id="editApptBtn" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-edit me-1"></i> Edit
                                    </button>
                                    <button id="deleteApptBtn" class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                            `,
                            showCloseButton: true,
                            showConfirmButton: false,
                            didOpen: () => {

                                document.getElementById('editApptBtn')?.addEventListener(
                                    'click', () => {
                                        openEditAppointment(event.id);
                                    });

                                document.getElementById('deleteApptBtn')?.addEventListener(
                                    'click', () => {
                                        deleteAppointment(event.id, calendar);
                                    });
                            }
                        });
                    }
                });

                calendar.render();

                // Fix FullCalendar inside Bootstrap tabs
                document.addEventListener('shown.bs.tab', () => {
                    setTimeout(() => calendar.updateSize(), 50);
                });








                // ================================
                //  EDIT Appointment (Offcanvas)
                // ================================ 
                function openEditAppointment(id) {
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


                // ================================
                // DELETE Appointment
                // ================================
                function deleteAppointment(id, calendar) {

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This appointment will be permanently deleted!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Yes, delete it!"
                    }).then(result => {

                        if (result.isConfirmed) {
                            fetch(`/rostering/${id}`, {
                                    method: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                            .content,
                                        "Accept": "application/json",
                                    },
                                })
                                .then(res => res.json())
                                .then(data => {
                                    Swal.fire("Deleted!", data.message ?? "Appointment deleted.",
                                    "success");
                                    calendar.refetchEvents();
                                })
                                .catch(() => {
                                    Swal.fire("Error!", "Something went wrong while deleting.", "error");
                                });
                        }
                    });
                }


            });
        </script>
    @endpush

@endsection
