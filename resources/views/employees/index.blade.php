@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Employee Management</h2>

    <!-- Button to Open the Modal -->
    <button class="btn btn-primary mb-3" id="addEmployeeBtn" data-bs-toggle="modal" data-bs-target="#employeeModal">
        Add Employee
    </button>

    <!-- Employee Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Department</th>
                <th>Salary</th>
                <th>Joining Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="employeeTable">
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->department }}</td>
                <td>{{ $employee->salary }}</td>
                <td>{{ $employee->joining_date }}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $employee->id }}">Edit</button>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm delete-btn" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Employee Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeModalTitle">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="employeeForm">
                    <input type="hidden" id="employee_id" name="employee_id">
                    <input type="hidden" name="_method" id="method_field" value="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Position</label>
                        <input type="text" id="position" name="position" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Department</label>
                        <input type="text" id="department" name="department" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Salary</label>
                        <input type="number" id="salary" name="salary" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Joining Date</label>
                        <input type="date" id="joining_date" name="joining_date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Open Add Employee Modal
    $('#addEmployeeBtn').click(function() {
        $('#employeeForm')[0].reset();
        $('#employee_id').val('');
        $('#method_field').val('POST');
        $('#employeeForm').attr('action', "{{ route('employees.store') }}");
        $('#employeeModalTitle').text('Add Employee');
        $('#employeeModal').modal('show');
    });

    // Edit Employee - Dynamic Binding
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');

        $.get('/employees/' + id + '/edit', function(employee) {
            $('#employee_id').val(employee.id);
            $('#name').val(employee.name);
            $('#email').val(employee.email);
            $('#position').val(employee.position);
            $('#department').val(employee.department);
            $('#salary').val(employee.salary);
            $('#joining_date').val(employee.joining_date);

            // Change form action & method for update
            $('#employeeForm').attr('action', '/employees/' + employee.id);
            $('#method_field').val('PUT'); 

            $('#employeeModalTitle').text('Edit Employee');
            $('#employeeModal').modal('show');
        }).fail(function() {
            alert('Error fetching employee data');
        });
    });

    // Handle Form Submission
    $('#employeeForm').submit(function(e) {
        e.preventDefault();

        let form = $(this);
        let actionUrl = form.attr('action');
        let method = $('#method_field').val();

        let formData = new FormData(this);
        formData.append('_method', method);

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.success);
                location.reload();
            },
            error: function(error) {
                alert('Error occurred');
                console.log(error.responseJSON);
            }
        });
    });

    // Delete Employee Confirmation
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this employee?')) {
            let form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    alert(response.success);
                    location.reload();
                },
                error: function(error) {
                    alert('Error occurred');
                    console.log(error);
                }
            });
        }
    });
});
</script>
@endsection
