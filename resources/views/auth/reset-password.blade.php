<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee24mfb - Reset Password</title>

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
                        </div>
                        <div class="login-main">
                            <form method="POST" action="{{ route('password.store') }}" class="theme-form" id="resetForm">
                                @csrf

                                  <div class="text-center mb-3">
                                   <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 40px;">
                                </div>
                                <h2 class="text-center">Reset Password</h2>
                                <p class="text-center mb-4">Enter your new password below.</p>

                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus readonly placeholder="you@example.com">
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div class="form-group mt-3">
                                    <label class="col-form-label">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input class="form-control" id="password" type="password" name="password" required placeholder="********">
                                    </div>
                                    <small id="strengthMessage" class="mt-1 d-block fw-bold"></small>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group mt-3">
                                    <label class="col-form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required placeholder="********">
                                    </div>
                                    <small id="matchMessage" class="d-block mt-1 fw-bold"></small>
                                    @error('password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>Reset Password</button>
                                </div>

                                <p class="mt-4 text-center">
                                    <a href="{{ route('login') }}">Back to login</a>
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

    <!-- Password Strength & Match Logic -->
    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const strengthMessage = document.getElementById('strengthMessage');
        const matchMessage = document.getElementById('matchMessage');
        const submitBtn = document.getElementById('submitBtn');

        function checkPasswordStrength(pass) {
            let strength = 0;

            if (pass.length >= 8) strength++;
            if (/[A-Z]/.test(pass)) strength++;
            if (/[a-z]/.test(pass)) strength++;
            if (/[0-9]/.test(pass)) strength++;
            if (/[\W]/.test(pass)) strength++; // Special characters

            return strength;
        }

        function updateStatus() {
            const pwd = password.value;
            const confirmPwd = confirmPassword.value;
            const strength = checkPasswordStrength(pwd);
            let validStrength = false;

            if (!pwd) {
                strengthMessage.textContent = '';
            } else if (strength <= 2) {
                strengthMessage.textContent = 'Weak password';
                strengthMessage.className = 'text-danger fw-bold';
            } else if (strength <= 4) {
                strengthMessage.textContent = 'Medium strength';
                strengthMessage.className = 'text-warning fw-bold';
            } else {
                strengthMessage.textContent = 'Strong password';
                strengthMessage.className = 'text-success fw-bold';
                validStrength = true;
            }

            if (!confirmPwd) {
                matchMessage.textContent = '';
            } else if (pwd === confirmPwd) {
                matchMessage.textContent = 'Passwords match';
                matchMessage.className = 'text-success fw-bold';
            } else {
                matchMessage.textContent = 'Passwords do not match';
                matchMessage.className = 'text-danger fw-bold';
            }

            // Enable submit only if password is strong and matches
            if (validStrength && pwd === confirmPwd) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        password.addEventListener('input', updateStatus);
        confirmPassword.addEventListener('input', updateStatus);
    </script>
</body>
</html>
