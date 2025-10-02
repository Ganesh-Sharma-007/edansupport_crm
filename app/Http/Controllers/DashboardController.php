<?php

namespace App\Http\Controllers;

use App\Models\{User, Employee, ServiceUser, Funder, Invoice, Roster};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'users'        => User::count(),
            'employees'    => Employee::where('is_active', true)->count(),
            'serviceUsers' => ServiceUser::where('is_active', true)->count(),
            'funders'      => Funder::where('is_active', true)->count(),
        ];

        $invoices = Invoice::with(['serviceUser', 'funder'])
                           ->latest()
                           ->take(10)
                           ->get();

        // rosters for full-calendar (next 30 days)
        $rosters = Roster::with(['employee', 'serviceUser'])
                         ->where('start', '>=', Carbon::today())
                         ->where('start', '<=', Carbon::today()->addDays(30))
                         ->get(['id', 'start', 'end', 'status', 'employee_id', 'service_user_id']);

        return view('dashboard.index', compact('counts', 'invoices', 'rosters'));
    }
}