<?php

namespace App\Helpers;

use App\Models\{Employee, Roster, Holiday, ServiceUser};
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;


class CalendarHelper
{

// public static function getEvents(Request $request, ServiceUser $serviceUser = null): Collection
public static function getEvents(Request $request,  array $context = []): Collection
{
    $start = $request->query('start');
    $end   = $request->query('end');

    // 🔹 Always fetch holidays for current year
    $yearStart = Carbon::now()->startOfYear()->toDateString();
    $yearEnd   = Carbon::now()->endOfYear()->toDateString();




    $employee    = $context['employee'] ?? null;
    $serviceUser = $context['service_user'] ?? null;

    // 🔹 Base roster query
    $query = Roster::with(['employee', 'serviceUser'])
        ->whereBetween('start', [$start, $end]);

    if ($employee) {
        $query->where('employee_id', $employee->id);
    } elseif ($serviceUser) {
        $query->where('service_user_id', $serviceUser->id);
    }

    $rosters = $query->get();

    // 🔹 Holidays (FULL YEAR)
    $holidays = Holiday::whereBetween('date', [$yearStart, $yearEnd])->get();


        $rosterEvents = $rosters->map(fn ($r) => [
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
                'tooltip' =>
                    "Employee: {$r->employee?->first_name}\n" .
                    "User: {$r->serviceUser?->first_name}",
                    'badge'   => match ($r->status) {
                    'cancelled'   => 'danger',
                    'complete'    => 'success',
                    'in-progress' => 'warning',
                    default       => 'primary',
                },
            ],
        ]);

        $holidayEvents = $holidays->map(fn ($h) => [
            'id'    => 'holiday-' . $h->id,
            'title' => $h->name,
            'start' => $h->date->toDateString(),
            'end'   => $h->date->copy()->addDay()->toDateString(), // ✅ required
            'allDay' => true,
            'display' => 'background',
            'classNames' => ['bg-holiday'],
            'extendedProps' => [
                'type'    => 'holiday',
                'tooltip' => "Public Holiday: {$h->name}",
            ],
        ]);

        return $rosterEvents->merge($holidayEvents);
    }
}
