@extends('layouts.app')

@section('title','Invoices')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Invoices</h5>
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGenerate">Generate Invoice</button>
        <button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()">Refresh</button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm align-middle w-100" id="invoicesTable">
        <thead class="table-light">
            <tr>
                <th>Invoice #</th>
                <th>Name</th>
                <th>Due Date</th>
                <th>Issue Date</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>

{{-- Generate modal --}}
<x-modal id="modalGenerate" title="Generate Invoice">
    <form action="{{ route('invoices.generate') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Start Date *</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">End Date *</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Customer *</label>
                <select name="customer" class="form-select" required>
                    <option value="">--</option>
                    @foreach(\App\Models\ServiceUser::where('is_active', true)->get() as $su)
                    <option value="{{ $su->id }}">{{ $su->first_name }} {{ $su->last_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Generate PDF</button>
        </div>
    </form>
</x-modal>
@endsection

@push('scripts')
<script>
$('#invoicesTable').DataTable({
    ajax: '{{ route('invoices.index') }}',
    columns: [
        {data: 'invoice_no', name: 'invoice_no'},
        {data: 'customer', name: 'customer'},
        {data: 'due_date', name: 'due_date'},
        {data: 'issue_date', name: 'issue_date'},
        {data: 'status_badge', name: 'status', orderable: false, searchable: false},
        {data: 'total_amount', name: 'total_amount'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});
</script>
@endpush