<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarHelper;
use Carbon\Carbon;
use App\Models\{Roster, Employee, Holiday, ServiceUser};
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


        $startDate = Carbon::parse($request->start)->toDateString();

        // ✅ Check if the start date is a holiday
        $holiday = Holiday::whereDate('date', $startDate)->first();

        if ($holiday) {
            return redirect()->back()->withErrors([
                'start' => "Cannot assign roster on holiday: {$holiday->name} ({$holiday->date->format('d-m-Y')})"
            ])->withInput();
        }


        $roster = Roster::create([
            ...$request->validated(),
            'assigned_by' => auth()->id(),
            'cancelled_by' => auth()->id(),
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
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'delete',
            'entity'    => 'roster',
            'entity_id' => $roster->id,
            'message'   => 'Roster permanently deleted',
        ]);

        $roster->delete();
        return response()->json(['message' => 'Roster deleted successfully.']);
    }
    
    private function calendarEvents(Request $request)
    {
        $events = CalendarHelper::getEvents($request);
        return response()->json($events);
    }

}
