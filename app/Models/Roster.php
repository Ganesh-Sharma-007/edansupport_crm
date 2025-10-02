<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'shift_hours',
        'status',           // assigned | cancelled | complete | in-progress
        'service_user_id',
        'employee_id',
        'travel_hours',
        'travel_minutes',
        'assigned_by',
        'cancelled_by',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end'   => 'datetime',
    ];

    /* relationships */
    public function serviceUser()
    {
        return $this->belongsTo(ServiceUser::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function canceller()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }
}