<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class LogoutController extends Controller
{
    public function destroy(Request $request)
    {
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'type'      => 'logout',
            'entity'    => 'user',
            'entity_id' => auth()->id(),
            'message'   => 'User logged out',
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}