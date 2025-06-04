@extends('layout')
@section('title')
    Teacher Attendance
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
                            <h4 class="mb-0">🗓️ Teacher Attendance</h4>
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
                                        <th>Teacher Name</th>
                                        <th>IP Address</th>
                                        <th>Location</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Map</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->users->name}}</td>
                                            <td>{{ $attendance->ip_address}}</td>
                                            <td>{{ $attendance->location}}</td>
                                            <td>{{ $attendance->check_in_time}}</td>
                                            <td>{{ $attendance->check_out_time}}</td>
                                            <td>
                                                @if ($attendance->latitude && $attendance->longitude)
                                                    <iframe width="250" height="150" style="border:0" loading="lazy"
                                                        allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                                                        src="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}&output=embed">
                                                    </iframe>
                                                @else
                                                    Location not available
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    // Example school coordinates (customize)
                                                    // $schoolLat = 24.9434;  // AL-Jauhar Grammar School
                                                    // $schoolLon = 67.2059;
                                                    $schoolLat = 24.8591000; // My School
                                                    $schoolLon = 66.9983000;
                                                    $distance = sqrt(
                                                        pow($schoolLat - $attendance->latitude, 2) +
                                                            pow($schoolLon - $attendance->longitude, 2),
                                                    );
                                                @endphp

                                                @if ($distance > 0.01)
                                                    <span class="badge bg-danger">Outside School</span>
                                                @else
                                                    <span class="badge bg-success">Inside School</span>
                                                @endif
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
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
