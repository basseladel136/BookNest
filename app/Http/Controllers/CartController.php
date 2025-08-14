<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // تأكد من استدعاء موديل الكتاب
use App\Models\Checkout;
use App\Models\VisaDetail;

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
     * إضافة منتج إلى عربة التسوق
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
     * تحديث كمية المنتج
     */
    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Cart updated successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    /**
     * حذف منتج من العربة
     */
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Book removed from cart successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
    public function checkoutView()
    {
        return view('cart.checkout');
    }
    // app/Http/Controllers/CartController.php

    public function process(Request $request)
    {
        // 1- validation
        $validatedData = $request->validate(
            [
                'first_name'     => 'required|string|max:255',
                'last_name'      => 'required|string|max:255',
                'email'          => 'required|email|max:255',
                'phone_number'   => 'required|string|max:20',
                'address'        => 'required|string|max:255',
                'city'           => 'required|string|max:100',
                'zip_code'       => 'required|string|max:20',
                'payment_method' => 'required|in:cod,paypal,visa_card',
                'card_number'      => 'required_if:payment_method,visa_card',
                'card_holder_name'  => 'required_if:payment_method,visa_card',
                'expiry_date'      => 'required_if:payment_method,visa_card',
                'cvv'              => 'required_if:payment_method,visa_card',
            ],
            [
                'required' => 'هذا الحقل مطلوب.',
                'required_if' => 'مطلوب عند اختيار الدفع بالفيزا.',
                'email' => 'يرجى كتابة بريد إلكتروني صحيح.',
            ]
        );
        // check if order already exists for same email (you can use phone_number too or both)
        $exists = \App\Models\Checkout::where('email', $validatedData['email'])
            ->where('phone_number', $validatedData['phone_number'])
            ->first();

        if ($exists) {
            // لو فيه أوردر بنفس الداتا
            return back()->withInput()->with('error', 'يوجد بالفعل طلب بنفس بيانات العميل.');
        }
        // 2- حفظ البيانات في الداتابيز
        $checkout = new \App\Models\Checkout();
        $checkout->first_name = $validatedData['first_name'];
        $checkout->last_name = $validatedData['last_name'];
        $checkout->email = $validatedData['email'];
        $checkout->phone_number = $validatedData['phone_number'];
        $checkout->address = $validatedData['address'];
        $checkout->city = $validatedData['city'];
        $checkout->zip_code = $validatedData['zip_code'];
        $checkout->payment_method = $validatedData['payment_method'];
        $checkout->save();



        // 3- رسالة نجاح وتوجيه
        return redirect()->route('home')->with('success', 'تم طلب الأوردر بنجاح!');
    }
    public function processCheckout(Request $request)
    {
        // معالجة الدفع هنا
        $paymentMethod = $request->input('payment_method');
        // ...
        if ($paymentMethod === 'visa') {
            // معالجة دفع فيزا
            $cardNumber = $request->input('card_number');
            $expirationDate = $request->input('expiration_date');
            $cvv = $request->input('cvv');
            // ...
        } elseif ($paymentMethod === 'paypal') {
            // معالجة دفع بايبال
            // ...
        } elseif ($paymentMethod === 'cod') {
            // معالجة دفع نقدي عند التسليم
            // ...
        }
        // ...
    }
}
