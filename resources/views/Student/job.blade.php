@extends("layout")
@section('title')
Dashboard
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
                            <h4 class="mb-0">💼 Our Students Details For Placement</h4>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#studentFormModal">
                                <i class="bi bi-plus-lg"></i> Add Placement
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Student Review</th>
                                        <th>Student Position</th>
                                        <th>Student Image</th>
                                        <th width="220">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobplacement as $jobplacements)
                                        <tr>
                                            <td>{{ $jobplacements->Student_Name }}</td>
                                            <td>{{ $jobplacements->Student_Review}}</td>
                                            <td>{{ $jobplacements->Student_Position}}</td>
                                            <td><img src="{{ asset('storage/'. $jobplacements->Student_Image) }}" class="img-fluid rounded" style="max-width: 100px; height: auto;"></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Edit button -->
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#editFormModal{{ $jobplacements->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </button>

                                                    <!-- Delete button with confirmation -->
                                                    <form action="{{ route('jobdestroy',$jobplacements->id ) }}"
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
      <div class="modal fade" id="studentFormModal" tabindex="-1" aria-labelledby="studentFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="studentFormModalLabel">Add Placement</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="studentForm" action="{{ route('jobstore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="form_type" value="create">
                            <label for="name" class="form-label #editFormModal">Student Name</label>
                            <input type="text" name="name" id="name" value="{{ old("name") }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Student Description</label>
                           <textarea name="description" id="description" cols="5" rows="5" class="form-control">{{old("description")}}</textarea>
                        </div>
                         <div class="mb-3">
                            <label for="Position" class="form-label">Student Position</label>
                           <input name="Position" id="Position" class="form-control" value="{{ old('Position') }}"></input>
                        </div>
                           <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                           <input type="file" id="image" name="image" value="{{ old('image') }}" class="form-control"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Placement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
       @foreach ($jobplacement as $jobplacements)
        <div class="modal fade" id="editFormModal{{ $jobplacements->id }}" tabindex="-1"
            aria-labelledby="editFormModalLabel{{ $jobplacements->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editFormModalLabel{{ $jobplacements->id }}">Update Placement</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('jobedit',$jobplacements->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" name="form_type" value="edit">
                                <input type="hidden" name="edit_type" value="{{ $jobplacements->id }}">
                                <label for="name{{ $jobplacements->id }}" class="form-label fw-semibold"> Student
                                    Name</label>
                                <input type="text" class="form-control" id="name{{ $jobplacements->id }}"
                                    value="{{ $jobplacements->Student_Name}}" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="description{{ $jobplacements->id }}" class="form-label fw-semibold"> Student
                                    Description</label>
                                <textarea type="text" class="form-control" cols="5" rows="5" id="description{{ $jobplacements->id }}" name="description">{{$jobplacements->Student_Review}}</textarea>
                            </div>
                             <label for="name{{ $jobplacements->id }}" class="form-label fw-semibold"> Student Position
                                    </label>
                                <input type="text" class="form-control" id="position{{ $jobplacements->id }}"
                                    value="{{ $jobplacements->Student_Position	}}" name="position">
                            <div class="mb-3">
                              <img src="{{ asset('storage/' . $jobplacements->Student_Image)}}" class="img-fluid rounded mt-3" style="max-width: 100px; height: auto;">
                            </div>
                            <div class="mb-3">
                             <label for="name" class="form-label fw-semibold"> Student
                                    Image</label>
                               <input type="file" name="image" class="form-control">     
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                Update
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