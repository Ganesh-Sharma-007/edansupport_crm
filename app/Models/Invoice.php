<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'service_user_id',
        'funder_id',
        'issue_date',
        'due_date',
        'status',        // draft | published
        'total_amount',
        'generated_by',
    ];

    protected $casts = [
        'issue_date'   => 'date',
        'due_date'     => 'date',
        'total_amount' => 'decimal:2',
    ];

    /* relationships */
    public function serviceUser()
    {
        return $this->belongsTo(ServiceUser::class);
    }

    public function funder()
    {
        return $this->belongsTo(Funder::class);
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}