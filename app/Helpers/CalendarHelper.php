<?php

namespace App\Helpers;

use App\Models\{Roster, Holiday, Employee};
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CalendarHelper
{
    /**
     * Generate unified roster + holiday events
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee|null  $employee
     * @return \Illuminate\Support\Collection
     */
    public static function getEvents(Request $request, Employee $employee = null): Collection
    {
        $start = $request->query('start') ?? $request->start;
        $end   = $request->query('end') ?? $request->end;
dd($start, $end);
        // ✅ Fetch rosters (optionally scoped to an employee)
        $rosters = Roster::with(['employee', 'serviceUser'])
            ->when($employee, fn($q) => $q->where('employee_id', $employee->id))
            ->whereBetween('start', [$start, $end])
            ->get();

        // ✅ Fetch holidays
        $holidays = Holiday::whereBetween('date', [$start, $end])->get();

        // ✅ Format roster events
        $rosterEvents = $rosters->map(fn($r) => [
            'id'    => $r->id,
            'title' => ($r->employee?->first_name ? "{$r->employee->first_name} → " : '')
                        . ($r->serviceUser?->first_name ?? 'Shift'),
            'start' => $r->start->toDateTimeString(),
            'end'   => $r->end->toDateTimeString(),
            'allDay' => false,
            'display' => 'block',
            'backgroundColor' => match ($r->status) {
                'cancelled'   => '#dc3545',
                'complete'    => '#28a745',
                'in-progress' => '#ffc107',
                default       => '#0d6efd',
            },
            'borderColor' => 'transparent',
            'textColor' => '#fff',
            'extendedProps' => [
                'type'    => 'roster',
                'status'  => $r->status,
                'tooltip' => "Employee: {$r->employee?->first_name}\nUser: {$r->serviceUser?->first_name}",
                'badge'   => match ($r->status) {
                    'cancelled'   => 'danger',
                    'complete'    => 'success',
                    'in-progress' => 'warning',
                    default       => 'primary',
                },
            ],
        ]);

        // ✅ Format holiday events
        $holidayEvents = $holidays->map(fn($h) => [
            'id'    => 'holiday-' . $h->id,
            'title' => $h->name,
            'start' => $h->date->toDateString(),
            'display' => 'background',
            'allDay' => true,
            'classNames' => ['bg-holiday'],
            'borderColor' => 'transparent',
            'extendedProps' => [
                'type'    => 'holiday',
                'tooltip' => "Public Holiday: {$h->name}",
            ],
        ]);

        return $rosterEvents->merge($holidayEvents);
    }
}
