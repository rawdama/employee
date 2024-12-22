<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Loan;
use App\Models\LoanDeduction;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $employee = Employee::create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'phone' => $faker->phoneNumber,
            'hire_date' => $faker->dateTimeBetween('-5 years', '-1 years')->format('Y-m-d'),
            'salary' => $faker->numberBetween(2000, 5000),
        ]);

        for ($i = 0; $i < 100; $i++) {

            $checkIn = $faker->optional()->dateTimeBetween('8:00', '9:00');
            $checkOut = $faker->optional()->dateTimeBetween($checkIn, '18:00');
            $isAbsent = false;
            if (!$checkIn || !$checkOut) {
                $isAbsent = true;
            }
            $workTimeDiff = ($checkIn && $checkOut) ? ($checkOut->getTimestamp() - $checkIn->getTimestamp()) / 3600 : 0;

            Attendance::create([
                'employee_id' => $employee->id,
                'attendance_date' => $faker->dateTimeBetween('-4 months', 'now')->format('Y-m-d'),
                'check_in' => $checkIn ? $checkIn->format('H:i:s') : null, 
                'check_out' => $checkOut ? $checkOut->format('H:i:s') : null, 
                'work_time_diff' => $workTimeDiff,
                'is_absent' => $isAbsent, 
            ]);
        }

     
        for ($i = 0; $i < 5; $i++) {
            $loanAmount = $faker->numberBetween(1000, 5000);
            $installments = $faker->numberBetween(3, 12);

            $loan = Loan::create([
                'employee_id' => $employee->id,
                'amount' => $loanAmount,
                'installments' => $installments,
            ]);

            $monthlyDeduction = round($loanAmount / $installments, 2);  
            for ($j = 0; $j < $installments; $j++) {
                LoanDeduction::create([
                    'loan_id' => $loan->id,
                    'deduction_date' => now()->addMonths($j),
                    'amount' => $monthlyDeduction,
                ]);
            }
        }
    }
}
