<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee24mfb - Login</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/x-icon">

    <!-- Project Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" id="color" media="screen">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iconly-icon.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fe;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 30px 15px;
        }

        .login-main {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            max-width: 420px;
            margin: auto;
            width: 100%;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }

        .login-social a {
            text-decoration: none;
            transition: all 0.3s;
        }

        .login-social a:hover {
            transform: scale(1.1);
        }

        .loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            background: #fff;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader span {
            display: inline-block;
            width: 10px;
            height: 10px;
            background: #007bff;
            margin: 5px;
            border-radius: 50%;
            animation: bounce 0.6s infinite alternate;
        }

        .loader span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loader span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            to {
                transform: translateY(-20px);
            }
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="loader-wrapper" id="loader">
        <div class="loader"><span></span><span></span><span></span></div>
    </div>

    <div class="container-fluid p-0">
        <div class="login-card">
            <div>
               
                <div class="login-main">
                    <form method="POST" action="{{ route('login') }}" class="theme-form">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @csrf

                        <div class="text-center mb-3">
                            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 40px;">
                        </div>

                        <h4 class="text-center mb-2">Sign in to account</h4>
                        <p class="text-center text-muted mb-4">Enter your email & password to login</p>

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group position-relative">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input class="form-control" type="password" id="password" name="password" required placeholder="********" minlength="8">
                                <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-group d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" id="remember_me" type="checkbox" name="remember">
                                <label class="form-check-label" for="remember_me">Remember</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>

                        <!-- Submit -->
                        <button class="btn btn-primary w-100 mb-3" type="submit">Sign in</button>

                        <!-- Register -->
                        <p class="mt-4 text-center mb-0">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-primary">Create Account</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/password.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        // Hide loader on page load
        window.addEventListener('load', function () {
            document.getElementById('loader').style.display = 'none';
        });

        // Toggle password visibility
        const togglePassword = document.getElementById("togglePassword");
        const password = document.getElementById("password");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.classList.toggle("bi-eye");
            this.classList.toggle("bi-eye-slash");
        });
    </script>
</body>
</html>
