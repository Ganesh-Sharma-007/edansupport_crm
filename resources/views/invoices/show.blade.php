@extends('layouts.app')

@section('title','Invoice '.$invoice->invoice_no)

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Invoice {{ $invoice->invoice_no }}</h5>
    <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6>Bill To</h6>
                <p class="mb-1"><strong>{{ $invoice->serviceUser->first_name }} {{ $invoice->serviceUser->last_name }}</strong></p>
                <p class="mb-1">{{ $invoice->serviceUser->address }}</p>
                <p class="mb-0">{{ $invoice->serviceUser->city }} {{ $invoice->serviceUser->postcode }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-1"><strong>Invoice #:</strong> {{ $invoice->invoice_no }}</p>
                <p class="mb-1"><strong>Issue Date:</strong> {{ $invoice->issue_date->format('d M Y') }}</p>
                <p class="mb-0"><strong>Due Date:</strong> {{ $invoice->due_date->format('d M Y') }}</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Description</th>
                        <th class="text-end">Amount (£)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Care services {{ $invoice->issue_date->format('d M Y') }} - {{ $invoice->due_date->format('d M Y') }}</td>
                        <td class="text-end">{{ number_format($invoice->total_amount, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-end">Total</th>
                        <th class="text-end">{{ number_format($invoice->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('invoices.generate', ['start_date' => $invoice->issue_date, 'end_date' => $invoice->due_date, 'customer' => $invoice->service_user_id]) }}" class="btn btn-primary btn-sm">Download PDF</a>
        </div>
    </div>
</div>
@endsection