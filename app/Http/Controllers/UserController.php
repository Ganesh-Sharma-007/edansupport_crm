<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\{StoreUserRequest, UpdateUserRequest};
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable();
        }
        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

public function store(StoreUserRequest $request)
{
    $user = User::create([
        ...$request->validated(),
        'name'     => trim($request->first_name.' '.$request->last_name),
        'password' => Hash::make($request->password),
        'role'     => $request->support_worker_type === 'branch administrator' ? 'admin' : 'employee',
    ]);

    ActivityLog::create([
        'user_id'   => auth()->id(),
        'type'      => 'create',
        'entity'    => 'user',
        'entity_id' => $user->id,
        'message'   => 'User created: '.$user->name,
    ]);

    return redirect()->route('users.index')->with('success','User created.');
}


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

public function update(UpdateUserRequest $request, User $user)
{
    $old = $user->only(['name','email','phone']);
    $user->fill($request->validated());

    $user->name = trim($request->first_name.' '.$request->last_name);

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    $user->save();

    ActivityLog::create([
        'user_id'    => auth()->id(),
        'type'       => 'update',
        'entity'     => 'user',
        'entity_id'  => $user->id,
        'old_values' => $old,
        'new_values' => $user->only(['name','email','phone']),
        'message'    => 'User updated: '.$user->name,
    ]);

    return redirect()->route('users.index')->with('success','User updated.');
}


    public function destroy(User $user)
    {
        $user->delete();

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'delete',
            'entity'    => 'user',
            'entity_id' => $user->id,
            'message'   => 'User deleted: '.$user->name,
        ]);

        return redirect()->route('users.index')->with('success','User deleted.');
    }

    /* Yajra server-side */
// private function datatable()
// {
//     return datatables()->eloquent(
//         User::query()->select(['id','first_name','last_name','email','role','phone','created_at'])
//     )
//     ->addColumn('full_name', fn($u) => $u->first_name.' '.$u->last_name)
//     ->addColumn('action', fn($u) => '
//         <a href="'.route('users.edit',$u).'" class="btn btn-sm btn-outline-primary">Edit</a>
//         <form action="'.route('users.destroy',$u).'" method="POST" class="d-inline" onsubmit="return confirm(\'Delete?\')">
//             '.csrf_field().method_field('DELETE').'
//             <button class="btn btn-sm btn-outline-danger">Delete</button>
//         </form>
//     ')
//     ->rawColumns(['action'])
//     ->toJson();
// }


// private function datatable()
// {
//     $query = User::query()->select(['id','name','email','role','phone','created_at']);
    
//     // dd($query->get()); // 🛑 Debug: See what is actually coming from DB

//     return datatables()->eloquent($query)
//         ->addColumn('action', fn($u) => '
//             <a href="'.route('users.edit',$u).'" class="btn btn-sm btn-outline-primary">Edit</a>
//             <form action="'.route('users.destroy',$u).'" method="POST" class="d-inline" onsubmit="return confirm(\'Delete?\')">
//                 '.csrf_field().method_field('DELETE').'
//                 <button class="btn btn-sm btn-outline-danger">Delete</button>
//             </form>
//         ')
//         ->rawColumns(['action'])
//         ->toJson();
// }


private function datatable()
{
    $query = User::query()->select(['id','first_name','last_name','email','role','phone','created_at']);

    return datatables()->eloquent($query)
        ->addColumn('full_name', function ($u) {
            return $u->first_name . ' ' . $u->last_name;
        })
        ->addColumn('action', function ($u) {
            return '
                <a href="'.route('users.edit',$u).'" class="btn btn-sm btn-outline-primary">Edit</a>
                <form action="'.route('users.destroy',$u).'" method="POST" class="d-inline" onsubmit="return confirm(\'Delete?\')">
                    '.csrf_field().method_field('DELETE').'
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            ';
        })
        ->rawColumns(['action'])
        ->toJson();
}




}