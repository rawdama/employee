<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class LoanDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id', 'deduction_date', 'amount'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
