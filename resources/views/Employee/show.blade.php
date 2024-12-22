<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Employee Details</h1>

       
        <h2>Basic Info</h2>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $employee->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $employee->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $employee->phone }}</td>
            </tr>
            <tr>
                <th>Hire Date</th>
                <td>{{ $employee->hire_date }}</td>
            </tr>
            <tr>
                <th>Salary</th>
                <td>${{ number_format($employee->salary, 2) }}</td>
            </tr>
        </table>

        
        
        <h2>Attendance and Leave Details</h2>
        <table class="table table-bordered">
            <tr>
                <th>Check-in</th>
                <td>{{ $latestAttendance && $latestAttendance->check_in ? $latestAttendance->check_in : 'Absent' }}</td>
            </tr>
            <tr>
                <th>Check-out</th>
                <td>{{ $latestAttendance && $latestAttendance->check_out ? $latestAttendance->check_out : 'Absent' }}</td>
            </tr>
            <tr>
                <th>Total Attendances</th>
                <td>{{ $totalAttendanceDays }}</td>
            </tr>
            <tr>
                <th>Number of Absences</th>
                <td>{{ $absences }}</td>
            </tr>
            <tr>
                <th>Total Work Hours</th>
                <td>{{ number_format($totalWorkHours, 2) }} hours</td>
            </tr>
        </table>

       
        <h2>Loan Summary</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Loan Amount</th>
                    <th>Total Repaid</th>
                    <th>Remaining Balance</th>
                    <th>Status</th>
                      
                </tr>
            </thead>
            <tbody>
                @foreach ($loanSummary as $loan)
                    <tr>
                        <td>${{ number_format($loan['loan_amount'], 2) }}</td>
                        <td>${{ number_format($loan['repaid'], 2) }}</td>
                        <td>${{ number_format($loan['remaining'], 2, '.', '') }}</td>
                        <td>{{ $loan['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

   
      
<h2>Salary Calculation</h2>
<table class="table table-bordered">
    <tr>
        <th>Base Salary</th>
        <td>${{ number_format($employee->salary, 2) }}</td>
    </tr>
    <tr>
        <th>Total Deductions</th>
        <td>${{ number_format($totalDeductions, 2) }}</td> 
    </tr>
    <tr>
        <th>Net Salary</th>
        <td>${{ number_format($netSalary, 2) }}</td>
    </tr>
</table>

    </div>
</body>
</html>
