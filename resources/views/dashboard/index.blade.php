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

@push('scripts')
<script>
window.rosters = @json($rosters);
</script>
@endpush
@endsection