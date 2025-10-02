<?php

use App\Models\ActivityLog;

if (!function_exists('logActivity')) {
    /**
     * Quick helper to log any activity.
     */
    function logActivity(string $type, string $entity, int $entityId, string $message = null, array $old = null, array $new = null): void
    {
        ActivityLog::create([
            'user_id'    => auth()->id(),
            'type'       => $type,
            'entity'     => $entity,
            'entity_id'  => $entityId,
            'message'    => $message,
            'old_values' => $old,
            'new_values' => $new,
        ]);
    }
}

if (!function_exists('canSeeUsers')) {
    /**
     * Blade directive helper for sidebar.
     */
    function canSeeUsers(): bool
    {
        return in_array(auth()->user()->role, ['super-admin','admin']);
    }
}