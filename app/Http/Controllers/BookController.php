<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // الصفحة الرئيسية - عرض كل الكتب + البحث حسب التصنيف أو الاسم
    public function index(Request $request)
    {
        $categoryId = $request->input('category_id');
        $search = $request->input('search');

        $books = Book::with('category')
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->get();

        // Prepare recommendations if search returns empty
        $recommended = collect();
        if ($books->isEmpty()) {
            if ($categoryId) {
                $recommended = Book::where('category_id', $categoryId)->take(5)->get();
            } else {
                $recommended = Book::latest()->take(5)->get();
            }
        }

        $categories = Category::all();
        return view('books.index', compact('books', 'categories', 'recommended'));
    }


    // عرض form إنشاء كتاب جديد
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    // حفظ كتاب جديد
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image',
            'sale_price' => 'nullable|numeric',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->sale_price = $request->sale_price;
        $book->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('books', 'public');
            $book->image = $path;
        }

        $book->save();

        return redirect()->route('books.index');
    }

    // عرض كتاب محدد
    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        return view('books.show', compact('book'));
    }

    // عرض form تعديل كتاب
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    // تحديث كتاب
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image',
            'sale_price' => 'nullable|numeric',
        ]);

        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->sale_price = $request->sale_price;
        $book->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة لو موجودة
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $path = $request->file('image')->store('books', 'public');
            $book->image = $path;
        }

        $book->save();

        return redirect()->route('books.index');
    }

    // حذف كتاب
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();

        return redirect()->route('books.index');
    }

    // بحث + توصيات
    public function search(Request $request)
    {
        $query = $request->input('search');
        $categoryId = $request->input('category_id');

        // جلب الكتب المتوافقة مع البحث
        $books = Book::when($query, function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
                ->orWhere('author', 'like', "%{$query}%");
        })->get();

        $categories = Category::all();

        if ($books->isNotEmpty()) {
            // لو فيه نتائج، عرضها
            return view('books.index', compact('books', 'categories'));
        }

        // لو مفيش نتائج، عرض توصيات
        $recommended = Book::when($categoryId, function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })
            ->take(5)
            ->get();

        return view('books.noresult', compact('recommended', 'query', 'categories'));
    }
}
