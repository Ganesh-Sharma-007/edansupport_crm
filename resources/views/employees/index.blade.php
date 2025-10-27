@extends('layouts.app')
@section('title','Employees')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Employees</h5>
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddEmployee">Add Employee</button>
        <button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()">Refresh</button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm align-middle w-100" id="employeesTable">
        <thead class="table-light">
            <tr>
                <th></th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>City</th>
                <th>Marital</th>
                <th>Gender</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>

{{-- Off-canvas create --}}
<x-offcanvas id="offcanvasAddEmployee" title="Add Employee">
    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('employees._form')
        <div class="d-grid gap-2 mt-3">
            <button class="btn btn-primary">Add</button>
            <button type="reset" class="btn btn-outline-secondary">Reset</button>
        </div>
    </form>
</x-offcanvas>
@endsection

@push('scripts')
<script>
$('#employeesTable').DataTable({
    ajax: '{{ route('employees.index') }}',
    columns: [
        {data: 'action', name: 'action', orderable: false, searchable: false},
        {data: 'first_name', name: 'first_name'},
        {data: 'last_name', name: 'last_name'},
        {data: 'city', name: 'city'},
        {data: 'marital_status', name: 'marital_status'},
        {data: 'gender', name: 'gender'},
    ]
});
</script>
@endpush