<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart | BookNest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="/">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#ea8802" stroke-width="2.2"
                    viewBox="0 0 24 24">
                    <path d="M4 6a2 2 0 0 1 2-2h5v16l-1.25-1.17A4 4 0 0 0 6 18H4z" />
                    <path d="M20 6a2 2 0 0 0-2-2h-5v16l1.25-1.17A4 4 0 0 1 18 18h2z" />
                </svg>
                <span>BookNest</span>
            </a>
            <a href="/" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Continue Shopping
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="fw-bold mb-4">Shopping Cart</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(!empty($cartItems))
            <div class="row">
                <!-- Items Column -->
                <div class="col-lg-8">
                    @foreach($cartItems as $id => $details)
                        <div class="card cart-item-card mb-3 p-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-2 text-center">
                                    <img src="{{ asset($details['cover']) }}" class="img-fluid rounded"
                                        alt="{{ $details['title'] }}"
                                        style="height: 100px; width: auto; max-width: 70px; object-fit: cover;">
                                </div>
                                <div class="col-md-5">
                                    <div class="card-body py-0">
                                        <h5 class="card-title fw-bold mb-1">{{ $details['title'] }}</h5>
                                        <p class="card-text text-muted mb-2">by {{ $details['author'] }}</p>
                                        <p class="card-text fw-bold" style="color:#d97706;">
                                            ${{ number_format($details['price'], 2) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex justify-content-center align-items-center">
                                    <form action="{{ route('cart.update') }}" method="POST"
                                        class="d-flex align-items-center quantity-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="button" class="btn btn-light quantity-btn minus-btn">-</button>
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}"
                                            class="form-control quantity-input mx-2" min="1">
                                        <button type="button" class="btn btn-light quantity-btn plus-btn">+</button>
                                    </form>
                                </div>
                                <div class="col-md-2 text-center text-md-end">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="btn btn-link text-danger remove-btn p-0">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Summary Column -->
                <div class="col-lg-4">
                    <div class="card summary-card p-4">
                        <h4 class="fw-bold mb-4">Order Summary</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Items ({{ count($cartItems) }})</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping</span>
                            <span class="text-success fw-semibold">Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                            <span>Total</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <a href="{{ route('cart.checkout') }}">Proceed to Checkout</a>
                        <a href="/" class="btn btn-warning w-100">Continue Shopping</a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card empty-cart-card text-center p-5">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#ced4da" class="bi bi-book"
                                viewBox="0 0 16 16">
                                <path
                                    d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.893zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.893c-.885-.37-2.154-.769-3.388-.893-1.33-.134-2.458.063-3.112.752z" />
                            </svg>
                        </div>
                        <h3 class="fw-bold">Your cart is empty</h3>
                        <p class="text-muted">Looks like you haven't added any books yet.</p>
                        <div class="mt-3">
                            <a href="/" class="btn btn-orange" style="padding: 10px 30px;">Browse Books</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
<script src="{{asset('js/fundamentals.js')}}"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</script>

</html>