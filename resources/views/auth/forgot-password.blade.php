<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee24mfb - Forgot Password</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/x-icon">

    <!-- Custom & Vendor CSS -->
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
        .email-invalid {
            border-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="loader-wrapper">
        <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>

    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div class="login-main">
                        <form method="POST" action="{{ route('password.email') }}" class="theme-form" id="forgotForm">
                            @csrf

                            <!-- Logo -->
                            <div class="text-center mb-3">
                                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 40px;">
                            </div>

                            <!-- Heading -->
                            <h2 class="text-center">Forgot Password</h2>
                            <p class="text-center mb-4">
                                Enter your email address and we’ll send you a link to reset your password.
                            </p>

                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="alert alert-success text-center">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <!-- Email Input -->
                            <div class="form-group">
                                <label class="col-form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input 
                                        class="form-control" 
                                        type="email" 
                                        id="emailInput"
                                        name="email" 
                                        value="{{ old('email') }}" 
                                        required 
                                        autofocus 
                                        placeholder="you@example.com"
                                    >
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end mt-3">
                                <button 
                                    type="submit" 
                                    class="btn btn-primary w-100" 
                                    id="submitBtn" 
                                    disabled
                                >
                                    Email Password Reset Link
                                </button>
                            </div>

                            <!-- Back to Login -->
                            <p class="mt-4 mb-0 text-center">
                                <a href="{{ route('login') }}">Back to login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/password.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        // Email validation
        document.addEventListener("DOMContentLoaded", function () {
            const emailInput = document.getElementById('emailInput');
            const submitBtn = document.getElementById('submitBtn');

            emailInput.addEventListener('input', function () {
                const emailValue = emailInput.value.trim();
                const isValid = emailValue.includes('@') && emailValue.includes('.com');

                if (isValid) {
                    emailInput.classList.remove('email-invalid');
                    submitBtn.removeAttribute('disabled');
                } else {
                    emailInput.classList.add('email-invalid');
                    submitBtn.setAttribute('disabled', true);
                }
            });
        });
    </script>
</body>
</html>
