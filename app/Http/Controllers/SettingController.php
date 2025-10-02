<?php

namespace App\Http\Controllers;

use App\Models\{User, Holiday};
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class SettingController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['super-admin','admin'])->get();
        return view('settings.index', compact('users'));
    }

    public function updatePermissions(Request $request, User $user)
    {
        $perms = $request->validate([
            'routes' => 'array',
            'routes.*' => 'in:dashboard,users,employees,service-users,funders,rostering,timesheets,invoices,settings',
        ]);

        // store as JSON in users.permissions (add column if needed)
        $user->update(['permissions' => $perms['routes'] ?? []]);

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'update',
            'entity'    => 'user',
            'entity_id' => $user->id,
            'message'   => 'Updated permissions for '.$user->name,
        ]);

        return back()->with('success','Permissions updated.');
    }

    /* Holidays */
    public function storeHoliday(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'date' => 'required|date',
        ]);

        Holiday::create($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'type'    => 'create',
            'entity'  => 'holiday',
            'message' => 'Holiday added: '.$data['name'],
        ]);

        return back()->with('success','Holiday added.');
    }

    public function updateHoliday(Request $request, Holiday $holiday)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'date' => 'required|date',
        ]);

        $holiday->update($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'type'    => 'update',
            'entity'  => 'holiday',
            'message' => 'Holiday updated: '.$data['name'],
        ]);

        return back()->with('success','Holiday updated.');
    }

    public function destroyHoliday(Holiday $holiday)
    {
        $holiday->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'type'    => 'delete',
            'entity'  => 'holiday',
            'message' => 'Holiday deleted',
        ]);

        return back()->with('success','Holiday deleted.');
    }
}