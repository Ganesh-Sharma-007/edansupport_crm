@extends('layouts.app')

@section('title','Rostering Calendar')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Rostering Calendar</h5>
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddRoster">Add Roster</button>
        <a href="{{ route('rostering.index') }}" class="btn btn-outline-secondary btn-sm">List View</a>
    </div>
</div>

<div id="calendar"></div>

{{-- Off-canvas add roster (reuse same partial) --}}
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

@push('scripts')
<script>
window.addEventListener('DOMContentLoaded', () => {
    const cal = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView    : 'dayGridMonth',
        headerToolbar  : { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,dayGridDay' },
        selectable     : true,
        selectHelper   : true,
        editable       : false,
        events         : '{{ route('rostering.index') }}?ajax=1',
        select: info => {
            // Open off-canvas with pre-filled dates
            document.querySelector('[name="start"]').value = info.startStr.slice(0,16);
            document.querySelector('[name="end"]').value   = info.endStr.slice(0,16);
            new bootstrap.Offcanvas(document.getElementById('offcanvasAddRoster')).show();
        },
        eventClick: info => {
            Swal.fire({
                title: info.event.title,
                html: `Start: ${info.event.start.toLocaleString()}<br>End: ${info.event.end.toLocaleString()}<br>Status: <span class="badge bg-${info.event.color==='#dc3545'?'danger':'success'}">${info.event.color==='#dc3545'?'Cancelled':'Assigned'}</span>`,
                showCloseButton: true
            });
        }
    });
    cal.render();
});
</script>
@endpush