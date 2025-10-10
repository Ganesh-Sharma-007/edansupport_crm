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
        // JSON feed for FullCalendar
        if ($request->wantsJson() || $request->has('ajax')) {
            return $this->calendarEvents($request);
        }

        return view('rostering.index');
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
            'message'   => 'Roster shift created: ' . $roster->employee?->first_name . ' → ' . $roster->serviceUser?->first_name,
        ]);

        return redirect()->route('rostering.index')->with('success', 'Shift created.');
    }

    public function edit(Roster $roster)
    {
        $form = view('rostering._form', compact('roster'))->render();

        return response()->json([
            'form' => $form,
            'update_url' => route('rostering.update', $roster),
        ]);
    }


    public function update(UpdateRosterRequest $request, Roster $roster)
    {
        $old = $roster->only(['start', 'end', 'status']);
        $roster->fill($request->validated())->save();

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'type'       => 'update',
            'entity'     => 'roster',
            'entity_id'  => $roster->id,
            'old_values' => $old,
            'new_values' => $roster->only(['start', 'end', 'status']),
            'message'    => 'Roster shift updated',
        ]);

        return redirect()->route('rostering.index')->with('success', 'Shift updated.');
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

        return redirect()->route('rostering.index')->with('success', 'Shift cancelled.');
    }

    /* FullCalendar JSON feed */
    private function calendarEvents(Request $request)
    {
        $start = $request->input('start');
        $end   = $request->input('end');

        $rosters = Roster::with(['employee', 'serviceUser'])
            ->where('start', '>=', $start)
            ->where('end', '<=', $end)
            ->get(['id', 'start', 'end', 'status', 'employee_id', 'service_user_id']);

        return response()->json(
            // $rosters->map(fn($r) => [
            //     'id'    => $r->id,
            //     'title' => ($r->employee?->first_name ?? 'Unknown').' → '.($r->serviceUser?->first_name ?? 'Unknown'),
            //     'start' => $r->start->toIsoString(),
            //     'end'   => $r->end->toIsoString(),
            //     'color' => match($r->status) {
            //         'cancelled' => '#dc3545',
            //         'complete'  => '#0d6efd',
            //         'in-progress'=> '#ffc107',
            //         default     => '#28a745',
            //     },
            // ])

            $rosters->map(fn($r) => [
                'id' => $r->id,
                'title' => $r->employee?->first_name . ' → ' . $r->serviceUser?->first_name,
                'start' => $r->start->toDateTimeString(),
                'end' => $r->end->toDateTimeString(),
                'allDay' => false, // ✅ important
                'extendedProps'   => [
                    'status' => $r->status, // ✅ now available for JS
                ],
                'color' => match ($r->status) {
                    'cancelled' => '#dc3545',
                    'complete' => '#0d6efd',
                    'in-progress' => '#ffc107',
                    default => '#28a745',
                },
            ])


        );
    }
}
