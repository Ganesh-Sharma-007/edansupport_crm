<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Notification;

class NotificationController extends Controller
{
public function index()
{
    // $logs = Notification::where('user_id', auth()->id())
    //                     ->latest()
    //                     ->paginate(20);

                        $logs = ActivityLog::where('user_id', auth()->id())
                            ->latest()
                            ->paginate(20);

    return view('notifications.index', compact('logs'));
}
}