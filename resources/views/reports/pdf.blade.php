<!DOCTYPE html>
<html>
<head>
    <title>Employee Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Employee Report</h2>
    <table>
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
</body>
</html>
