@extends('layout')
@section('title')
    Courses Details
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card shadow rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">💻 Courses Details</h4>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#studentFormModal">
                                <i class="bi bi-plus-lg"></i> Add Course
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Course Description</th>
                                        <th>Course Price</th>
                                        <th>Image</th>
                                        <th width="220">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>{{ $course->Course_Name }}</td>
                                            <td>{{ $course->Course_Description }}</td>
                                            <td>{{ $course->Price }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $course->Course_Image) }}"
                                                    class="img-fluid rounded" style="max-width: 100px; height: auto;">
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Edit button -->
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#editFormModal{{ $course->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </button>

                                                    <!-- Delete button with confirmation -->
                                                    <form action="{{ route('coursedestroy', $course->id) }}" method="POST"
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
                    <h5 class="modal-title" id="studentFormModalLabel">Add Courses For Students</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="studentForm" action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="form_type" value="create">
                            <label for="Course" class="form-label #editFormModal">Course Name</label>
                            <input accept="" type="text" id="Course" name="Course" class="form-control"
                                placeholder="Enter Course Name" value="{{ old('Course') }}">
                        </div>
                        <div class="mb-3">
                            <label for="CourseDescription" class="form-label">Course Description</label>
                            <textarea id="CourseDescription" rows="5" cols="5" name="CourseDescription" class="form-control"
                                placeholder="Enter Course Description">{{ old('CourseDescription') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="CoursePrice" class="form-label">Course Price</label>
                            <input id="CoursePrice" value="{{ old('Course Price') }}" name="CoursePrice"
                                class="form-control" placeholder="Enter Course Price" />
                        </div>
                        <div class="mb-3">
                            <label for="Image" class="form-label">Image</label>
                            <input type="file" id="Image" name="Image" class="form-control"
                                placeholder="Upload Image" value="{{ old('Image') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($courses as $course)
        <div class="modal fade" id="editFormModal{{ $course->id }}" tabindex="-1"
            aria-labelledby="editFormModalLabel{{ $course->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editFormModalLabel{{ $course->id }}">Update Course</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('courseedit', $course->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" name="form_type" value="edit">
                                <input type="hidden" name="edit_type" value="{{ $course->id }}">
                                <label for="Course{{ $course->id }}" class="form-label fw-semibold">Course
                                    Name</label>
                                <input type="text" class="form-control" id="Course{{ $course->id }}"
                                    value="{{ $course->Course_Name }}" name="Course">
                            </div>
                            <div class="mb-3">
                                <label for="Description{{ $course->id }}" class="form-label fw-semibold">Course
                                    Description</label>
                                <textarea type="text" rows="5" cols="5" class="form-control" id="Description{{ $course->id }}"
                                    value="" name="Description">{{ $course->Course_Description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="Description{{ $course->id }}" class="form-label fw-semibold">Course
                                    Price</label>
                                <input type="text" class="form-control" id="Price{{ $course->id }}"
                                    value="{{ $course->Price }}" name="Price"></input>
                            </div>
                            <div class="mb-3">
                                <label for="CourseImage{{ $course->id }}" class="form-label fw-semibold">Current
                                    Image</label>
                                <img src="{{ asset('storage/' . $course->Course_Image) }}" class="img-fluid rounded mb-2"
                                    style="max-width: 100px; height: auto;">
                            </div>
                            <div class="mb-3">
                                <label for="Image{{ $course->id }}" class="form-label fw-semibold">Update
                                    Image</label>
                                <input type="file" class="form-control" name="Image">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                Update Course
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
                    searchPlaceholder: "Search course..."
                }
            });
        });
    </script>
@endsection
