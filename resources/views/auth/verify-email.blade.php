<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee24mfb - Verify Email</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/x-icon">

    <!-- Vendor & Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" id="color" media="screen">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iconly-icon.css') }}">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- Loader -->
    <div class="loader-wrapper">
        <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>

    <div class="container-fluid p-0 vh-100 d-flex justify-content-center align-items-center">
        <div class="login-card login-dark shadow-lg rounded-3 p-4">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="logo" class="img-fluid" style="max-width: 80px;">
                <h4 class="mt-3">Verify Your Email</h4>
            </div>

            <div class="login-main">
                <div class="text-muted text-center mb-4">
                    <i class="bi bi-envelope-paper-heart fs-1 text-primary"></i>
                    <p class="mt-2">
                        Thanks for signing up! We’ve sent a verification link to your email address.
                        Please check your inbox and click the link to activate your account.
                        <br><br>
                        Didn't receive the email? No worries!
                    </p>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        A new verification link has been sent to your email address.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex flex-column gap-3">
                    <!-- Resend Verification -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-arrow-repeat me-1"></i> Resend Verification Email
                        </button>
                    </form>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-box-arrow-right me-1"></i> Log Out
                        </button>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Still can't find it? Be sure to check your <strong>spam</strong> or <strong>junk</strong> folders.
                    </small>
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
