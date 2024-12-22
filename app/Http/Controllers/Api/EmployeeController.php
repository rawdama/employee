<?php

namespace App\Http\Controllers\Api;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeDetailByDateResource;
use App\Http\Resources\EmployeeDetailByIdResource;
class EmployeeController extends Controller
{
    public function allEmployees(){
        $employee=Employee::get();
        return  EmployeeResource::collection($employee);
    }

    public function employeeDetailsById($id)
    {
        $employee = Employee::with(['attendances', 'loans.deductions'])->findOrFail($id);
        return new EmployeeDetailByIdResource($employee);
    }

    public function employeeDetailsByDate(Request $request)
    {
        
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');
        $employeeId = $request->query('employee_id');

        
        if ($fromDate && !$toDate) {
            return response()->json(['error' => 'toDate is required when fromDate is provided'], 400);
        }
        if ($toDate && !$fromDate) {
            return response()->json(['error' => 'fromDate is required when toDate is provided'], 400);
        }

        $query = Employee::with(['attendances' => function($query) use ($fromDate, $toDate) {
            if ($fromDate && $toDate) {
                $query->whereBetween('attendance_date', [$fromDate, $toDate]);
            }
        }, 'loans.deductions' => function($query) use ($fromDate, $toDate) {
            if ($fromDate && $toDate) {
                $query->whereBetween('deduction_date', [$fromDate, $toDate]);
            }
        }]);

       
        if ($employeeId) {
            $query->where('id', $employeeId);
        }

        $employees = $query->get();
        return EmployeeDetailByDateResource::collection($employees);
    }
}

