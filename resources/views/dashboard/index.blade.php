@extends('layouts.app')
@push('styles')
    <style>
        .fc-event.bg-holiday {
            background-color: #69bf3e !important;
            color: #fff !important;
            align-content: center;
            text-align: center;
            opacity: 1 !important;
        }
    </style>
@endpush
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

@endsection
 



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

