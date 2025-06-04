@extends('layout')
@section('title')
    Student Certificate
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                            <h4 class="mb-0">🖼️ Student Certificate</h4>
                            @can('Add Certificate') 
                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                            data-bs-target="#studentFormModal">
                            <i class="bi bi-plus-lg"></i> Add Certificate for Student
                        </button>
                        @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Course Name</th>
                                        <th>Teacher Name</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($certificate as $certificates)
                                        <tr>
                                            <td>{{ $certificates->students->Name }}</td>
                                            <td>{{ $certificates->courses->Course_Name }}</td>
                                            <td>{{ $certificates->users->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    @can('Edit Certificate')
                                                    <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#editFormModal{{ $certificates->id }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                @endcan             <!-- Edit button -->
                                                    <!-- Delete button with confirmation -->
                                                    @can('delete certificate')  
                                                    <form action="{{ route('certificatedestroy', $certificates->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                        class="btn btn-sm btn-outline-danger delete-btn">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                                @endcan
                                                    <a href="{{ route('certificate.download', $certificates->id) }}"
                                                        class="btn btn-sm btn-outline-success" target="_blank">
                                                        <i class="bi bi-award"></i> Download Certificate
                                                    </a>
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
                    <h5 class="modal-title" id="studentFormModalLabel">Add Certificate For Students</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="studentForm" action="{{ route('certificatestore') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="form_type" value="create">
                            <label for="Course" class="form-label #editFormModal">Course Name</label>
                            <select name="Course_Name" id="" class="form-select">
                                <option selected disabled>Select Course</option>
                                @foreach ($course as $courses)
                                    <option value="{{ $courses->id }}">{{ $courses->Course_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="CourseDescription" class="form-label">Student Name</label>
                            <select name="Student_Name" id="" class="form-select">
                                <option selected disabled>Select Student Name</option>
                                @foreach ($students as $student)
                                    @if (!in_array($student->id, $pluck))
                                        <option value="{{ $student->id }}">{{ $student->Name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="CourseDescription" class="form-label">Teacher Name</label>
                            <select name="Teacher_Name" id="" class="form-select">
                                <option selected disabled>Select Teacher Name</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->users->id }}">{{ $student->users->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Certificate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($certificate as $certificates)
        <div class="modal fade" id="editFormModal{{ $certificates->id }}" tabindex="-1"
            aria-labelledby="editFormModalLabel{{ $certificates->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editFormModalLabel{{ $certificates->id }}">Update Attendence</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('certificateedit', $certificates->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" name="form_type" value="create">
                                <label for="Course" class="form-label #editFormModal">Course Name</label>
                                <select name="Course_Name" class="form-select">
                                    <option selected disabled>Select Course</option>
                                    @foreach ($course as $courses)
                                        <option value="{{ $courses->id }}"
                                            {{ isset($certificates) && $courses->id == $certificates->Course_id ? 'selected' : '' }}>
                                            {{ $courses->Course_Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="CourseDescription" class="form-label">Student Name</label>
                                <select name="Student_Name" class="form-select">
                                    <option selected disabled>Select Student Name</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}"
                                            {{ isset($certificates) && $student->id == $certificates->Student_id ? 'selected' : '' }}>
                                            {{ $student->Name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="CourseDescription" class="form-label">Teacher Name</label>
                                <select name="Teacher_Name" class="form-select">
                                    <option selected disabled>Select Teacher Name</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->users->id }}"
                                            {{ isset($certificates) && $student->users->id == $certificates->Created_by ? 'selected' : '' }}>
                                            {{ $student->users->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                Update Certificate
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
@endsection
