<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CartController extends Controller
{
    /**
     * عرض صفحة العربة
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += ($item['sale_price'] ?? $item['price']) * $item['quantity'];
        }


        return view('cart.cart', compact('cartItems', 'subtotal'));
    }

    /**
     * إضافة كتاب للعربة
     */
    public function add(Request $request, Book $book)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$book->id])) {
            $cart[$book->id]['quantity']++;
        } else {
            $cart[$book->id] = [
                'title' => $book->title,
                'author' => $book->author,
                'quantity' => 1,
                'price' => $book->price,
                'sale_price' => $book->sale_price,
                'cover' => $book->cover
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Book added to cart successfully!');
    }

    /**
     * تحديث كمية كتاب بالعربة
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong.');
    }

    /**
     * إزالة كتاب من العربة
     */
    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:books,id'
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Book removed from cart successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong.');
    }

    /**
     * عرض صفحة checkout
     */
    public function checkoutView()
    {
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        return view('cart.checkout', compact('cartItems'));
    }

    /**
     * معالجة checkout
     */
    public function processCheckout(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone_number'     => 'required|string|max:20',
            'address'          => 'required|string|max:255',
            'city'             => 'required|string|max:100',
            'zip_code'         => 'required|string|max:20',
            'payment_method'   => 'required|in:cod,paypal,visa_card',

            'card_number'      => 'required_if:payment_method,visa_card',
            'card_holder_name' => 'required_if:payment_method,visa_card',
            'expiry_date'      => 'required_if:payment_method,visa_card',
            'cvv'              => 'required_if:payment_method,visa_card',
        ]);

        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        DB::transaction(function () use ($validatedData, $cartItems) {

            $checkouts = new Checkout();
            $checkouts->first_name     = $validatedData['first_name'];
            $checkouts->last_name      = $validatedData['last_name'];
            $checkouts->email          = $validatedData['email'];
            $checkouts->phone_number   = $validatedData['phone_number'];
            $checkouts->address        = $validatedData['address'];
            $checkouts->city           = $validatedData['city'];
            $checkouts->zip_code       = $validatedData['zip_code'];
            $checkouts->payment_method = $validatedData['payment_method'];

            if (Auth::check()) {
                $checkouts->user_id = Auth::id();
            }

            // 💥 أهم سطر في الدنيا
            $checkouts->checkout_date = now();

            $checkouts->save();

            // attach الكتب مع الكميات
            foreach ($cartItems as $bookId => $item) {
                $checkouts->books()->attach($bookId, [
                    'quantity' => $item['quantity']
                ]);
            }
        });

        session()->forget('cart');

        return redirect()->route('books.index')->with('success', 'Order placed successfully!');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
    /**
     * عرض صفحة My Orders
     */
    public function myOrders()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Please log in to view your orders.');
        }

        // جلب كل الأوردرات الخاصة بالمستخدم
        $orders = Checkout::where('user_id', $user->id)
            ->with('books') // جلب الكتب المرتبطة بكل أوردر
            ->orderBy('checkout_date', 'desc')
            ->get();
        $categories = Category::all();
        return view('cart.my_order', compact('orders', 'categories'));
    }
}
