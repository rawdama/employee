<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDetailByIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $loanSummary = $this->loans->map(function($loan) {
            $totalRepayments = $loan->deductions->sum('amount');
            $remainingBalance = $loan->amount - $totalRepayments;
            $remainingBalance = abs($remainingBalance) < 0.01 ? 0.00 : $remainingBalance;

            return [
                'loan_amount' => round($loan->amount, 2),
                'repaid' => round($totalRepayments, 2),
                'remaining' => round($remainingBalance, 2),
                'status' => $remainingBalance <= 0 ? 'Paid' : 'Pending',
            ];
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'hire_date' => $this->hire_date,
            'salary' => $this->salary,
            'attendances' => $this->attendances, 
            'loan_summary' => $loanSummary,
            'total_deductions' => $loanSummary->sum('repaid'),
            'net_salary' => round($this->salary - $loanSummary->sum('repaid'), 2)
        ];
    }

    }

