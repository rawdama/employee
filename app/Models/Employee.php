<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'phone', 'hire_date','salary'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
