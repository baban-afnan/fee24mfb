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
</head>

<body>
    <div class="loader-wrapper">
        <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>

    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div class="text-center">
                            <a class="logo" href="#"><img class="img-fluid for-light m-auto" src="{{ asset('assets/images/logo/logo.png') }}" alt="logo"></a>
                        </div>
                        <div class="login-main">
                            <form method="POST" action="{{ route('password.email') }}" class="theme-form">
                                @csrf
                                 <img class="for-dark" src="../assets/images/logo/logo-dark.png" alt="logo" style="max-width: 50px; height: auto;">
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
                                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary btn-block w-100">
                                        Email Password Reset Link
                                    </button>
                                </div>

                                <p class="mt-4 mb-0 text-center">
                                    <a href="{{ route('login') }}">Back to login</a>
                                </p>
                            </form>
                        </div>
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
</body>
</html>
