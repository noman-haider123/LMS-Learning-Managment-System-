@extends("layout")
@section('title')
Dashboard
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endsection
    @section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK'
        });
        </script>
@endif
@if (session('message'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('message') }}',
        confirmButtonText: 'OK'
    });
    </script>
@endif
<div class="container my-4">
    <div class="chart-container" style="position: relative; height:60vh; width:100%;">
        <canvas id="dashboardChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('dashboardChart').getContext('2d');

        const dashboardChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Users', 'Total Students', 'Available Courses', 'Teacher Attendance'],
                datasets: [{
                    label: 'Total Count',
                    data: [
                        {{ $userCount ?? 0 }},
                        {{ $students ?? 0 }},
                        {{ $courseCount ?? 0 }},
                        {{ $teacherAttendanceCount ?? 0 }}
                    ],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                    borderColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Dashboard Overview',
                        font: {
                            size: 18
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    },
                }
            }
        });
    </script>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection