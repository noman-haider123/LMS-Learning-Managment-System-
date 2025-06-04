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
<div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card shadow rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">🧾 Courses Enrollment Payments</h4>
                            {{-- <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#studentFormModal">
                                <i class="bi bi-plus-lg"></i> Add Student Attendance
                            </button> --}}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Customer Country</th>
                                        <th>Customer City</th>
                                        <th>Customer Amount</th>
                                        <th>Customer Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payements as $payement)
                                        <tr>
                                            <td>{{ $payement->courses->Course_Name }}</td>
                                            <td>{{ $payement->Customer_Name}}</td>
                                            <td>{{ $payement->Customer_Email}}</td>
                                            <td>{{ $payement->Country }}</td>
                                            <td>{{ $payement->City }}</td>
                                            <td>{{ $payement->Amount }} {{$payement->Currency}}</td>
                                            <td>{{ $payement->description}}</td>
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
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection