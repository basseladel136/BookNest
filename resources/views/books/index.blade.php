<!DOCTYPE html>
<html>

<head>
    <title>Home | BookNest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav class="navbar navbar-light bg-white border-bottom py-1">
        <div class="container">
            <!-- Logo + Site Name -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#EA8802"
                    stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M4 6a2 2 0 0 1 2-2h5v16l-1.25-1.17A4 4 0 0 0 6 18H4z" />
                    <path d="M20 6a2 2 0 0 0-2-2h-5v16l1.25-1.17A4 4 0 0 1 18 18h2z" />
                </svg>
                <span class="fw-bold fs-4 ms-2">BookNest</span>
            </a>

            <!-- Search box -->
            <form method="GET" action="{{ route('books.index') }}" class="d-flex flex-grow-1 mx-3"
                style="max-width:500px">
                <input id="bookSearch" class="form-control border-warning bg-light" type="search" name="search"
                    value="{{ request('search') }}" placeholder="Search books, authors..." aria-label="Search">
                <button class="btn btn-warning ms-2" type="submit">Search</button>
            </form>

            <!-- Nav Links and Buttons -->
            <ul class="navbar-nav flex-row align-items-center gap-2">
                @guest
                    <li class="nav-item d-flex align-items-center">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-person me-1" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            <path fill-rule="evenodd" d="M8 9a5 5 0 0 0-5 5v1h10v-1a5 5 0 0 0-5-5z" />
                        </svg>
                        <a class="nav-link px-1" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning text-white fw-bold"
                            style="background:#F2931C;border:none;padding:.28rem .6rem;border-width:2px"
                            href="{{ route('register') }}">Sign Up</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-warning" type="submit">Logout</button>
                        </form>
                    </li>
                @endauth

                <li class="nav-item ms-2">
                    <a class="btn btn-outline-warning" style="padding:.28rem .6rem;border-width:2px"
                        href="{{ route('cart.index') }}">
                        <svg width="20" height="20" fill="#F2931C" class="bi bi-cart" viewBox="0 0 16 16">
                            <path
                                d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 5H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 14H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zm3.14 5l1.25 6.607A.5.5 0 0 0 4.86 13h7.278a.5.5 0 0 0 .49-.393L14.89 6H3.14z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!--=============== CATEGORIES BAR ===============-->
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1 class="fw-bold display-5 mb-3">Discover Your Next Great Read</h1>
            <p class="lead text-muted mb-4">
                From bestsellers to hidden gems, find the perfect story for every mood<br>
                in our carefully curated collection.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-4" id="category-filter">
                <a href="{{ route('books.index') }}"
                    class="btn px-4 fw-semibold category-btn {{ !request('category') ? 'active-category' : '' }}">
                    All Books
                </a>
                <a href="{{ route('books.index', ['category' => 'Fantasy']) }}"
                    class="btn px-4 fw-semibold category-btn {{ request('category') == 'Fantasy' ? 'active-category' : '' }}">
                    Fantasy
                </a>
                <a href="{{ route('books.index', ['category' => 'Horror']) }}"
                    class="btn px-4 fw-semibold category-btn {{ request('category') == 'Horror' ? 'active-category' : '' }}">
                    Horror
                </a>
                <a href="{{ route('books.index', ['category' => 'Mystery']) }}"
                    class="btn px-4 fw-semibold category-btn {{ request('category') == 'Mystery' ? 'active-category' : '' }}">
                    Mystery
                </a>
                <a href="{{ route('books.index', ['category' => 'Dystopian Fiction']) }}"
                    class="btn px-4 fw-semibold category-btn {{ request('category') == 'Dystopian Fiction' ? 'active-category' : '' }}">
                    Dystopian Fiction
                </a>
                <a href="{{ route('books.index', ['category' => 'Science Fiction']) }}"
                    class="btn px-4 fw-semibold category-btn {{ request('category') == 'Science Fiction' ? 'active-category' : '' }}">
                    Science Fiction
                </a>
            </div>
        </div>

        <div class="row">
            @foreach($books as $book)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($book->cover) }}" class="card-img-top" style="height: 250px; object-fit: cover;"
                            alt="{{ $book->title }}">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $book->title }}</h5>
                            <p class="card-text text-muted mb-2">by {{ $book->author }}</p>
                            <p class="card-text mb-3">{{ $book->description }}</p>

                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-star text-warning me-1"></i>
                                <span class="fw-bold me-1">{{ $book->rating }}</span>
                                <small class="text-muted">({{ $book->reviews_count }} reviews)</small>
                            </div>

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
            @endforeach
        </div>
    </div>

    <script src="{{ asset('js/fundamentals.js') }}"></script>
</body>

</html>