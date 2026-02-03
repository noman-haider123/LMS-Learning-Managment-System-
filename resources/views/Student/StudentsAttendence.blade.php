@extends('layout')
@section('title')
    Students Attendance
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Custom styles for better modal display */
        .modal-content {
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .card {
            overflow: hidden;
        }
    </style>
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if ($errors->any())
                    @if (old('form_type') === 'create')
                        let roleFormModal = new bootstrap.Modal(document.getElementById('studentFormModal'));
                        roleFormModal.show();
                    @elseif (old('form_type') === 'edit')
                        @if (old('edit_type'))
                            let editFormModal = new bootstrap.Modal(document.getElementById(
                                'editFormModal{{ old('edit_type') }}'));
                            editFormModal.show();
                        @endif
                    @endif
                @endif

                // Show validation errors
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                });
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('error') }}',
                });
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                });
            });
        </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card shadow rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">🗓️ Students Attendance</h4>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#studentFormModal">
                                <i class="bi bi-plus-lg"></i> Add Student Attendance
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Teacher Name</th>
                                        <th>Teacher Email Address</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th width="220">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Attendence as $Attendences)
                                        <tr>
                                            <td>{{ $Attendences->student->Name }}</td>
                                            <td>{{ $Attendences->teacher->name }}</td>
                                            <td>{{ $Attendences->teacher_email_address }}</td>
                                            <td>{{ $Attendences->date }}</td>
                                            <td>{{ $Attendences->status }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Edit button -->
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#editFormModal{{ $Attendences->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </button>

                                                    <!-- Delete button with confirmation -->
                                                    <form action="{{ route('destroy', $Attendences->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-btn">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="studentFormModal" tabindex="-1" aria-labelledby="studentFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="studentFormModalLabel">Add Attendence For Students</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="studentForm" action="{{ route('store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="form_type" value="create">
                            <label for="Student" class="form-label #editFormModal">Student Name</label>
                            <select name="Student" id="Student" class="form-select">
                                <option value="" selected disabled>Select Student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Teacher" class="form-label #editFormModal">Teacher Name</label>
                            <select name="Teacher" id="Teacher" class="form-select">
                                <option value="" selected disabled>Select Teacher</option>
                                @foreach ($user as $users)
                                    <option value="{{ $users->id }}">{{ $users->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="TeacherEmail" class="form-label #editFormModal">Teacher Email Address</label>
                            <select name="TeacherEmail" id="TeacherEmail" class="form-select">
                                <option value="" selected disabled>Select Teacher Email</option>
                                @foreach ($user as $users)
                                    <option value="{{ $users->email }}">{{ $users->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Date" class="form-label">Date</label>
                            <input type="date" id="Date" name="Date" class="form-control"
                                placeholder="Enter Date" value="{{ old('Date') }}">
                        </div>
                        <div class="mb-3">
                            <label for="StudentStatus" class="form-label">Student Status</label>
                            <select name="StudentStatus" id="StudentStatus" class="form-select">
                                <option value="" selected disabled>Select Student Status</option>
                                <option value="Present">Present</option>
                                <option value="Absent">Absent</option>
                                <option value="Late">Late</option>
                                <option value="Application Leave">Application Leave</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Student Attendance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Role Modals -->
    @foreach ($Attendence as $Attendences)
        <div class="modal fade" id="editFormModal{{ $Attendences->id }}" tabindex="-1"
            aria-labelledby="editFormModalLabel{{ $Attendences->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editFormModalLabel{{ $Attendences->id }}">Update Attendence</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('Update', $Attendences->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" name="form_type" value="edit">
                                <input type="hidden" name="edit_type" value="{{ $Attendences->id }}">
                                <input type="hidden" name="student_id" value="{{ $Attendences->student_id }}">
                                <input type="hidden" name="teacher_id" value="{{ $Attendences->teacher_id }}">
                                <label for="StudentName{{ $Attendences->id }}" class="form-label fw-semibold">Student
                                    Name</label>
                                <input type="text" class="form-control" id="StudentName{{ $Attendences->id }}"
                                    value="{{ $Attendences->student->Name }}" name="Student" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="TeacherName{{ $Attendences->id }}" class="form-label fw-semibold">Teacher
                                    Name</label>
                                <input type="text" class="form-control" id="TeacherName{{ $Attendences->id }}"
                                    value="{{ $Attendences->teacher->name }}" name="Teacher" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="role{{ $Attendences->id }}" class="form-label fw-semibold">Teacher Email
                                    Address</label>
                                <input type="text" class="form-control"
                                    value="{{ $Attendences->teacher_email_address }}" name="TeacherEmail" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="role{{ $Attendences->id }}" class="form-label fw-semibold">Date</label>
                                <input type="date" class="form-control" value="{{ $Attendences->date }}"
                                    name="Date">
                            </div>
                            <div class="mb-3">
                                <label for="StudentStatus" class="form-label">Student Status</label>
                                <select name="StudentStatus" id="StudentStatus" class="form-select">
                                    <option disabled
                                        {{ old('StudentStatus', $Attendences->status ?? '') == '' ? 'selected' : '' }}>
                                        Select Student Status</option>
                                    <option value="Present"
                                        {{ old('StudentStatus', $Attendences->status ?? '') == 'Present' ? 'selected' : '' }}>
                                        Present</option>
                                    <option value="Absent"
                                        {{ old('StudentStatus', $Attendences->status ?? '') == 'Absent' ? 'selected' : '' }}>
                                        Absent</option>
                                    <option value="Late"
                                        {{ old('StudentStatus', $Attendences->status ?? '') == 'Late' ? 'selected' : '' }}>
                                        Late</option>
                                    <option value="Application Leave"
                                        {{ old('StudentStatus', $Attendences->status ?? '') == 'Application Leave' ? 'selected' : '' }}>
                                        Application Leave</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                Update Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search students..."
                }
            });
        });
    </script>
@endsection
