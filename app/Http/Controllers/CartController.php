<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * عرض صفحة عربة التسوق
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('cart.cart', compact('cartItems', 'subtotal'));
    }

    /**
     * إضافة كتاب إلى العربة
     */
    public function add(Request $request, Book $book)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$book->id])) {
            $cart[$book->id]['quantity']++;
        } else {
            $cart[$book->id] = [
                "title" => $book->title,
                "author" => $book->author,
                "quantity" => 1,
                "price" => $book->price,
                "cover" => $book->cover
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Book added to cart successfully!');
    }

    /**
     * تحديث كمية كتاب في العربة
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
            return redirect()->back()->with('success', 'Cart updated successfully');
        }

        return redirect()->back()->with('error', 'Something went wrong');
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
            return redirect()->back()->with('success', 'Book removed from cart successfully');
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }

    /**
     * عرض صفحة checkout
     */
    public function checkoutView()
    {
        return view('cart.checkout');
    }

    /**
     * معالجة checkout
     */
    public function processCheckout(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone_number'   => 'required|string|max:20',
            'address'        => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'zip_code'       => 'required|string|max:20',
            'payment_method' => 'required|in:cod,paypal,visa_card',
            'card_number'      => 'required_if:payment_method,visa_card',
            'card_holder_name' => 'required_if:payment_method,visa_card',
            'expiry_date'      => 'required_if:payment_method,visa_card',
            'cvv'              => 'required_if:payment_method,visa_card',
        ]);

        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        // إنشاء checkout
        $checkout = new Checkout();
        $checkout->first_name = $validatedData['first_name'];
        $checkout->last_name = $validatedData['last_name'];
        $checkout->email = $validatedData['email'];
        $checkout->phone_number = $validatedData['phone_number'];
        $checkout->address = $validatedData['address'];
        $checkout->city = $validatedData['city'];
        $checkout->zip_code = $validatedData['zip_code'];
        $checkout->payment_method = $validatedData['payment_method'];
        if (Auth::check()) {
            $checkout->user_id = Auth::id();
        }
        $checkout->save();

        // ربط الكتب بالـ checkout مع الكمية
        foreach ($cartItems as $bookId => $item) {
            $checkout->books()->attach($bookId, ['quantity' => $item['quantity']]);
        }

        // معالجة الدفع (مبسط)
        if ($validatedData['payment_method'] === 'visa_card') {
            // هنا ممكن تضيف كود الدفع عبر بوابة فيزا
        } elseif ($validatedData['payment_method'] === 'paypal') {
            // كود دفع بايبال
        } elseif ($validatedData['payment_method'] === 'cod') {
            // الدفع عند التسليم
        }

        // مسح العربة بعد الطلب
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}
