<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
USE  App\Http\Controllers\Api\EmployeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'allEmployees']);
    Route::get('/{id}/details', [EmployeeController::class, 'employeeDetailsById']);
    Route::get('/details/filter', [EmployeeController::class, 'employeeDetailsByDate']);
});


