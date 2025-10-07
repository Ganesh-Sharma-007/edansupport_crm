@extends('layouts.app')

@section('title','Rostering')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Rostering Calendar</h5>
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddRoster">Add Roster</button>
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



@push('scripts')
{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        editable: false,
        events: function(fetchInfo, successCallback, failureCallback) {
            axios.get('{{ route('rostering.index') }}', {
                params: {
                    start: fetchInfo.startStr,
                    end: fetchInfo.endStr,
                    ajax: 1
                }
            })
            .then(res => successCallback(res.data))
            .catch(err => failureCallback(err));
        },
        eventClick: info => {
            Swal.fire({
                title: 'Roster Details',
                html: `<strong>${info.event.title}</strong><br>
                       Start: ${info.event.start.toLocaleString()}<br>
                       End: ${info.event.end.toLocaleString()}<br>
                       Status: <span class="badge bg-${info.event.backgroundColor === '#dc3545' ? 'danger' : 'success'}">
                                ${info.event.backgroundColor === '#dc3545' ? 'Cancelled' : 'Assigned'}</span>`,
                showCloseButton: true
            });
        }
    });

    calendar.render();
});
</script> --}}

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    if (!calendarEl) {
        console.error("Calendar container not found.");
        return;
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView : 'dayGridMonth',
        headerToolbar: {
            left  : 'prev,next today',
            center: 'title',
            right : 'dayGridMonth,timeGridWeek,listWeek'
        },
        themeSystem: 'bootstrap5',
        selectable: true,
        editable: false,
        events: {
            url: "{{ route('rostering.index') }}",
            method: 'GET',
            extraParams: { ajax: true },
            failure: function() {
                Swal.fire('Error', 'Failed to load roster data.', 'error');
            }
        },
        eventDidMount: function(info) {
            new bootstrap.Tooltip(info.el, {
                title: info.event.title,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        },
        // eventClick: function(info) {
        //     const e = info.event;
        //     const colorClass =
        //         e.backgroundColor === '#dc3545' ? 'danger' :
        //         e.backgroundColor === '#0d6efd' ? 'primary' :
        //         e.backgroundColor === '#ffc107' ? 'warning' : 'success';

        //     Swal.fire({
        //         title: 'Roster Details',
        //         html: `
        //             <strong>Task:</strong> ${e.title}<br>
        //             <strong>Status:</strong> <span class="badge bg-${colorClass}">
        //                 ${e.extendedProps.status || 'assigned'}
        //             </span><br>
        //             <strong>Start:</strong> ${e.startStr}<br>
        //             <strong>End:</strong> ${e.endStr}<br><br>
        //             <div class="text-center mt-3">
        //                 <button type="button" id="editRosterBtn" class="btn btn-sm btn-outline-primary">
        //                     <i class="fa fa-edit me-1"></i> Edit
        //                 </button>
        //             </div>
        //         `,
        //         showCloseButton: true,
        //         showConfirmButton: false,
        //         didOpen: () => {
        //             document.getElementById('editRosterBtn').addEventListener('click', () => {
        //                 // window.location.href = `/rostering/${e.id}/edit`;
        //         let offcanvas = new bootstrap.Offcanvas(document.getElementById("offcanvasEditRoster"));
        //         offcanvas.show();
        //             });
        //         }

        //     });
        // },
        eventClick: function(info) {
    const e = info.event;
    const colorClass =
        e.backgroundColor === '#dc3545' ? 'danger' :
        e.backgroundColor === '#0d6efd' ? 'primary' :
        e.backgroundColor === '#ffc107' ? 'warning' : 'success';

    Swal.fire({
        title: 'Roster Details',
        html: `
            <strong>Task:</strong> ${e.title}<br>
            <strong>Status:</strong> <span class="badge bg-${colorClass}">
                ${e.extendedProps.status || 'assigned'}
            </span><br>
            <strong>Start:</strong> ${e.startStr}<br>
            <strong>End:</strong> ${e.endStr}<br><br>
            <div class="text-center mt-3">
                <button type="button" id="editRosterBtn" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-edit me-1"></i> Edit
                </button>
            </div>
        `,
        showCloseButton: true,
        showConfirmButton: false,
        didOpen: () => {
            $('#editRosterBtn').off('click').on('click', function() {
                $.get(`/rostering/${e.id}/edit`, function(res) {
                    // Inject form HTML
                    $('#editRosterFormBody').html(res.form);

                    // Update form action
                    $('#editRosterForm').attr('action', res.update_url);

                    // Show offcanvas
                    const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasEditRoster'));
                    offcanvas.show();
                }).fail(function() {
                    Swal.fire('Error', 'Failed to load edit form.', 'error');
                });
            });
        }
    });
},

        dateClick: function(info) {
            Swal.fire({
                title: 'Add Shift',
                text: 'You clicked on ' + info.dateStr,
                icon: 'info'
            });
        }
    });

    calendar.render();
});
</script>
@endpush
