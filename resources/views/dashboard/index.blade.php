@extends('layouts.app')

@section('title','Dashboard')
 
@section('content')
{{-- 4 stat cards --}}
<div class="row mb-4">
    <div class="col-sm-6 col-lg-3 mb-3">
        <x-card title="Users" subtitle="{{ $counts['users'] }}">
            <i class="bi bi-people text-primary fs-1"></i>
        </x-card>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <x-card title="Employees" subtitle="{{ $counts['employees'] }}">
            <i class="bi bi-person-badge text-success fs-1"></i>
        </x-card>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <x-card title="Service Users" subtitle="{{ $counts['serviceUsers'] }}">
            <i class="bi bi-person-heart text-info fs-1"></i>
        </x-card>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <x-card title="Funders" subtitle="{{ $counts['funders'] }}">
            <i class="bi bi-building text-warning fs-1"></i>
        </x-card>
    </div>
</div>

{{-- Tabs: Calendar | Invoices --}}
<ul class="nav nav-tabs mb-3" id="dashTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-pane" type="button">Rostering Calendar</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="invoice-tab" data-bs-toggle="tab" data-bs-target="#invoice-pane" type="button">Recent Invoices</button>
    </li>
</ul>

<div class="tab-content" id="dashTabContent">
    {{-- Calendar pane --}}
    <div class="tab-pane fade show active" id="calendar-pane" role="tabpanel">
        <div id="calendar"></div>
    </div>

    {{-- Invoice pane --}}
    <div class="tab-pane fade" id="invoice-pane" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Invoice #</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                    <tr>
                        <td>{{ $inv->invoice_no }}</td>
                        <td>{{ $inv->serviceUser->first_name }} {{ $inv->serviceUser->last_name }}</td>
                        <td>
                            <span class="badge bg-{{ $inv->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($inv->status) }}</span>
                        </td>
                        <td>£{{ number_format($inv->total_amount, 2) }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $inv) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                    @empty
                    <x-empty-table colspan="5" />
                    @endforelse
                </tbody>
            </table>
        </div>
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
window.rosters = @json($rosters);
</script>
@endpush



@push('scripts') 
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
                // ✅ Close the SweetAlert popup first
                Swal.close();
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


@endsection