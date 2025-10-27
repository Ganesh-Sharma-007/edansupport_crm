<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\{StoreEmployeeRequest, UpdateEmployeeRequest};
use App\Models\ActivityLog;
use App\Models\Holiday;
use App\Models\Roster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return $this->datatable();
        return view('employees.index');
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(StoreEmployeeRequest $request)
    {
        $emp = Employee::create([
            ...$request->validated(),
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'create',
            'entity'    => 'employee',
            'entity_id' => $emp->id,
            'message'   => 'Employee created: ' . $emp->first_name . ' ' . $emp->last_name,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created.');
    }

// public function edit(Employee $employee)
// {
//     $employee->load('rosters');
//     $timesheet_hours = $employee->rosters;

//     return view('employees.edit', compact('employee', 'timesheet_hours'));
// }


public function edit(Employee $employee)
{
    // Just load the relationships (clean and light)
    $employee->load('rosters');

    return view('employees.edit', compact('employee'));
}


    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {

        $data = $request->validated();
        // ✅ If password field is filled, hash it
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            // 🚫 Remove it so fill() doesn’t null it
            unset($data['password']);
        }


        $old = $employee->only(['first_name', 'last_name', 'email']);

        $employee->fill($data)->save();

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'type'       => 'update',
            'entity'     => 'employee',
            'entity_id'  => $employee->id,
            'old_values' => $old,
            'new_values' => $employee->only(['first_name', 'last_name', 'email']),
            'message'    => 'Employee updated: ' . $employee->first_name . ' ' . $employee->last_name,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'delete',
            'entity'    => 'employee',
            'entity_id' => $employee->id,
            'message'   => 'Employee deleted: ' . $employee->first_name . ' ' . $employee->last_name,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee deleted.');
    }

    /* Yajra */
    private function datatable()
    {
        return datatables()->eloquent(
            Employee::query()->select(['id', 'first_name', 'last_name', 'city', 'marital_status', 'gender', 'is_active'])
        )
            ->addColumn('name', fn($e) => $e->first_name . ' ' . $e->last_name)
            ->addColumn('action', fn($e) => '
            <div class="dropdown">
                <button class="btn btn-sm dropdown-toggle no-arrow" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="' . route('employees.edit', $e) . '">Edit</a></li>
                    <li>
                        <form action="' . route('employees.destroy', $e) . '" method="POST" onsubmit="return confirm(\'Delete?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="dropdown-item text-danger">Delete</button>
                        </form>
                    </li>
                </ul>
            </div>
        ')
            ->rawColumns(['action'])
            ->toJson();
    }


    
public function timesheet(Employee $employee)
{
    $employee->load('rosters');

    // Group rosters by week (Monday–Sunday)
    $timesheetData = $employee->rosters
        ->groupBy(function ($roster) {
            return Carbon::parse($roster->start)->startOfWeek()->format('Y-m-d');
        })
        ->map(function (Collection $weekGroup, $weekStart) {
            $days = [
                'Mon' => 0, 'Tue' => 0, 'Wed' => 0,
                'Thu' => 0, 'Fri' => 0, 'Sat' => 0, 'Sun' => 0,
            ];

            foreach ($weekGroup as $roster) {
                $dayName = Carbon::parse($roster->start)->format('D');
                $days[$dayName] += $roster->shift_hours;
            }

            return [
                'week_start' => Carbon::parse($weekStart)->format('d M Y'),
                'total' => array_sum($days),
                'Mon' => $days['Mon'],
                'Tue' => $days['Tue'],
                'Wed' => $days['Wed'],
                'Thu' => $days['Thu'],
                'Fri' => $days['Fri'],
                'Sat' => $days['Sat'],
                'Sun' => $days['Sun'],
            ];
        })
        ->values();

    return datatables()->of($timesheetData)->make(true);
}







}
