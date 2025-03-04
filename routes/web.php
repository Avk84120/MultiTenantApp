<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/employees', function () {
//     return view('employees.index');
// });

// Route::post('/employees', function () {
//     return view('employess.store');
// });

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

Route::get('/reports', [ReportController::class, 'summary'])->name('report.summary');
Route::get('/reports/export/pdf', [ReportController::class, 'exportPDF'])->name('export.pdf');
Route::get('/reports/export/csv', [ReportController::class, 'exportCSV'])->name('export.csv');

Route::get('/export-employees', function () {
    return Excel::download(new EmployeesExport, 'employees.xlsx');
});

