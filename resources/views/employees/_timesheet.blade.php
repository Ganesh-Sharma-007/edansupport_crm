<div class="table-responsive">
    <table id="timesheet-table" class="table table-sm w-100 align-middle table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>Week Start</th>
                <th>Total Hours</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
                <th>Sun</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


@push('scripts')
<script>
$(function() {
    $('#timesheet-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('employees.timesheet', $employee->id) }}',
        columns: [
            { data: 'week_start', name: 'week_start' },
            { data: 'total', name: 'total' },
            { data: 'Mon', name: 'Mon' },
            { data: 'Tue', name: 'Tue' },
            { data: 'Wed', name: 'Wed' },
            { data: 'Thu', name: 'Thu' },
            { data: 'Fri', name: 'Fri' },
            { data: 'Sat', name: 'Sat' },
            { data: 'Sun', name: 'Sun' },
        ]
    });
});
</script>
@endpush