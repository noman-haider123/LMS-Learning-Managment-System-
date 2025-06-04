<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Empower Your Learning Journey</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    /* Navbar enhancements */
    .nav-link {
        position: relative;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        transform: translateY(-2px);
    }

    .active-indicator {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 3px;
        background: #feb47b;
        border-radius: 3px;
    }

    /* Hero section enhancements */
    .hero-section {
        padding-top: 100px;
        min-height: 90vh;
        background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
    }

    .text-gradient {
        background: linear-gradient(to right, #ff7e5f, #feb47b);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* Floating animation for illustration */
    .floating-animation {
        animation: floating 6s ease-in-out infinite;
    }

    @keyframes floating {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    /* Wave animation background */
    .bg-animation {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100px;
        background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="rgba(255,255,255,0.05)" opacity=".25"/></svg>');
        background-size: 1200px 100px;
    }

    .wave1 {
        animation: wave 30s linear infinite;
        z-index: 1;
        opacity: 0.5;
    }

    .wave2 {
        animation: wave 15s linear reverse infinite;
        z-index: 2;
        opacity: 0.3;
    }

    .wave3 {
        animation: wave 20s linear infinite;
        z-index: 3;
        opacity: 0.2;
    }

    .wave4 {
        animation: wave 25s linear reverse infinite;
        z-index: 4;
        opacity: 0.1;
    }

    @keyframes wave {
        0% {
            background-position-x: 0;
        }

        100% {
            background-position-x: 1200px;
        }
    }

    /* Button hover effects */
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 20px rgba(254, 180, 123, 0.4);
    }

    .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.1);
    }
</style>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top"
        style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); box-shadow: 0 4px 18px rgba(0,0,0,0.1);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#" style="font-weight: 600;">
                <img src="https://cdn.vectorstock.com/i/500p/06/95/flat-web-template-with-lms-for-concept-design-vector-42750695.jpg"
                    height="40" class="me-2">
                <span class="brand-text" style="font-size: 1.4rem;">LearnHub</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link active mt-3" href="#" style="position: relative;">
                            Home
                            <span class="active-indicator"></span>
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link" href="#courses">Courses</a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link" href="#why-choose-us">About</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3">
                        <a class="nav-link btn btn-primary ms-2 text-white px-3 py-2" href="{{ route('register') }}"
                            style="border-radius: 8px; font-weight: 500; transition: all 0.3s ease; background: linear-gradient(to right, #ff7e5f, #feb47b); border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            Register
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3">
                        <a class="nav-link btn btn-primary ms-2 text-white px-3 py-2" href="{{ route('login') }}"
                            style="border-radius: 8px; font-weight: 500; transition: all 0.3s ease; background: linear-gradient(to right, #ff7e5f, #feb47b); border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Enhanced Hero Section with animated gradient background -->
    <header class="hero-section" style="position: relative; overflow: hidden;">
        <div class="bg-animation">
            <div class="wave wave1"></div>
            <div class="wave wave2"></div>
            <div class="wave wave3"></div>
            <div class="wave wave4"></div>
        </div>

        <div class="container h-100" style="position: relative; z-index: 1;" id="home">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-white mb-4"
                        style="text-shadow: 0 2px 4px rgba(0,0,0,0.3); line-height: 1.3;">
                        Empower Your <span class="text-gradient">Learning Journey</span>
                    </h1>
                    <p class="lead text-white mb-4" style="font-size: 1.25rem; opacity: 0.9;">
                        Access top-quality courses from industry experts and take your skills to the next level.
                    </p>
                    <div class="d-flex flex-wrap" style="gap: 1rem;">
                        <a href="#courses" class="btn btn-primary btn-lg px-4 me-2"
                            style="border-radius: 8px; font-weight: 500; transition: all 0.3s ease; background: linear-gradient(to right, #ff7e5f, #feb47b); border: none; box-shadow: 0 4px 15px rgba(254, 180, 123, 0.4);">
                            Enroll in Courses
                        </a>
                        <a href="#testimonials" class="btn btn-outline-light btn-lg px-4"
                            style="border-radius: 8px; font-weight: 500; transition: all 0.3s ease; border-width: 2px;">
                            Our Students Review
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://mvjce.edu.in/wp-content/uploads/2024/06/Computer-engineering-computer-science-Key-Differences.webp"
                        alt="Learning illustration" class="img-fluid floating-animation" style="max-height: 500px;">
                </div>
            </div>
        </div>
    </header>
    <!-- Course Preview Section -->
    <section class="py-5 bg-light" id="courses">
        <div class="container">
            <div class="row mb-5">
                <div class="col text-center">
                    <h2 class="fw-bold">Featured Courses</h2>
                    <p class="text-muted">Start learning with our most popular courses</p>
                </div>
            </div>
            <div class="row g-4">
                <!-- Course 1 -->
                @foreach ($course as $courses)
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 course-card">
                            <img src="{{ asset('storage/' . $courses->Course_Image) }}" class="card-img-top img-fluid"
                                alt="Web Development" style="height: 150px; width: 100%; object-fit: cover;" />
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-success fw-bold">{{ $courses->Price }}</span>
                                </div>
                                <h5 class="card-title">{{ $courses->Course_Name }}</h5>
                                <p class="card-text text-muted">{{ $courses->Course_Description }}</p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#studentFormModal{{ $courses->id }}" data-bs-toggle="modal"
                                        data-bs-target="#studentFormModal{{ $courses->id }}"
                                        class="btn btn-sm btn-outline-primary">Enroll Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (old('form_type') === 'create' && old('course_id'))
                    let modalId = 'studentFormModal' + @json(old('course_id'));
                    let roleFormModal = new bootstrap.Modal(document.getElementById(modalId));
                    roleFormModal.show();
                @endif

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
    @foreach ($course as $courses)
        <div class="modal fade" id="studentFormModal{{ $courses->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Pay for {{ $courses->Course_Name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $courses->id }}">
                        <input type="hidden" name="amount" value="5000">

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name') }}" required>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control"
                                        value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="Country" class="form-control"
                                    value="{{ old('Country') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="City" class="form-control"
                                    value="{{ old('City') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Card Details</label>
                                <div id="card-element-{{ $courses->id }}" class="form-control p-2"></div>
                                <div id="card-errors-{{ $courses->id }}" class="text-danger small mt-2"></div>
                                <!-- Hidden input for Stripe token -->
                                <input type="hidden" name="stripeToken" id="stripeToken{{ $courses->id }}">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                Pay 5,000 PKR
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- <div class="alert alert-info mt-3">
                        <strong>Test Cards:</strong>
                        <ul class="mb-0">
                            <li>Success: 4242 4242 4242 4242</li>
                            <li>Declined: 4000 0000 0000 0002</li>
                            <li>3D Secure: 4000 0025 0000 3155</li>
                            <li>CVC: Any 3 digits</li>
                            <li>Date: Any future date</li>
                        </ul>
                    </div>
                </div> --}}
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stripe = Stripe("{{ $stripekey }}");

            @foreach ($course as $courses)
                // Setup Stripe Elements for each course modal
                const elements{{ $courses->id }} = stripe.elements();
                const card{{ $courses->id }} = elements{{ $courses->id }}.create('card');
                card{{ $courses->id }}.mount('#card-element-{{ $courses->id }}');

                // Handle form submission
                const form{{ $courses->id }} = document.querySelector(
                    '#studentFormModal{{ $courses->id }} form');
                const tokenInput{{ $courses->id }} = document.getElementById('stripeToken{{ $courses->id }}');

                form{{ $courses->id }}.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    // Create payment token
                    const {
                        token,
                        error
                    } = await stripe.createToken(card{{ $courses->id }});

                    if (error) {
                        document.getElementById('card-errors-{{ $courses->id }}').textContent = error
                            .message;
                    } else {
                        // Set token value and submit form
                        tokenInput{{ $courses->id }}.value = token.id;
                        form{{ $courses->id }}.submit();
                    }
                });
            @endforeach
        });
    </script>
    <!-- Why Choose Us Section -->
    <section class="py-5" id="why-choose-us">
        <div class="container">
            <div class="row mb-5">
                <div class="col text-center">
                    <h2 class="fw-bold">Why Choose LearnHub?</h2>
                    <p class="text-muted">We provide the best learning experience for our students</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($why_choose_us as $why_choose_uss)
                    <div class="col-md-6 col-lg-3">
                        <div class="text-center p-4 feature-card h-100 shadow rounded">
                            <div class="feature-icon mb-3">
                                <img src="{{ asset('storage/' . $why_choose_uss->image) }}" class="img-fluid"
                                    alt="{{ $why_choose_uss->name }}" style="height: 100px; object-fit: contain;">
                            </div>
                            <h5>{{ $why_choose_uss->name }}</h5>
                            <p class="text-muted">{{ $why_choose_uss->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->

    <section class="py-5 bg-light" id="testimonials">
        <div class="container">
            <div class="row mb-5">
                <div class="col text-center">
                    <h2 class="fw-bold">What Our Students Say</h2>
                    <p class="text-muted">Hear from our successful students</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($JobPlacement as $index => $JobPlacements)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="testimonial-card text-center p-4">
                                        <img src="{{ asset('storage/' . $JobPlacements->Student_Image) }}"
                                            class="rounded-circle mb-3" width="80" alt="Student">
                                        <p class="lead mb-4">{{ $JobPlacements->Student_Review }}</p>
                                        <h5 class="mb-1">{{ $JobPlacements->Student_Name }}</h5>
                                        <p class="text-muted">{{ $JobPlacements->Student_Position }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <img src="https://cdn.vectorstock.com/i/500p/06/95/flat-web-template-with-lms-for-concept-design-vector-42750695.jpg"
                        alt="LearnHub" height="40" class="mb-3">
                    <p>Empowering learners worldwide with high-quality, accessible education since 2015.</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#courses" class="text-white text-decoration-none">Courses</a>
                        </li>
                        <li class="mb-2"><a href="#why-choose-us" class="text-white text-decoration-none">About
                                Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold mb-4">Courses</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">Web Development</li>
                        <li class="mb-2">Cyber Security</a></li>
                        <li class="mb-2">Digital Marketing</a></li>
                        <li class="mb-2">UI/UX Design</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-4">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Education St, Learning City,
                            10101</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (123) 456-7890</li>
                        <a href="mailto:nomaniqbalhaider@gmail.com">
                            <li class="mb-2"><i class="fas fa-envelope me-2"></i>nomaniqbalhaider@gmail.com (Admin)</li>
                        </a>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-secondary">

        </div>
    </footer>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>

</html>
