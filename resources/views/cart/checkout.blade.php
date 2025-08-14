<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- روابط التنقل -->
                </ul>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Back to Cart</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Checkout</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h3>Shipping Information & Payment Method</h3>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
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
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('checkout.process') }}" method="post">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name:</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name:</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number:</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" id="address" name="address" class="form-control">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City:</label>
                                    <input type="text" id="city" name="city" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="zip_code" class="form-label">ZIP Code:</label>
                                    <input type="text" id="zip_code" name="zip_code" class="form-control">
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod"
                                    checked>
                                <label class="form-check-label" for="cod">
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-money-bill-wave me-2"></i>
                                        Pay on Delivery
                                    </span>
                                    <small class="text-muted d-block">Pay when your order arrives</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal"
                                    value="paypal">
                                <label class="form-check-label" for="paypal">
                                    <span class="d-flex align-items-center">
                                        <i class="fab fa-paypal me-2"></i>
                                        PayPal
                                    </span>
                                    <small class="text-muted d-block">Pay securely with PayPal</small>
                                </label>
                            </div>



                            </label>
                    </div>


                    <button type="submit" id="pay-button" class="btn btn-warning">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <!-- Order Summary -->
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/fundamentals.js')}}"></script>
</body>

</html>