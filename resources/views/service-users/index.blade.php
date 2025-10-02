@extends('layouts.app')

@section('title','Service Users')

@section('content')
<ul class="nav nav-tabs mb-3" id="suTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-pane">Active</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="inactive-tab" data-bs-toggle="tab" data-bs-target="#inactive-pane">Inactive</button>
    </li>
</ul>

<div class="tab-content" id="suTabContent">
    <div class="tab-pane fade show active" id="active-pane" role="tabpanel">
        <div class="d-flex justify-content-between mb-3">
            <h6>Active Service Users</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddServiceUser">Add Service User</button>
        </div>
        <div class="table-responsive">
            <table class="table table-sm align-middle w-100" id="activeSuTable">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="inactive-pane" role="tabpanel">
        <h6>Inactive Service Users</h6>
        <div class="table-responsive">
            <table class="table table-sm align-middle w-100" id="inactiveSuTable">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Postcode</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

{{-- Off-canvas create --}}
<x-offcanvas id="offcanvasAddServiceUser" title="Add Service User">
    <form action="{{ route('service-users.store') }}" method="POST">
        @csrf
        @include('service-users._form')
        <div class="d-grid gap-2 mt-3">
            <button class="btn btn-primary">Add</button>
            <button type="reset" class="btn btn-outline-secondary">Reset</button>
        </div>
    </form>
</x-offcanvas>
@endsection

@push('scripts')
<script>
$('#activeSuTable').DataTable({
    ajax: {
        url: '{{ route('service-users.index') }}',
        data: d => { d.active = 1; }
    },
    columns: [
        {data: 'action', name: 'action', orderable: false, searchable: false},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'address', name: 'address'},
        {data: 'city', name: 'city'},
        {data: 'contact_number', name: 'contact_number'},
        {data: 'status', name: 'status'}
    ]
});
$('#inactiveSuTable').DataTable({
    ajax: {
        url: '{{ route('service-users.index') }}',
        data: d => { d.active = 0; }
    },
    columns: [
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'postcode', name: 'postcode'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});
</script>
@endpush