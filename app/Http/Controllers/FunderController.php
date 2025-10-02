<?php

namespace App\Http\Controllers;

use App\Models\Funder;
use App\Http\Requests\{StoreFunderRequest, UpdateFunderRequest};
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class FunderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->datatable();
        return view('funders.index');
    }

    public function create()
    {
        return view('funders.create');
    }

    public function store(StoreFunderRequest $request)
    {
        $funder = Funder::create($request->validated());

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'create',
            'entity'    => 'funder',
            'entity_id' => $funder->id,
            'message'   => 'Funder created: '.$funder->name,
        ]);

        return redirect()->route('funders.index')->with('success','Funder created.');
    }

    public function edit(Funder $funder)
    {
        return view('funders.edit', compact('funder'));
    }

    public function update(UpdateFunderRequest $request, Funder $funder)
    {
        $old = $funder->only(['name','email']);
        $funder->fill($request->validated())->save();

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'type'       => 'update',
            'entity'     => 'funder',
            'entity_id'  => $funder->id,
            'old_values' => $old,
            'new_values' => $funder->only(['name','email']),
            'message'    => 'Funder updated: '.$funder->name,
        ]);

        return redirect()->route('funders.index')->with('success','Funder updated.');
    }

    public function destroy(Funder $funder)
    {
        $funder->delete();

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'delete',
            'entity'    => 'funder',
            'entity_id' => $funder->id,
            'message'   => 'Funder deleted: '.$funder->name,
        ]);

        return redirect()->route('funders.index')->with('success','Funder deleted.');
    }

    /* Yajra */
    private function datatable()
    {
        return datatables()->eloquent(
            Funder::query()->select(['id','name','email','address','city_town','is_active'])
        )
        ->addColumn('status', fn($f) => $f->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>')
        ->addColumn('action', fn($f) => '
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle no-arrow" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="'.route('funders.edit',$f).'">Edit</a></li>
                    <li>
                        <form action="'.route('funders.destroy',$f).'" method="POST" onsubmit="return confirm(\'Delete?\')">
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