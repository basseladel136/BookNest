<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | BookNest</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!--=============== NAVBAR ===============-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('books.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#EA8802"
                    stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M4 6a2 2 0 0 1 2-2h5v16l-1.25-1.17A4 4 0 0 0 6 18H4z" />
                    <path d="M20 6a2 2 0 0 0-2-2h-5v16l1.25-1.17A4 4 0 0 1 18 18h2z" />
                </svg>
                <span class="fw-bold fs-4 ms-2">BookNest</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Back to Cart</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!--=============== CHECKOUT FORM ===============-->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">Shipping Information & Payment Method</h3>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-warning">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name:</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control"
                                        value="{{ old('first_name') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name:</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control"
                                        value="{{ old('last_name') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number:</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control"
                                    value="{{ old('phone_number') }}">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" id="address" name="address" class="form-control"
                                    value="{{ old('address') }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City:</label>
                                    <input type="text" id="city" name="city" class="form-control"
                                        value="{{ old('city') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="zip_code" class="form-label">ZIP Code:</label>
                                    <input type="text" id="zip_code" name="zip_code" class="form-control"
                                        value="{{ old('zip_code') }}">
                                </div>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod"
                                    checked>
                                <label class="form-check-label" for="cod">
                                    <i class="fas fa-money-bill-wave me-2"></i> Pay on Delivery
                                    <small class="text-muted d-block">Pay when your order arrives</small>
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal"
                                    value="paypal">
                                <label class="form-check-label" for="paypal">
                                    <i class="fab fa-paypal me-2"></i> PayPal
                                    <small class="text-muted d-block">Pay securely with PayPal</small>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-warning w-100">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!--=============== ORDER SUMMARY ===============-->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">Order Summary</h3>
                        @php
                            $cartItems = session()->get('cart', []);
                            $subtotal = 0;
                            foreach ($cartItems as $item) {
                                $subtotal += $item['price'] * $item['quantity'];
                            }
                        @endphp
                        @if(!empty($cartItems))
                            @foreach($cartItems as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $item['title'] }} (x{{ $item['quantity'] }})</span>
                                    <span>${{ $item['price'] * $item['quantity'] }}</span>
                                </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span>${{ $subtotal }}</span>
                            </div>
                        @else
                            <p class="text-muted">Your cart is empty.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
