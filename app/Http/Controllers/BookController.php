<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // الصفحة الرئيسية - عرض الكتب مع فلترة وبحث
    public function index(Request $request)
    {
        $categoryId = $request->input('category_id');
        $search = $request->input('search');

        // query builder
        $query = Book::with('category');

        // فلترة حسب الكاتيجوري
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // بحث حسب title أو author
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // pagination
        $books = $query->paginate(12)->withQueryString();

        // توصيات لو مفيش نتائج
        $recommended = collect();
        if ($books->isEmpty()) {
            if ($categoryId) {
                $recommended = Book::where('category_id', $categoryId)->take(5)->get();
            } else {
                $recommended = Book::latest()->take(5)->get();
            }
        }

        $categories = Category::all();

        return view('books.index', compact('books', 'categories', 'recommended', 'categoryId', 'search'));
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

        $book = new Book($request->only(['title', 'author', 'description', 'price', 'sale_price', 'category_id']));

        if ($request->hasFile('image')) {
            $book->image = $request->file('image')->store('books', 'public');
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    // عرض كتاب محدد
    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        return view('books.show', compact('book'));
    }

    // تعديل كتاب
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
        $book->fill($request->only(['title', 'author', 'description', 'price', 'sale_price', 'category_id']));

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $book->image = $request->file('image')->store('books', 'public');
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    // حذف كتاب
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}

