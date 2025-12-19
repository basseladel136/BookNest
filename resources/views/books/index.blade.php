<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | BookNest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!--=============== NAVBAR ===============-->
    <nav class="navbar navbar-light bg-white border-bottom py-1">
        <div class="container">
            <!-- Logo + Site Name -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('books.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#EA8802"
                    stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M4 6a2 2 0 0 1 2-2h5v16l-1.25-1.17A4 4 0 0 0 6 18H4z" />
                    <path d="M20 6a2 2 0 0 0-2-2h-5v16l1.25-1.17A4 4 0 0 1 18 18h2z" />
                </svg>
                <span class="fw-bold fs-4 ms-2">BookNest</span>
            </a>

            <!-- Search box -->
            <div class="d-flex justify-content-center mb-4">
                <form method="GET" action="{{ route('books.index') }}" class="d-flex flex-grow-1 mx-3"
                    style="max-width:600px">
                    <input id="bookSearch" class="form-control border-warning bg-light" type="search" name="search"
                        value="{{ request('search') }}" placeholder="Search books, authors..." aria-label="Search">

                    <select name="category_id" class="form-select border-warning ms-2" style="width:180px;">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-warning ms-2" type="submit">Search</button>
                </form>
            </div>

            <!-- Nav Links and Buttons -->
            <ul class="navbar-nav flex-row align-items-center gap-2">
                @guest
                    <li class="nav-item d-flex align-items-center">
                        <i class="fas fa-user me-1"></i>
                        <a class="nav-link px-1" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning text-white fw-bold"
                            style="background:#F2931C;border:none;padding:.28rem .6rem;border-width:2px"
                            href="{{ route('register') }}">Sign Up</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end floating-dropdown shadow"
                            aria-labelledby="profileDropdown" style="position: absolute; z-index: 1050;">
                            <li><a class="dropdown-item" href="{{ route('users.profile') }}">View Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.edit') }}">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('cart.my_order') }}">My Orders</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth



                <li class="nav-item ms-2">
                    <a class="btn btn-outline-warning" style="padding:.28rem .6rem;border-width:2px"
                        href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart text-warning"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>




    <!--=============== CATEGORIES BAR ===============-->
    <!-- داخل نفس books.index.blade.php -->
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1 class="fw-bold display-5 mb-3">Discover Your Next Great Read</h1>
            <p class="lead text-muted mb-4">
                From bestsellers to hidden gems, find the perfect story for every mood<br>
                in our carefully curated collection.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-4" id="category-filter">
                <a href="{{ route('books.index', ['search' => request('search')]) }}"
                    class="btn px-4 fw-semibold category-btn {{ !request('category_id') ? 'active-category' : '' }}">
                    All Books
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('books.index', ['category_id' => $cat->id, 'search' => request('search')]) }}"
                        class="btn px-4 fw-semibold category-btn {{ request('category_id') == $cat->id ? 'active-category' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Books Grid -->
        <div class="row">
            @forelse($books as $book)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($book->cover ?? 'https://via.placeholder.com/250') }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;" alt="{{ $book->title }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $book->title }}</h5>
                            <p class="card-text text-muted mb-2">by {{ $book->author }}</p>
                            <p class="card-text mb-3">{{ Str::limit($book->description, 100) }}</p>

                            <div class="d-flex align-items-baseline mb-3">
                                @if($book->sale_price)
                                    <h4 class="fw-bold me-2 mb-0 text-dark">${{ $book->sale_price }}</h4>
                                    <small class="text-muted text-decoration-line-through">${{ $book->price }}</small>
                                @else
                                    <h4 class="fw-bold me-2 mb-0">${{ $book->price }}</h4>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn w-100 text-white" style="background-color: #d97706;">
                                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <h5 class="mt-3">No results found for "{{ request('search') }}"</h5>

                    @if($recommended->isNotEmpty())
                        <p class="mt-3 mb-3">But we found some books from the same category:</p>
                        <div class="row">
                            @foreach($recommended as $book)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset($book->cover ?? 'https://via.placeholder.com/250') }}"
                                            class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $book->title }}">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title fw-bold">{{ $book->title }}</h5>
                                            <p class="text-muted mb-2">by {{ $book->author }}</p>
                                            <div class="mt-auto">
                                                <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn w-100 text-white"
                                                        style="background-color: #d97706;">
                                                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Recommendations (لو فيه كتب مشابهة) -->
        @if($recommended->isNotEmpty() && $books->isNotEmpty())
            <div class="mt-5">
                <h5 class="mb-3">You might also like from this category:</h5>
                <div class="row">
                    @foreach($recommended as $book)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="{{ asset($book->cover ?? 'https://via.placeholder.com/250') }}" class="card-img-top"
                                    style="height: 250px; object-fit: cover;" alt="{{ $book->title }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">{{ $book->title }}</h5>
                                    <p class="text-muted mb-2">by {{ $book->author }}</p>
                                    <div class="mt-auto">
                                        <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn w-100 text-white"
                                                style="background-color: #d97706;">
                                                <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <script src="{{ asset('js/fundamentals.js') }}"></script>
</body>

</html>
