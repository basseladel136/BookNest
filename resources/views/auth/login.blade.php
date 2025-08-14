<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BookNest - Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center bg-light p-3">

        <!-- Logo -->
        <div class="d-flex align-items-center justify-content-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#ea8802" stroke-width="2.2" viewBox="0 0 24 24"
                style="width:28px;height:28px;">
                <path d="M4 6a2 2 0 0 1 2-2h5v16l-1.25-1.17A4 4 0 0 0 6 18H4z" />
                <path d="M20 6a2 2 0 0 0-2-2h-5v16l1.25-1.17A4 4 0 0 1 18 18h2z" />
            </svg>
            <span style="color: black; font-weight: bold; font-size: 1.5rem; margin-left: 7px;">BookNest</span>
        </div>

        <!-- Card -->
        <div class="bg-white p-4 p-md-5 rounded shadow-sm main-card w-100" style="max-width: 500px;">
            <h2 class="fw-bold text-center">Welcome back</h2>
            <p class="text-center text-muted mb-4" style="font-size: 0.98rem;">
                Sign in to your account to continue your reading journey
            </p>

            {{-- عرض رسالة خطأ تسجيل الدخول --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops!</strong> Your credentials are incorrect.
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                        autofocus required>
                </div>
                <div class="mb-1">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter your password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()"
                            tabindex="-1">
                            <span class="bi bi-eye" id="toggleIcon"></span>
                        </button>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="link-orange" style="font-size: 0.97rem;">Forgot
                        password?</a>
                </div>
                <button type="submit" class="btn btn-orange w-100 fw-semibold">Sign In</button>
            </form>

            <div class="text-center mt-4">
                <span>Don't have an account?</span>
                <a href="{{ route('register') }}" class="fw-semibold link-orange">Sign up</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/fundamentals.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>

</body>

</html>