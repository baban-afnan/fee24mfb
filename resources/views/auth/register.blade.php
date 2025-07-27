<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee24mfb - Register</title>

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

   
            <!-- Registration Form -->
           <div class="container-fluid p-0">
           <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                      <div>
                        <div class="text-center">
                         <a class="logo" href="#"><img class="img-fluid for-light m-auto" src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo"></a>
                        </div>
                       <div class="login-main">
                        <form method="POST" action="{{ route('register') }}" class="theme-form">
                            @csrf
                            <h2 class="text-center">Create Account</h2>
                            <p class="text-center">Fill in your details to register</p>
 
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <!-- First and Last Name Side by Side -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input class="form-control" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input class="form-control" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group mb-3">
                                <label class="col-form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label class="col-form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input class="form-control" type="password" name="password" placeholder="********" required maxlength="8" minlength="8">
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group mb-3">
                                <label class="col-form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="********" required maxlength="8" minlength="8">
                                </div>
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Terms Agreement -->
                            <div class="form-group mb-3 checkbox-checked">
                                <div class="form-check checkbox-solid-info">
                                    <input class="form-check-input" id="solid6" type="checkbox" name="agree_terms" required>
                                    <label class="form-check-label" for="solid6">I agree with the</label>
                                    <a class="ms-2 link" href="privacy-policy.html">Privacy Policy</a>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button class="btn btn-primary w-100" type="submit">Register</button>
                            </div>

                            <!-- Social Login -->
                            <div class="login-social-title mt-4">
                                <h6>Or Register with</h6>
                            </div>
                            <ul class="login-social d-flex justify-content-center list-unstyled gap-3">
                                <li><a href="#"><i class="bi bi-facebook fs-4 text-primary"></i></a></li>
                                <li><a href="#"><i class="bi bi-twitter fs-4 text-info"></i></a></li>
                                <li><a href="#"><i class="bi bi-instagram fs-4 text-danger"></i></a></li>
                                <li><a href="#"><i class="bi bi-google fs-4 text-danger"></i></a></li>
                            </ul>

                            <!-- Already Registered -->
                            <p class="mt-4 text-center">
                                Already registered?
                                <a class="ms-2" href="{{ route('login') }}">Sign in</a>
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
</body>

</html>
