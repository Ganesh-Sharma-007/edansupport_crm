<?php

namespace App\Http\Controllers;

use App\Models\{Roster, Employee, ServiceUser};
use App\Http\Requests\{StoreRosterRequest, UpdateRosterRequest};
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class RosteringController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->calendarEvents();
        return view('rostering.index');
    }

    public function calendar()
    {
        return view('rostering.calendar');
    }

    public function store(StoreRosterRequest $request)
    {
        $roster = Roster::create([
            ...$request->validated(),
            'assigned_by' => auth()->id(),
        ]);

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'create',
            'entity'    => 'roster',
            'entity_id' => $roster->id,
            'message'   => 'Roster shift created: '.$roster->employee->first_name.' → '.$roster->serviceUser->first_name,
        ]);

        return redirect()->route('rostering.index')->with('success','Shift created.');
    }

    public function update(UpdateRosterRequest $request, Roster $roster)
    {
        $old = $roster->only(['start','end','status']);
        $roster->fill($request->validated())->save();

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'type'       => 'update',
            'entity'     => 'roster',
            'entity_id'  => $roster->id,
            'old_values' => $old,
            'new_values' => $roster->only(['start','end','status']),
            'message'    => 'Roster shift updated',
        ]);

        return redirect()->route('rostering.index')->with('success','Shift updated.');
    }

    public function destroy(Roster $roster)
    {
        $roster->update([
            'status'       => 'cancelled',
            'cancelled_by' => auth()->id(),
        ]);

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'delete',
            'entity'    => 'roster',
            'entity_id' => $roster->id,
            'message'   => 'Roster shift cancelled',
        ]);

        return redirect()->route('rostering.index')->with('success','Shift cancelled.');
    }

    /* Full-calendar JSON feed */
    private function calendarEvents()
    {
        $rosters = Roster::with(['employee','serviceUser'])
                         ->whereBetween('start', [request('start'), request('end')])
                         ->get(['id','start','end','status','employee_id','service_user_id']);

        return response()->json(
            $rosters->map(fn($r) => [
                'id'    => $r->id,
                'title' => $r->employee->first_name.' → '.$r->serviceUser->first_name,
                'start' => $r->start,
                'end'   => $r->end,
                'color' => $r->status === 'cancelled' ? '#dc3545' : '#28a745',
            ])
        );
    }
}