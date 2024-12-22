<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Attendance;
use App\Models\Loan;
use App\Models\LoanDeduction;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=Employee::select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $btn = '<a href="'.route('employee.show', $row->id).'"  class="edit btn btn-primary btn-sm">View</a>';
                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
        
        }
        return view('Employee.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       
        $employee = Employee::with(['attendances' => function($query) {
            $query->orderBy('attendance_date', 'desc');
        }, 'loans.deductions'])->findOrFail($id);

        $attendances = $employee->attendances;
        $totalAttendanceDays = $attendances->count();
        $totalWorkHours = $attendances->sum('work_time_diff');

        $latestAttendance = $attendances->first();

        $absences = $attendances->where('is_absent', true)->count();

        $loans = $employee->loans;

        $loanSummary = $loans->map(function($loan) {
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

        $totalDeductions = $loanSummary->sum('repaid');

        $netSalary = round($employee->salary - $totalDeductions, 2);

        return view('employee.show', get_defined_vars());
    }
    
    
    


    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
