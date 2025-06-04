@extends('layout')
@section('title')
    Students Record
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
                        let roleFormModal = new bootstrap.Modal(document.getElementById('roleFormModal'));
                        roleFormModal.show();
                    @elseif (old('form_type') === 'edit')
                        @if (old('edit_id'))
                            let editFormModal = new bootstrap.Modal(document.getElementById(
                                'editFormModal{{ old('edit_id') }}'));
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
    @if (session('complete'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('complete') }}',
                });
            });
        </script>
    @endif
    @if (session('delete'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('delete') }}',
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
                            <h4 class="mb-0">📚 Student Applications</h4>
                            @if (!$users->isEmpty())
                                <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#roleFormModal">
                                    <i class="bi bi-plus-lg"></i> Add New Student
                                </button>
                            @else
                                <div class="alert alert-primary mt-2 mx-auto w-75">
                                    No Students Available.If the Students Available then Access you to Add Student
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Class</th>
                                        <th>Mobile</th>
                                        <th>Teacher Name</th>
                                        <th width="220">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $student->Name }}</td>
                                            <td>{{ $student->Address }}</td>
                                            <td>{{ $student->Class }}</td>
                                            <td>{{ $student->Father_Mobile_Number }}</td>
                                            <td>{{ $student->users->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Edit button -->
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#editFormModal{{ $student->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </button>

                                                    <!-- Delete button with confirmation -->
                                                    <form action="{{ route('students.destroy', $student->id) }}"
                                                        method="POST" class="d-inline">
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

    <!-- Student Form Modal (Add New) -->
    <div class="modal fade" id="roleFormModal" tabindex="-1" aria-labelledby="studentFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="studentFormModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="studentForm" action="{{ route('students.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="form_type" value="create">
                            <label for="studentName" class="form-label">Student Name</label>
                            <select name="StudentName" class="form-select">
                                <option selected disabled>Choose Student</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="studentAddress" class="form-label">Student Address</label>
                            <input type="text" id="studentAddress" name="StudentAddress" class="form-control"
                                placeholder="Enter address" value="{{ old('StudentAddress') }}">
                        </div>
                        <div class="mb-3">
                            <label for="StudentClass" class="form-label">Student Class</label>
                            <input type="text" id="StudentClass" name="StudentClass" class="form-control"
                                placeholder="Enter Class Name" value="{{ old('StudentClass') }}">
                        </div>
                        <div class="mb-3">
                            <label for="fatherMobile" class="form-label">Father Mobile Number</label>
                            <input type="tel" id="fatherMobile" name="FatherMobileNumber" class="form-control"
                                placeholder="Enter mobile number" value="{{ old('FatherMobileNumber') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modals for each student -->
    @foreach ($students as $student)
        <div class="modal fade" id="editFormModal{{ $student->id }}" tabindex="-1"
            aria-labelledby="editFormModalLabel{{ $student->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editFormModalLabel{{ $student->id }}">Update Student</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('update', $student->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" name="form_type" value="edit">
                                <input type="hidden" name="edit_id" value="{{ $student->id }}">
                                <label for="editStudentName{{ $student->id }}" class="form-label">Student Name</label>
                                <input type="text" id="editStudentName{{ $student->id }}" name="Student"
                                    class="form-control" value="{{ old('Student', $student->Name) }}">
                            </div>
                            <div class="mb-3">
                                <label for="editStudentAddress{{ $student->id }}" class="form-label">Student
                                    Address</label>
                                <input type="text" id="editStudentAddress{{ $student->id }}" name="Address"
                                    class="form-control" value="{{ old('Address', $student->Address) }}">
                            </div>
                            <div class="mb-3">
                                <label for="editStudentClass{{ $student->id }}" class="form-label">Student
                                    Class</label>
                                <input type="text" id="editStudentClass{{ $student->id }}" name="Class"
                                    class="form-control" value="{{ old('Class', $student->Class) }}">
                            </div>
                            <div class="mb-3">
                                <label for="editFatherMobile{{ $student->id }}" class="form-label">Father Mobile
                                    Number</label>
                                <input type="tel" id="editFatherMobile{{ $student->id }}" name="FatherMobile"
                                    class="form-control"
                                    value="{{ old('FatherMobile', $student->Father_Mobile_Number) }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Focus on first input when modal opens
            var myModal = document.getElementById('studentFormModal')
            if (myModal) {
                myModal.addEventListener('shown.bs.modal', function() {
                    document.getElementById('studentName').focus()
                })
            }
        });
    </script>
@endsection
