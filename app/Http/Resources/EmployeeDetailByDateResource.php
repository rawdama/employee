<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDetailByDateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $filteredAttendances = $this->attendances->map(function ($attendance) {
            return [
                'attendance_date' => $attendance->attendance_date,
                'check_in' => $attendance->check_in,
                'check_out' => $attendance->check_out,
                'work_time_diff' => $attendance->work_time_diff,
                'is_absent' => $attendance->is_absent,
            ];
        });

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
            'attendances' => $filteredAttendances,
            'loan_summary' => $loanSummary,
            'total_deductions' => $loanSummary->sum('repaid'),
            'net_salary' => round($this->salary - $loanSummary->sum('repaid'), 2)
        ];
    }

    }

