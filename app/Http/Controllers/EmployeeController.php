<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\{StoreEmployeeRequest, UpdateEmployeeRequest};
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $old = $employee->only(['first_name', 'last_name', 'email']);
        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }
        $employee->fill($request->validated())->save();

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
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle no-arrow" data-bs-toggle="dropdown">
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
}
