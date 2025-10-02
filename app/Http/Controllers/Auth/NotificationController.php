<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $logs = Notification::where('user_id', auth()->id())
                            ->latest()
                            ->paginate(20);

        // mark displayed rows as read
        Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->update(['is_read' => true]);

        return view('notifications.index', compact('logs'));
    }
}