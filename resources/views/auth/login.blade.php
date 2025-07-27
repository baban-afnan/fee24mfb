<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee24mfb - Agency Portal</title>
    
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
                            <a class="logo" href="#"><img class="img-fluid for-light m-auto" src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo"></a>
                        </div>
                        <div class="login-main">
                            <form method="POST" action="{{ route('login') }}" class="theme-form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                 <img class="for-dark" src="../assets/images/logo/logo-dark.png" alt="logo" style="max-width: 50px; height: auto;">
                                <h2 class="text-center">Sign in to account</h2>
                                <p class="text-center">Enter your email &amp; password to login</p>

                                  @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                                    </div>
                                  
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="input-group position-relative">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input class="form-control" type="password" name="password" required placeholder="********" maxlength="8" minlength="8">
                                    </div>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Remember Me and Forgot Password -->
                                <div class="form-group mb-0 d-flex justify-content-between align-items-center">
                                    <div class="form-check checkbox-solid-info">
                                        <input class="form-check-input" id="remember_me" type="checkbox" name="remember">
                                        <label class="form-check-label" for="remember_me">Remember password</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                                    @endif
                                </div>

                                <div class="text-end mt-3">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                                </div>

                                <!-- Social Login -->
                                <div class="login-social-title mt-4">
                                    <h6>Or Sign in with</h6>
                                </div>
                                <div class="form-group">
                                    <ul class="login-social d-flex justify-content-center list-unstyled gap-3">
                                        <li><a href="#"><i class="bi bi-facebook fs-4 text-primary"></i></a></li>
                                        <li><a href="#"><i class="bi bi-twitter fs-4 text-info"></i></a></li>
                                        <li><a href="#"><i class="bi bi-instagram fs-4 text-danger"></i></a></li>
                                        <li><a href="#"><i class="bi bi-google fs-4 text-danger"></i></a></li>
                                    </ul>
                                </div>

                                <p class="mt-4 mb-0 text-center">
                                    Don't have an account?
                                    <a class="ms-2" href="{{ route('register') }}">Create Account</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/password.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
