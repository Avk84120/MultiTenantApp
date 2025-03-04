<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    // Generate Summary Report
    public function summary()
    {
        $reports = Employee::selectRaw('department, COUNT(*) as total_employees, AVG(salary) as avg_salary')
            ->groupBy('department')
            ->get();

        return view('reports.summary', compact('reports'));
    }

    // Export Report as PDF
    public function exportPDF()
    {
        $reports = Employee::selectRaw('department, COUNT(*) as total_employees, AVG(salary) as avg_salary')
            ->groupBy('department')
            ->get();

        $pdf = Pdf::loadView('reports.pdf', compact('reports'));
        return $pdf->download('employee_report.pdf');
    }

    // Export Report as CSV
    public function exportCSV()
    {
        $reports = Employee::selectRaw('department, COUNT(*) as total_employees, AVG(salary) as avg_salary')
            ->groupBy('department')
            ->get();

        $fileName = 'employee_report.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($reports) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Department', 'Total Employees', 'Average Salary']);

            foreach ($reports as $report) {
                fputcsv($file, [$report->department, $report->total_employees, number_format($report->avg_salary, 2)]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
