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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fe;
        }

        .login-card {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .login-main {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            width: 100%;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        #strengthMessage {
            font-size: 0.85rem;
        }

        .progress {
            height: 5px;
            margin-top: 5px;
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
    </style>
</head>

<body>
    <div class="loader-wrapper" id="loader">
        <div class="loader"><span></span><span></span><span></span></div>
    </div>

    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div class="login-main">
                        <form method="POST" action="{{ route('register') }}" class="theme-form">
                            @csrf

                            <div class="text-center mb-3">
                                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 40px;">
                            </div>

                            <h4 class="text-center">Create Account</h4>
                            <p class="text-center text-muted mb-4">Fill in your details to register</p>

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <!-- First & Last Name -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3 position-relative">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="password" name="password" class="form-control" required minlength="8" oninput="checkStrength(this.value)">
                                    <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                                </div>
                                <div class="progress mt-1">
                                    <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small id="strengthMessage" class="text-muted"></small>
                                @error('password')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="confirm_password" name="password_confirmation" class="form-control" required minlength="8">
                                </div>
                                <small id="matchMessage" class="text-muted"></small>
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Terms -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                                <label class="form-check-label" for="agree_terms">
                                    I agree with the <a href="privacy-policy.html" class="ms-1">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary w-100">Register</button>

                            <!-- Login Link -->
                            <p class="text-center mt-4">
                                Already registered?
                                <a href="{{ route('login') }}" class="text-primary">Sign in</a>
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

    <script>
        // Loader
        window.addEventListener('load', () => {
            document.getElementById('loader').style.display = 'none';
        });

        // Toggle password visibility
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("bi-eye");
            this.classList.toggle("bi-eye-slash");
        });

        // Password strength
        function checkStrength(password) {
            const strengthBar = document.getElementById("strengthBar");
            const strengthMessage = document.getElementById("strengthMessage");

            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[@$!%*?&#]/.test(password)) strength++;

            let color = "danger", width = "25%", text = "Too Weak";
            if (strength === 2) { color = "warning"; width = "50%"; text = "Fair"; }
            else if (strength === 3) { color = "info"; width = "75%"; text = "Good"; }
            else if (strength === 4) { color = "success"; width = "100%"; text = "Strong"; }

            strengthBar.style.width = width;
            strengthBar.className = `progress-bar bg-${color}`;
            strengthMessage.textContent = text;
        }

        // Realtime match password
        const confirmPassword = document.getElementById("confirm_password");
        const matchMessage = document.getElementById("matchMessage");

        function validatePasswordMatch() {
            const pwd = passwordInput.value;
            const confirmPwd = confirmPassword.value;

            if (!confirmPwd) {
                matchMessage.textContent = "";
                return;
            }

            if (pwd === confirmPwd) {
                matchMessage.textContent = "Passwords match ✅";
                matchMessage.className = "text-success";
            } else {
                matchMessage.textContent = "Passwords do not match ❌";
                matchMessage.className = "text-danger";
            }
        }

        passwordInput.addEventListener("input", validatePasswordMatch);
        confirmPassword.addEventListener("input", validatePasswordMatch);

        // Prevent form if passwords don't match
        document.querySelector("form").addEventListener("submit", function (e) {
            if (passwordInput.value !== confirmPassword.value) {
                e.preventDefault();
                matchMessage.textContent = "Passwords do not match ❌";
                matchMessage.className = "text-danger";
                confirmPassword.focus();
            }
        });
    </script>
</body>
</html>
