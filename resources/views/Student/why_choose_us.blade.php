@extends("layout")
@section('title')
Why Choose Us
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
                            <h4 class="mb-0">🖼️ Why_Choose_us</h4>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#studentFormModal">
                                <i class="bi bi-plus-lg"></i> Add
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th width="220">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Why_Choose_us as $Why_Choose_uss)
                                        <tr>
                                            <td>{{ $Why_Choose_uss->name }}</td>
                                            <td>{{ $Why_Choose_uss->description}}</td>
                                            <td><img src="{{ asset('storage/'. $Why_Choose_uss->image) }}" class="img-fluid rounded" style="max-width: 100px; height: auto;"></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Edit button -->
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#editFormModal{{ $Why_Choose_uss->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </button>

                                                    <!-- Delete button with confirmation -->
                                                    <form action="{{ route('whychoosemedestroy',$Why_Choose_uss->id) }}"
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
                    <h5 class="modal-title" id="studentFormModalLabel">Add About Us</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="studentForm" action="{{ route('whychoosemestore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="form_type" value="create">
                            <label for="name" class="form-label #editFormModal">Name</label>
                            <input type="text" name="name" id="name" value="{{ old("name") }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                           <textarea name="description" id="description" cols="5" rows="5" class="form-control">{{old("description")}}</textarea>
                        </div>
                           <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                           <input type="file" id="image" name="image" value="{{ old('image') }}" class="form-control"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     @foreach ($Why_Choose_us as $Why_Choose_uss)
        <div class="modal fade" id="editFormModal{{ $Why_Choose_uss->id }}" tabindex="-1"
            aria-labelledby="editFormModalLabel{{ $Why_Choose_uss->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editFormModalLabel{{ $Why_Choose_uss->id }}">Update Why_Choose_us</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('whychoosemeedit',$Why_Choose_uss->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" name="form_type" value="edit">
                                <input type="hidden" name="edit_type" value="{{ $Why_Choose_uss->id }}">
                                <label for="name{{ $Why_Choose_uss->id }}" class="form-label fw-semibold">
                                    Name</label>
                                <input type="text" class="form-control" id="name{{ $Why_Choose_uss->id }}"
                                    value="{{ $Why_Choose_uss->name}}" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="description{{ $Why_Choose_uss->id }}" class="form-label fw-semibold">
                                    Description</label>
                                <textarea type="text" class="form-control" cols="5" rows="5" id="description{{ $Why_Choose_uss->id }}" name="description">{{$Why_Choose_uss->description}}</textarea>
                            </div>
                            <div class="mb-3">
                              <img src="{{ asset('storage/' . $Why_Choose_uss->image)}}" class="img-fluid rounded" style="max-width: 100px; height: auto;">
                            </div>
                            <div class="mb-3">
                             <label for="name" class="form-label fw-semibold">
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