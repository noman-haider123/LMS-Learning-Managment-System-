<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LMS Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1584697964194-fce4f2b27e8c?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
    }

    .login-card {
      max-width: 400px;
      margin: auto;
      margin-top: 10%;
      padding: 2rem;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .login-card h3 {
      font-weight: bold;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #007bff;
    }

    .btn-login {
      width: 100%;
    }

    .text-muted {
      font-size: 0.9rem;
      display: block;
      margin-top: 10px;
    }

    .lms-logo {
      display: block;
      margin: auto;
      width: 80px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {

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
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                });
            });
        </script>
   @endif
   @if (session('status'))
       <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('status') }}',
                });
            });
        </script>
   @endif
  <div class="login-card shadow-lg">
    <img src="https://cdn-icons-png.flaticon.com/512/2920/2920033.png" alt="LMS Logo" class="lms-logo">
    <h3>LMS Login</h3>

    <form action="{{ route('login') }}" method="POST">
        @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="text" class="form-control" name="email" value="{{ old('email') }}" id="email" placeholder="Enter Your Email Address">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" value="{{ old('password') }}" name="password" placeholder="Enter a Your Email Password">
      </div>
      <button type="submit" class="btn btn-primary btn-login">Login</button>
      <small class="text-muted text-center d-block mt-3">Don't have an account? <a href="{{ route('register') }}">Register</a></small>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
