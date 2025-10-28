<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'type',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessor to get file URL
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
