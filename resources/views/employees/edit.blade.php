



@extends('layouts.app')

@section('title','Edit Employee')




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
.fc-event.bg-holiday{
    font-size: 1.5rem !important;
    font-weight: 700  !important;
    font-style: normal;
}
</style>
@endpush
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('empCalendar');

        if (!calendarEl || typeof window.empId === 'undefined') {
            console.warn('Calendar container or empId missing');
            return;
        }

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            height: 650,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            events: `/employees/${window.empId}/rosters`,
                    // ✅ Limit visible events and show "+ more" link
            dayMaxEvents: 3,
            // dayMaxEventRows: true,

            eventDidMount: function (info) {
                // Tooltip
                new bootstrap.Tooltip(info.el, {
                    title: info.event.extendedProps.tooltip,
                    placement: 'top',
                    trigger: 'hover'
                });
            },

            eventClick: function (info) {
                const event = info.event;
                const props = event.extendedProps;

                // Build alert details dynamically
                if (props.type === 'roster') {
                    Swal.fire({
                        title: `<strong>Roster Details</strong>`,
                        html: `
                            <div class="text-start">
                                <p><b>Service User:</b> ${props.tooltip.replace('Service User: ', '')}</p>
                                <p><b>Status:</b> ${props.status}</p>
                                <p><b>Start:</b> ${event.start.toLocaleString()}</p>
                                <p><b>End:</b> ${event.end ? event.end.toLocaleString() : 'N/A'}</p>
                            </div>
                        `,
                        icon: 'info',
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#0d6efd',
                    });
                } else if (props.type === 'holiday') {
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
            },
        });

        // Render only when tab is shown
        const tab = document.querySelector('#rosters-tab');
        if (tab) {
            tab.addEventListener('shown.bs.tab', () => {
                calendar.render();
            });
        }
    });
</script>
@endpush



{{-- @push('scripts')
<script>
    window.empId = {{ $employee->id }};
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const calEl = document.getElementById('empCalendar');
    if (!calEl || !window.empId) return;

    const calendar = new FullCalendar.Calendar(calEl, {
        contentHeight: 550,
        expandRows: false,
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap5',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },

        // ✅ Employee rosters endpoint
        events: `/employees/${window.empId}/rosters`,

        dayMaxEvents: 3,

        // =====================
        // TOOLTIP
        // =====================
        eventDidMount: info => {
            if (info.event.extendedProps?.tooltip) {
                new bootstrap.Tooltip(info.el, {
                    title: info.event.extendedProps.tooltip,
                    container: 'body'
                });
            }
        },

        // =====================
        // CLICK EVENT
        // =====================
        eventClick: info => {
            const event = info.event;
            const props = event.extendedProps;

            // 🎉 Holiday popup
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

            // 👤 Roster popup (same UX as Code 1)
            Swal.fire({
                title: 'Roster Details',
                html: `
                    <strong>Title:</strong> ${event.title}<br>
                    <strong>Date:</strong> ${event.startStr}<br>
                    <strong>Status:</strong> ${props.status ?? 'NA'}<br>

                    <div class="text-center mt-3">
                        <button id="editRosterBtn" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </button>
                        <button id="deleteRosterBtn" class="btn btn-sm btn-outline-danger">
                            <i class="fa fa-trash me-1"></i> Delete
                        </button>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                didOpen: () => {

                    document.getElementById('editRosterBtn')
                        ?.addEventListener('click', () => {
                            openEditRoster(event.id);
                        });

                    document.getElementById('deleteRosterBtn')
                        ?.addEventListener('click', () => {
                            deleteRoster(event.id);
                        });
                }
            });
        }
    });

    calendar.render();

    // =====================
    // Fix FullCalendar inside Bootstrap tabs
    // =====================
    document.addEventListener('shown.bs.tab', () => {
        setTimeout(() => calendar.updateSize(), 50);
    });

    // =====================
    // EDIT ROSTER (Offcanvas)
    // =====================
    function openEditRoster(id) {
        Swal.close();
        fetch(`/rostering/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('editRosterFormBody').innerHTML = data.form;
                document.getElementById('editRosterForm').action = data.update_url;
                new bootstrap.Offcanvas(
                    document.getElementById('offcanvasEditRoster')
                ).show();
            })
            .catch(() => Swal.fire('Error', 'Failed to load edit form.', 'error'));
    }

    // =====================
    // DELETE ROSTER
    // =====================
    function deleteRoster(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "This roster will be permanently deleted!",
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
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                    },
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire("Deleted!", data.message ?? "Roster deleted.", "success");
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
@endpush --}}

  



@endsection