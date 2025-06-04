<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap 5 CSS -->
    @yield('css')
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #4e73df;
            --primary-dark: #224abe;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --text-dark: #5a5c69;
            --text-light: #d1d3e2;
            --transition-speed: 0.3s;
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            position: fixed;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: all var(--transition-speed) ease;
            z-index: 1030;
            overflow-y: auto;
        }

        .sidebar-brand {
            height: 4.375rem;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-align: center;
            letter-spacing: 0.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background: rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed);
        }

        .sidebar-brand:hover {
            background: rgba(0, 0, 0, 0.15);
        }

        .sidebar-brand-icon {
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 0 1rem 1rem;
        }

        .sidebar-heading {
            padding: 0 1rem;
            font-weight: 800;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.13rem;
            margin-top: 1rem;
        }

        .nav-item {
            position: relative;
            margin-bottom: 0.25rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            transition: all var(--transition-speed);
            border-left: 0.25rem solid transparent;
            border-radius: 0 0.35rem 0.35rem 0;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border-left: 0.25rem solid white;
            font-weight: 700;
        }

        .nav-link i {
            font-size: 0.95rem;
            margin-right: 0.5rem;
            width: 1.2rem;
            text-align: center;
        }

        /* Main Content */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all var(--transition-speed);
        }

        /* Top Navigation */
        .topbar {
            height: 4.375rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            background-color: white;
            z-index: 1020;
        }

        .navbar-search {
            width: 25rem;
        }

        .navbar-search .form-control {
            font-size: 0.85rem;
            height: auto;
            border-radius: 0.35rem 0 0 0.35rem;
            border-right: none;
        }

        .navbar-search .btn {
            border-radius: 0 0.35rem 0.35rem 0;
        }

        .topbar-divider {
            width: 0;
            border-right: 1px solid #e3e6f0;
            height: calc(4.375rem - 2rem);
            margin: auto 1rem;
        }

        .topbar .nav-item .nav-link {
            height: 4.375rem;
            display: flex;
            align-items: center;
            padding: 0 0.75rem;
            color: var(--text-dark);
            position: relative;
        }

        .topbar .nav-item .nav-link:hover {
            color: var(--primary-color);
        }

        .topbar .dropdown-toggle::after {
            display: none;
        }

        .badge-counter {
            position: absolute;
            transform: scale(0.7);
            transform-origin: top right;
            right: 0.25rem;
            top: 0.5rem;
        }

        /* Dashboard Cards */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 1.5rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Custom Scrollbar */

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1029;
            display: none;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1030;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            #content {
                width: 100%;
                margin-left: 0;
            }

            .navbar-search {
                width: auto;
                max-width: 200px;
            }
        }

        @media (max-width: 768px) {
            .navbar-search {
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Utilities */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
    </style>
</head>

<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar" style="height: 100vh; overflow-y: auto; overflow-x: hidden;">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="sidebar-brand-text mx-3">EduLMS Pro</div>
        </a>

        <hr class="sidebar-divider my-0">

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('dashboard') }}"><i
                        class="bi bi-speedometer2"></i><span>Dashboard</span></a>
            </li>
        </ul>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Management</div>
        <ul class="nav flex-column">
            @can('User Details')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('createrole') }}"><i class="bi bi-people-fill"></i>User Details</a>
                </li>
            @endcan
            @can('Permission Details')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('createpermission') }}"><i class="bi bi-shield-lock"></i>Role &
                        Permission Details</a>
                </li>
            @endcan
            @can('Students Details')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('students.index') }}"><i class="bi bi-people-fill"></i> Students</a>
                </li>
            @endcan
            @can('Students Attendece')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}"><i class="bi bi-clipboard-check-fill"></i> Students
                        Attendence</a>
                </li>
            @endcan
            @can('courses Details')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('course') }}"><i class="bi bi-journal-bookmark-fill"></i>Courses</a>
                </li>
            @endcan
            @can('Teacher Attendence')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('teachertrack') }}"><i class="bi bi-person-check-fill"></i>Teacher
                        Attendence</a>
                </li>
            @endcan
            @can('About us')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('whychooseme') }}"><i class="bi bi-star-fill"></i>Why_Choose_Us
                    </a>
                </li>
            @endcan
            @can('job placement')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('jobindex') }}"><i class="bi bi-person-badge-fill"></i>Job Placement
                    </a>
                </li>
            @endcan
            @can('course Enrollment payment')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('payments') }}"><i class="bi bi-credit-card-fill"></i>Course
                        Enrollment payments
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link" href="{{ route('certificate') }}"><i class="bi bi-award"></i>
                    Student Certificate
                </a>
            </li>
        </ul>
    </nav>

    <!-- Content Wrapper -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand topbar mb-4 static-top shadow">
            <div class="container-fluid px-3 px-lg-4">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggle" class="btn btn-link d-md-none rounded-circle me-3">
                    <i class="bi bi-list"></i>
                </button>
                <!-- Topbar Navbar -->
                @can('Check In')
                    <form method="POST" action="{{ route('checkIn') }}">
                        @csrf
                        <button class="btn btn-success mx-3">Check In</button>
                    </form>
                @endcan
                @can('Check Out')
                    <form method="POST" action="{{ route('checkOut') }}">
                        @csrf
                        <button class="btn btn-danger">Check Out</button>
                    </form>
                @endcan
                <ul class="navbar-nav ms-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle"
                                src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('default-avatar.png') }}"
                                style="width: 40px; height: 40px; object-fit: cover;" alt="Profile Image" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-fill me-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <!-- Logout Modal-->
                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#logoutModal">
                                <i class="bi bi-box-arrow-right me-2 text-gray-400"></i>
                                Logout
                            </a>

                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Main Content -->
        <div class="container-fluid px-4">
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Select "Logout" below if you are ready to end your current session.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @php
                use App\Models\User;
                use App\Models\Student;
                use App\Models\Course;
                use App\Models\TeacherAttendance;
                $userCount = User::count();
                $query = Student::orderBy('id', 'ASC');
                if (!Auth::user()->hasRole('Admin')) {
                    $query->where('Created_By', Auth::id());
                }
                $students = $query->count();
                $courseCount = Course::count();
                $teacherAttendanceCount = TeacherAttendance::count();
            @endphp
            <div class="row">
                <!-- Total Users -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-primary text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $userCount }}</div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Students -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-warning text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-uppercase mb-1">My Students</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $students }}</div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Courses -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-success text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-uppercase mb-1">Total Courses</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $courseCount }}</div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- Teacher Attendance -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card bg-danger text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-uppercase mb-1">Teacher Attendance</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $teacherAttendanceCount }}</div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @yield('content')
    </div>
    <!-- /.container-fluid -->
    <!-- Bootstrap JS Bundle with Popper -->
    @yield('js')
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
            document.querySelector('.sidebar-overlay').classList.toggle('show');
        });

        // Close sidebar when clicking on overlay
        document.querySelector('.sidebar-overlay').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('show');
            this.classList.remove('show');
        });

        // Close sidebar when clicking on a nav link (for mobile)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    document.querySelector('.sidebar').classList.remove('show');
                    document.querySelector('.sidebar-overlay').classList.remove('show');
                }
            });
        });
    </script>
