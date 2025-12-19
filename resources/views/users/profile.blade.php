<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile | BookNest</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
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
                            <a class="dropdown-item" href="{{ route('users.edit') }}">
                                <i class="bi bi-pencil me-2"></i>Edit Profile
                            </a>
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


    <!-- CONTENT -->
    <div class="container py-5">
        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-lg-4">
                <div class="card shadow-sm p-4 text-center">
                    <div class="profile-avatar mb-3">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                    </div>

                    <h3 class="fw-bold mb-1">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </h3>

                    <p class="text-muted mb-4">Book Enthusiast</p>

                    <a href="{{ route('users.edit') }}" class="btn btn-warning text-white w-100 mb-4">
                        <i class="bi bi-pencil me-1"></i> Edit Profile
                    </a>

                    <div class="text-start">
                        <p class="fw-semibold mb-1">
                            <i class="bi bi-envelope me-2"></i>Email
                        </p>
                        <p class="text-muted">{{ $user->email }}</p>

                        <p class="fw-semibold mb-1">
                            <i class="bi bi-telephone me-2"></i>Phone
                        </p>
                        <p class="text-muted">{{ $user->phone ?? 'not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-8">

                <!-- ABOUT -->
                <div class="card shadow-sm p-4 mb-4">
                    <h4 class="fw-bold mb-3">About Me</h4>
                    <p class="text-muted mb-0">
                        {{ $user->about ?? 'Passionate reader with a love for mystery novels and fantasy worlds.' }}
                    </p>
                </div>

                <!-- STATS -->
                <div class="card shadow-sm p-4 mb-4">
                    <h4 class="fw-bold mb-4">Reading Statistics</h4>
                    <div class="row text-center g-3">
                        <div class="col-md-4">
                            <div class="stat-box">
                                <div class="stat-number">{{ $user->books_read ?? 24 }}</div>
                                <div class="text-muted">Books Read</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-box">
                                <div class="stat-number">{{ $user->currently_reading ?? 8 }}</div>
                                <div class="text-muted">Currently Reading</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-box">
                                <div class="stat-number">{{ $user->want_to_read ?? 42 }}</div>
                                <div class="text-muted">Want to Read</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GENRES -->
                <div class="card shadow-sm p-4">
                    <h5>Favorite Genres:</h5>
                    <p>
                        @if(!empty($user->favorite_genres))
                            {{ implode(', ', $user->favorite_genres) }}
                        @else
                            No favorite genres selected
                        @endif
                    </p>

                </div>
            </div>

        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
