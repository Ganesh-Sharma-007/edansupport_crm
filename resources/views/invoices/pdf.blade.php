<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->invoice_no }}</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#333}
        .invoice-header{border-bottom:2px solid #0d6efd;padding-bottom:10px;margin-bottom:20px}
        .invoice-header h2{margin:0}
        .table{width:100%;border-collapse:collapse}
        .table th{background:#f8f9fa;padding:8px;text-align:left}
        .table td{padding:8px}
        .text-end{text-align:right}
    </style>
</head>
<body>
    <div class="invoice-header">
        <h2>INVOICE</h2>
        <p>Invoice #: {{ $invoice->invoice_no }} | Issue Date: {{ $invoice->issue_date->format('d M Y') }} | Due Date: {{ $invoice->due_date->format('d M Y') }}</p>
    </div>

    <p><strong>Bill To:</strong><br>
        {{ $invoice->serviceUser->first_name }} {{ $invoice->serviceUser->last_name }}<br>
        {{ $invoice->serviceUser->address }}<br>
        {{ $invoice->serviceUser->city }} {{ $invoice->serviceUser->postcode }}
    </p>

    <table class="table">
        <thead>
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
</body>
</html>