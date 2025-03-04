@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Employee Summary Report</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Department</th>
                <th>Total Employees</th>
                <th>Average Salary</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
            <tr>
                <td>{{ $report->department }}</td>
                <td>{{ $report->total_employees }}</td>
                <td>${{ number_format($report->avg_salary, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('export.pdf') }}" class="btn btn-danger">Export as PDF</a>
    <a href="{{ route('export.csv') }}" class="btn btn-success">Export as CSV</a>
</div>
@endsection
