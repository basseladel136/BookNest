<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $books = Book::with('category')
            ->when($category, function ($query) use ($category) {
                return $query->whereHas('category', function ($q) use ($category) {
                    $q->where('name', $category); // ← البحث بالـ name وليس id
                });
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->get();

        $categories = Category::all();

        return view('books.index', compact('books', 'categories'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

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

    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        return view('books.show', compact('book'));
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

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

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();

        return redirect()->route('books.index');
    }

    public function liveSearch(Request $request)
{
    $q = $request->get('q');

    $books = Book::when($q, function ($query, $q) {
            $query->where('title', 'like', $q.'%');
        })
        ->get();

    return view('partials.books_list', compact('books'));
}
}
