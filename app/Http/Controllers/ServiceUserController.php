<?php

namespace App\Http\Controllers;

use App\Models\ServiceUser;
use App\Http\Requests\{StoreServiceUserRequest, UpdateServiceUserRequest};
use App\Models\ActivityLog;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ServiceUserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->datatable();
        return view('service-users.index');
    }

    public function create()
    {
        return view('service-users.create');
    }

    public function store(StoreServiceUserRequest $request)
    {
        $su = ServiceUser::create($request->validated());

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'create',
            'entity'    => 'service_user',
            'entity_id' => $su->id,
            'message'   => 'Service user created: '.$su->first_name.' '.$su->last_name,
        ]);

        return redirect()->route('service-users.index')->with('success','Service user created.');
    }

    // public function edit(ServiceUser $serviceUser)
    // {
    //     return view('service-users.edit', compact('serviceUser'));
        
    // }

    
public function edit(ServiceUser $serviceUser)
{
    $invoice = $serviceUser->invoice()->latest()->first(); // <-- GET OLD VALUES

    return view('service-users.edit', compact('serviceUser', 'invoice'));
}



    public function update(UpdateServiceUserRequest $request, ServiceUser $serviceUser)
    // public function update(Request $request, ServiceUser $serviceUser)
    {

        $old = $serviceUser->only(['first_name','last_name']);
                        // dd($request, $serviceUser->invoice);

        $serviceUser->fill($request->validated())->save();
        // $serviceUser->fill($request->all())->save();
    // Create invoice from request
    Invoice::create([
        'invoice_no'      => 'INV-' . time(),
        'service_user_id' => $serviceUser->id,
        'funder_id'       => $request->funder_id,
        'issue_date'      => now(),
        'due_date'        => now()->addDays(14),
        'status'          => 'draft',
        'total_amount'    => $request->care_price, // or calculation
        'generated_by'    => auth()->id(),
    ]);



        ActivityLog::create([
            'user_id'    => auth()->id(),
            'type'       => 'update',
            'entity'     => 'service_user',
            'entity_id'  => $serviceUser->id,
            'old_values' => $old,
            'new_values' => $serviceUser->only(['first_name','last_name']),
            'message'    => 'Service user updated: '.$serviceUser->first_name.' '.$serviceUser->last_name,
        ]);

        return redirect()->route('service-users.index')->with('success','Service user updated.');
    }

    public function destroy(ServiceUser $serviceUser)
    {
        $serviceUser->delete();

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'delete',
            'entity'    => 'service_user',
            'entity_id' => $serviceUser->id,
            'message'   => 'Service user deleted: '.$serviceUser->first_name.' '.$serviceUser->last_name,
        ]);

        return redirect()->route('service-users.index')->with('success','Service user deleted.');
    }

    /* Yajra */
    private function datatable()
    {
        return datatables()->eloquent(
ServiceUser::query()->select([
    'id','first_name','last_name','email','address','city','postcode','contact_number','is_active'
])
        )
        ->addColumn('name', fn($su) => $su->first_name.' '.$su->last_name)
        ->addColumn('status', fn($su) => $su->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>')
        ->addColumn('action', fn($su) => '
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle no-arrow" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="'.route('service-users.edit',$su).'">Edit</a></li>
                    <li>
                        <form action="'.route('service-users.destroy',$su).'" method="POST" onsubmit="return confirm(\'Delete?\')">
                            '.csrf_field().method_field('DELETE').'
                            <button class="dropdown-item text-danger">Delete</button>
                        </form>
                    </li>
                </ul>
            </div>
        ')
        ->rawColumns(['status','action'])
        ->toJson();
    }
}