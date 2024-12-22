<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id', 'attendance_date', 'check_in', 'check_out', 'work_time_diff'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
