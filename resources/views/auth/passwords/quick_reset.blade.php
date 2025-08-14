<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for eye icon and back arrow -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        body {
            background-color: #fcf8f0;
            /* Light orange/beige background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Make sure it takes full viewport height */
            margin: 0;
            padding: 20px;
            /* Add some padding for smaller screens */
        }

        .container {
            /* The main container now only centers the content */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            /* Remove default Bootstrap border */
            border-radius: 15px;
            /* More rounded corners */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            /* Softer shadow */
            width: 100%;
            /* Ensure it takes full width of col-md-6 */
            max-width: 450px;
            /* Limit max width for better appearance */
        }

        .card-header {
            background-color: transparent;
            /* No background for header */
            border-bottom: none;
            /* Remove border from header */
            padding-bottom: 0;
            /* Adjust padding */
            text-align: center;
            color: #333;
            /* Darker text */
            font-weight: bold;
            font-size: 1.8rem;
            /* Larger title */
            padding-top: 30px;
            /* More space at top */
        }

        .card-body {
            padding: 30px;
            /* Uniform padding */
        }

        .subtitle {
            text-align: center;
            color: #6c757d;
            /* Grey text for subtitle */
            margin-bottom: 25px;
            /* Space below subtitle */
            font-size: 0.95rem;
        }

        .form-label {
            color: #333;
            /* Darker labels */
            font-weight: 500;
            /* Slightly bolder labels */
            margin-bottom: 8px;
            /* Space between label and input */
        }

        .form-control {
            border-radius: 8px;
            /* Rounded input fields */
            border: 1px solid #ddd;
            /* Lighter border */
            padding: 12px 15px;
            /* More padding inside inputs */
            font-size: 1rem;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .form-control:focus {
            border-color: #f3b27f;
            /* Orange border on focus */
            box-shadow: 0 0 0 0.25rem rgba(243, 178, 127, 0.25);
            /* Lighter orange shadow on focus */
        }

        .btn-primary {
            background-color: #f3b27f;
            /* Orange button */
            border-color: #f3b27f;
            /* Orange border */
            color: #fff;
            /* White text */
            border-radius: 8px;
            /* Rounded button */
            padding: 12px 20px;
            /* Larger button padding */
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 5px 10px rgba(243, 178, 127, 0.3);
            /* Button shadow */
        }

        .btn-primary:hover {
            background-color: #e0a370;
            /* Slightly darker orange on hover */
            border-color: #e0a370;
            box-shadow: 0 7px 15px rgba(243, 178, 127, 0.4);
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 0.25rem rgba(243, 178, 127, 0.5);
            /* Stronger focus shadow */
        }

        /* Password input with eye icon */
        .password-input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 0.9rem;
            z-index: 10;
            /* Ensure icon is above input field */
        }

        .password-toggle:hover {
            color: #333;
        }

        /* Removed .logo-container specific styles as the new logo div handles its own flex and margin */

        .back-to-sign-in {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 25px;
            /* Space above the link */
            font-size: 0.95rem;
            color: #6c757d;
            /* Grey link color */
            text-decoration: none;
            /* No underline by default */
        }

        .back-to-sign-in:hover {
            color: #f3b27f;
            /* Orange on hover */
            text-decoration: underline;
        }

        .back-to-sign-in .fa-arrow-left {
            margin-right: 8px;
            /* Space between arrow and text */
            font-size: 0.8rem;
        }

        /* Adjustments for messages */
        .alert {
            border-radius: 8px;
            font-size: 0.9rem;
            padding: 12px 20px;
            margin-bottom: 20px;
            /* Space below alerts */
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #badbcc;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- New Logo Section -->
        <div class="d-flex align-items-center justify-content-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#ea8802" stroke-width="2.2" viewBox="0 0 24 24"
                style="width:28px;height:28px;">
                <path d="M4 6a2 2 0 0 1 2-2h5v16l-1.25-1.17A4 4 0 0 0 6 18H4z" />
                <path d="M20 6a2 2 0 0 0-2-2h-5v16l1.25-1.17A4 4 0 0 1 18 18h2z" />
            </svg>
            <span style="color: black; font-weight: bold; font-size: 1.5rem; margin-left: 7px;">BookNest</span>
        </div>

        <div class="row justify-content-center w-100">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">Reset your password</div>
                    <div class="card-body">
                        <p class="subtitle">Enter your email and new password below</p>

                        {{-- عرض رسالة النجاح --}}
                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        {{-- عرض رسائل الأخطاء --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Enter your email" required autofocus>
                            </div>

                            <div class="mb-3 password-input-group">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Enter new password" required>
                                <span class="password-toggle" onclick="togglePasswordVisibility('password', this)">
                                    <i class="far fa-eye"></i>
                                </span>
                            </div>

                            <div class="mb-4 password-input-group">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" placeholder="Confirm new password" required>
                                <span class="password-toggle"
                                    onclick="togglePasswordVisibility('password_confirmation', this)">
                                    <i class="far fa-eye"></i>
                                </span>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
                            </div>
                        </form>

                       

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript for toggling password visibility
        function togglePasswordVisibility(id, iconElement) {
            const input = document.getElementById(id);
            const icon = iconElement.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>