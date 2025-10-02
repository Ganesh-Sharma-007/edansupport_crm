<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ActivityLog;

class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        $old = $user->only(['name','email','phone']);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars','public');
            $user->avatar = $path;
        }

        $user->fill($request->validated())->save();

        ActivityLog::create([
            'user_id'    => $user->id,
            'type'       => 'update',
            'entity'     => 'user',
            'entity_id'  => $user->id,
            'old_values' => $old,
            'new_values' => $user->only(['name','email','phone']),
            'message'    => 'Profile updated',
        ]);

        return back()->with('success','Profile updated successfully.');
    }
}