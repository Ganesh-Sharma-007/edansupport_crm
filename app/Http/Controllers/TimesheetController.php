<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;

class TimesheetController extends Controller
{
    public function index()
    {
        $week = request('week', Carbon::now()->startOfWeek()->format('Y-m-d'));
        $start = Carbon::parse($week);
        $days = [];
        for ($i = 0; $i < 7; $i++) $days[] = $start->copy()->addDays($i)->format('D, d M');

        $employees = Employee::where('is_active', true)
                             ->select(['id','first_name','last_name'])
                             ->with(['rosters' => fn($q) => $q->whereBetween('start', [$start, $start->copy()->addDays(6)->endOfDay()])])
                             ->get();

        return view('timesheets.index', compact('employees', 'days', 'start'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
