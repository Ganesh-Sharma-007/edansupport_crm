<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\{Roster, Appointment}; // Appointment model can be added later

/* Public calendar feeds (auth:sanctum optional) */
Route::middleware('auth:sanctum')->group(function () {

    /* Employee rosters for Full-Calendar */
    Route::get('employees/{employee}/rosters', function (Request $request, $empId) {
        return Roster::where('employee_id', $empId)
                     ->whereBetween('start', [$request->start, $request->end])
                     ->get(['id','start','end','status'])
                     ->map(fn($r) => [
                         'id'    => $r->id,
                         'title' => $r->serviceUser->first_name.' '.$r->serviceUser->last_name,
                         'start' => $r->start,
                         'end'   => $r->end,
                         'color' => $r->status === 'cancelled' ? '#dc3545' : '#28a745',
                     ]);
    });

    /* Service-user appointments for Full-Calendar */
    Route::get('service-users/{serviceUser}/appointments', function (Request $request, $suId) {
        // stub – return empty until Appointment model exists
        return [];
    });

});