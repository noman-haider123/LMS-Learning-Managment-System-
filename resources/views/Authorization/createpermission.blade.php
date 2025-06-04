@extends('layout')
@section('title')
    Permission Assign
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
                @if ($errors->has('Permission'))
                    let roleFormModal = new bootstrap.Modal(document.getElementById('roleFormModal'));
                    roleFormModal.show();
                    {}
                @elseif ($errors->has('permissions'))
                    @foreach ($users as $user)
                        if (document.getElementById('editFormModal{{ $user->id }}')) {
                            let editFormModal = new bootstrap.Modal(document.getElementById(
                                'editFormModal{{ $user->id }}'));
                            editFormModal.show();
                        }
                    @endforeach
                @endif
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
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
    @if (session("Permission"))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session("Permission") }}',
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
                            <h4 class="mb-0">🔑 Roles & Permission Details</h4>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#roleFormModal">
                                <i class="bi bi-plus-lg"></i> Create Permission
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Role_Name</th>
                                        <th>Permission_Name</th>
                                        <th width="220">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @if ($role->permissions->isNotEmpty())
                                                    {{ $role->permissions->pluck('name')->implode(', ') }}
                                                @else
                                                    <span class="text-muted">No Permission Assigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Edit button -->
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#editFormModal{{ $role->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </button>
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
    <div class="modal fade" id="roleFormModal" tabindex="-1" aria-labelledby="roleFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="roleFormModalLabel">Create Permission</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="roleForm" action="{{ route('storePermission') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="Role" class="form-label">Permission Name</label>
                            <input type="text" id="Permission" name="Permission" class="form-control"
                                placeholder="Enter Permission name" value="{{ old('Permission') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($roles as $role)
        <div class="modal fade" id="editFormModal{{ $role->id }}" tabindex="-1"
            aria-labelledby="editFormModalLabel{{ $role->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editFormModalLabel{{ $role->id }}">
                            Assign Permission for {{ $role->name }} Role
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <form action="{{ route("assignPermission",$role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Manage Permissions</label>
                                <div class="permission-checkbox-group">
                                    @foreach ($permission as $perm)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                id="permission_{{ $perm->id }}" value="{{ $perm->id }}"
                                                {{ $role->permissions->contains('id', $perm->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $perm->id }}">
                                                {{ $perm->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                {{ $role->permissions->isNotEmpty() ? 'Update Permission' : 'Assign Permission' }}
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
