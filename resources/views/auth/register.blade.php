<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register | BookNest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

<body>
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 95vh;">
              <!-- Book Icon SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#ea8802" stroke-width="2.2"
                    viewBox="0 0 24 24" width="40" height="40">
                    <path d="M4 6a2 2 0 0 1 2-2h5v16l-1.25-1.17A4 4 0 0 0 6 18H4z" />
                    <path d="M20 6a2 2 0 0 0-2-2h-5v16l1.25-1.17A4 4 0 0 1 18 18h2z" />
                </svg>
                <span style="font-weight: bold; font-size: 1.5rem;">BookNest</span>
        <!-- Card wrapper -->
        <div class="card p-4 shadow" style="max-width: 480px; width: 100%;">
            <div class="brand-logo text-center mb-3">
          
            </div>

            <div class="register-card">
                <div class="register-header text-center">
                    <h2 class="fw-bold mb-1">Create your account</h2>
                    <div class="register-subtext mb-3 ">Join BookNest and start building your personal library</div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col">
                            <input id="first_name" type="text"
                                class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                value="{{ old('first_name') }}" required autocomplete="given-name" autofocus
                                placeholder="First Name">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col">
                            <input id="last_name" type="text"
                                class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                value="{{ old('last_name') }}" required autocomplete="family-name"
                                placeholder="Last Name">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="john@example.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror pr-5" name="password" required
                            autocomplete="new-password" placeholder="Create a strong password">
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"
                            style="position: absolute; right: 16px; top: 13px; cursor:pointer;"></span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password" placeholder="Confirm your password">
                        <span toggle="#password-confirm" class="fa fa-fw fa-eye field-icon toggle-password"
                            style="position: absolute; right: 16px; top: 13px; cursor:pointer;"></span>
                    </div>

                    <div class="mb-2 form-check">
                        <input class="form-check-input" type="checkbox" id="termsCheck" required>
                        <label class="form-check-label" for="termsCheck">
                            I agree to the <a class="terms-link" href="#">Terms of Service</a> and <a
                                class="privacy-link" href="#">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="register-btn w-100">
                        Create Account
                    </button>
                    <div class="mt-3 text-center">
                        <span style="color:#555;">Already have an account? </span>
                        <a href="{{ route('login') }}" class="small-link">Sign in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="{{asset('js/fundamentals.js')}}"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</script>

</html>