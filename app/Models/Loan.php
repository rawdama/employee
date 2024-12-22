<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'amount', 'installments'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function deductions()
    {
        return $this->hasMany(LoanDeduction::class);
    }
}
