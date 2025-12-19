<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Orders | BookNest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-yellow-50">




    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between max-w-6xl">

            {{-- Logo --}}
            <a href="{{ route('books.index') }}" class="flex items-center gap-2 text-black-600 font-bold text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#EA8802"
                    stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M4 6a2 2 0 0 1 2-2h5v16l-1.25-1.17A4 4 0 0 0 6 18H4z" />
                    <path d="M20 6a2 2 0 0 0-2-2h-5v16l1.25-1.17A4 4 0 0 1 18 18h2z" />
                </svg>
                <span class="fw-bold fs-4 ms-2">BookNest</span>
            </a>

            {{-- Search --}}
            <form method="GET" action="{{ route('books.index') }}" class="flex-1 mx-6 max-w-2xl">
                <div class="flex gap-2">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search books, authors..."
                        class="flex-1 px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300">
                    <select name="category_id"
                        class="px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-md hover:bg-orange-600">Search</button>
                </div>
            </form>

            {{-- User & Cart --}}
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 flex items-center gap-1">
                        <i class="fas fa-user"></i> Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-3 py-1 bg-orange-500 text-white font-semibold rounded-md hover:bg-orange-600">Sign
                        Up</a>
                @endguest

                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                            <i class="fas fa-user-circle text-xl"></i> {{ Auth::user()->first_name }}
                            {{ Auth::user()->last_name }}
                        </button>
                        {{-- Dropdown --}}
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-all">
                            <a href="{{ route('users.profile') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">View Profile</a>
                            <a href="{{ route('users.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit
                                Profile</a>
                            
                            <a href="{{ route('cart.index') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Cart</a> <!-- Cart added -->
                            <hr class="border-gray-200 my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth

            </div>

        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container mx-auto px-4 py-8 max-w-6xl">

        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Orders</h1>
        <p class="text-gray-500 mb-6">Track and manage your book orders</p>

        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">

                    <div class="flex items-start justify-between mb-4 pb-4 border-b border-gray-200">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                </h3>
                                <div class="flex items-center gap-2 text-green-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                        <circle cx="12" cy="12" r="9" />
                                    </svg>
                                    <span class="text-sm font-medium">Delivered</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">
                                Order placed: {{ $order->checkout_date->format('d M, Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1">Payment</p>
                            <p class="text-xl font-bold text-orange-600">{{ strtoupper($order->payment_method) }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3 mb-4">
                        @foreach($order->books as $book)
                            <div class="flex items-center justify-between py-2">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $book->title }}</p>
                                    <p class="text-sm text-gray-500">by {{ $book->author }}</p>
                                </div>
                                <p class="font-medium text-gray-900">
                                    ${{ number_format($book->pivot->quantity * $book->price, 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button class="flex-1 border border-gray-300 rounded-md py-2 text-sm hover:bg-gray-50">
                            Track Order
                        </button>
                        <button class="flex-1 border border-gray-300 rounded-md py-2 text-sm hover:bg-gray-50">
                            View Details
                        </button>
                    </div>

                </div>
            @empty
                <p class="text-gray-500">You have no orders yet.</p>
            @endforelse
        </div>

    </main>

</body>

</html>
