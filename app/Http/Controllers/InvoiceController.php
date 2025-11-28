<?php

namespace App\Http\Controllers;

use App\Models\{Invoice, ServiceUser, Funder};
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->datatable();
        return view('invoices.index');
    }

    // public function generate(StoreInvoiceRequest $request)
    // {
    //     $data = $request->validated();

    //     $invoice = Invoice::create([
    //         'invoice_no'      => 'INV-'.time(),
    //         'service_user_id' => $data['customer'],
    //         'funder_id'       => $data['funder_id'] ?? null,
    //         'issue_date'      => $data['start_date'],
    //         'due_date'        => $data['end_date'],
    //         // 'total_amount'    => $this->calculateTotal($data),
    //         'total_amount'    => $data['total_amount'],
    //         'generated_by'    => auth()->id(),
    //         'status'          => 'draft',
    //     ]);

    //     ActivityLog::create([
    //         'user_id'   => auth()->id(),
    //         'type'      => 'create',
    //         'entity'    => 'invoice',
    //         'entity_id' => $invoice->id,
    //         'message'   => 'Invoice generated: '.$invoice->invoice_no,
    //     ]);

    //     // PDF stream
    //     $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
    //     return $pdf->download($invoice->invoice_no.'.pdf');
    // }

    public function generate(StoreInvoiceRequest $request)
{
    $data = $request->validated();

    $serviceUser = ServiceUser::find($data['customer']);

    $careHours = $serviceUser->care_hours;
    $visitDuration = $serviceUser->visit_duration;
    $carePrice = $serviceUser->care_price;

    $totalAmount = $careHours * $visitDuration * $carePrice;

    // Optional: prorate based on date range
    $days = \Carbon\Carbon::parse($data['start_date'])->diffInDays($data['end_date']) + 1;
    $dailyRate = $totalAmount / 7; // assuming weekly rate
    $totalAmount = round($dailyRate * $days, 2);

    $invoice = Invoice::create([
        'invoice_no'      => 'INV-' . time(),
        'service_user_id' => $serviceUser->id,
        'funder_id'       => $serviceUser->funder_id,
        'issue_date'      => $data['start_date'],
        'due_date'        => $data['end_date'],
        'total_amount'    => $totalAmount,
        'generated_by'    => auth()->id(),
        'status'          => 'draft',
    ]);

    ActivityLog::create([
        'user_id'   => auth()->id(),
        'type'      => 'create',
        'entity'    => 'invoice',
        'entity_id' => $invoice->id,
        'message'   => 'Invoice generated: ' . $invoice->invoice_no,
    ]);

    $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
    return $pdf->download($invoice->invoice_no . '.pdf');
}

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'delete',
            'entity'    => 'invoice',
            'entity_id' => $invoice->id,
            'message'   => 'Invoice deleted: '.$invoice->invoice_no,
        ]);

        return redirect()->route('invoices.index')->with('success','Invoice deleted.');
    }

    /* Yajra */
    private function datatable()
    {
        return datatables()->eloquent(
            Invoice::with(['serviceUser','funder'])->select(['id','invoice_no','service_user_id','funder_id','issue_date','due_date','status','total_amount'])
        )
        ->addColumn('customer', fn($inv) => $inv->serviceUser->first_name.' '.$inv->serviceUser->last_name)
        ->addColumn('status_badge', fn($inv) => '<span class="badge bg-'.($inv->status === 'published' ? 'success' : 'secondary').'">'.ucfirst($inv->status).'</span>')
        ->addColumn('action', fn($inv) => '
            <a href="'.route('invoices.show',$inv).'" class="btn btn-sm btn-outline-primary">View</a>
            <form action="'.route('invoices.destroy',$inv).'" method="POST" class="d-inline" onsubmit="return confirm(\'Delete?\')">
                '.csrf_field().method_field('DELETE').'
                <button class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
        ')
        ->rawColumns(['status_badge','action'])
        ->toJson();
    }

    // private function calculateTotal(array $data): float
    // {
    //     // dummy calc – replace with real logic
    //     return 250.00;
    // }
}