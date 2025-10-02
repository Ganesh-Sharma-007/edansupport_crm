<?php

namespace App\Http\Controllers;

use App\Models\ServiceUser;
use App\Http\Requests\{StoreServiceUserRequest, UpdateServiceUserRequest};
use App\Models\ActivityLog;
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

    public function edit(ServiceUser $serviceUser)
    {
        return view('service-users.edit', compact('serviceUser'));
    }

    public function update(UpdateServiceUserRequest $request, ServiceUser $serviceUser)
    {
        $old = $serviceUser->only(['first_name','last_name']);
        $serviceUser->fill($request->validated())->save();

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
            ServiceUser::query()->select(['id','first_name','last_name','email','address','city','contact_number','is_active'])
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