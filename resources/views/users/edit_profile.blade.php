<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile | BookNest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
   <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white border-bottom py-2">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('books.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#EA8802"
                stroke-width="2.2" viewBox="0 0 24 24">
                <path d="M4 6a2 2 0 0 1 2-2h5v16l-1.25-1.17A4 4 0 0 0 6 18H4z" />
                <path d="M20 6a2 2 0 0 0-2-2h-5v16l1.25-1.17A4 4 0 0 1 18 18h2z" />
            </svg>
            <span class="fw-bold fs-4 ms-2">BookNest</span>
        </a>

        <!-- Search -->
        <form class="d-none d-lg-flex mx-auto w-50">
            <input class="form-control me-2" type="search" placeholder="Search books, authors...">
            <select class="form-select me-2" style="max-width:160px">
                <option>All Categories</option>
            </select>
            <button class="btn btn-warning text-white">Search</button>
        </form>

        <!-- Right -->
        <div class="d-flex align-items-center gap-3">
            <div class="dropdown">
                <button class="btn btn-link text-decoration-none text-dark fw-semibold dropdown-toggle"
                    data-bs-toggle="dropdown">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="{{ route('users.profile') }}">
                            <i class="bi bi-person me-2"></i>Profile
                        </a>
                    </li>
                    <li>
                      
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart me-2"></i>Cart
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>



<div class="container py-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold">Edit Profile</h1>
            <p class="text-muted mb-0">Update your personal information and preferences</p>
        </div>

        <a href="{{ route('users.profile') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-lg me-1"></i> Cancel
        </a>
    </div>

    <form action="{{ route('users.profile.update') }}" method="POST">
        @csrf

        <div class="row g-4">

            <!-- Left Card -->
            <div class="col-lg-4">
                <div class="card p-4 text-center shadow-sm">
                    <div class="profile-circle mb-3">
                        {{ strtoupper(substr($user->first_name,0,1)) }}{{ strtoupper(substr($user->last_name,0,1)) }}
                    </div>
                    <h5 class="fw-bold">Profile Badge</h5>
                    <p class="text-muted mb-0">Your initials are displayed based on your name</p>
                </div>
            </div>

            <!-- Right Content -->
            <div class="col-lg-8">

                <!-- Personal Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Personal Information</h4>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                       value="{{ old('first_name', $user->first_name) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                                       value="{{ old('last_name', $user->last_name) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>
                </div>

                <!-- About -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3">About Me</h4>
                        <textarea name="about" rows="4" class="form-control">{{ old('about', $user->about) }}</textarea>
                        <small class="text-muted">Write a short bio about yourself</small>
                    </div>
                </div>

                <!-- Genres -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3">Favorite Genres</h4>
                        <p class="text-muted">Select your favorite book genres</p>

                        @php
    $allGenres = ['Mystery','Fantasy','Science Fiction','Historical Fiction','Thriller','Romance','Horror','Biography','Self-Help','Poetry'];
    $userGenres = $user->favorite_genres ?? [];
@endphp

<div class="d-flex flex-wrap gap-2">
    @foreach($allGenres as $genre)
        <label class="genre-btn {{ in_array($genre, $userGenres) ? 'checked' : '' }}">
            <input type="checkbox" name="favorite_genres[]" value="{{ $genre }}"
                   {{ in_array($genre, $userGenres) ? 'checked' : '' }}>
            {{ $genre }}
        </label>
    @endforeach
</div>

                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('users.profile') }}" class="btn btn-outline-secondary px-4">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-warning text-white px-4">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/fundamentals.js') }}"></script>
</body>
<script>
    document.querySelectorAll('.genre-btn').forEach(label => {
        const checkbox = label.querySelector('input[type="checkbox"]');
        label.addEventListener('click', function(e) {
            e.preventDefault(); // لمنع أي تأثير Bootstrap
            checkbox.checked = !checkbox.checked;
            label.classList.toggle('checked', checkbox.checked);
        });
    });
</script>

</html>
