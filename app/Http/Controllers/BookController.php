<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->input('category_id');
        $search = $request->input('search');

        $query = Book::with('category');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books = $query->paginate(12)->withQueryString();

        $recommended = $categoryId
            ? Book::where('category_id', $categoryId)->whereNotIn('id', $books->pluck('id'))->take(5)->get()
            : Book::latest()->whereNotIn('id', $books->pluck('id'))->take(5)->get();

        $categories = Category::all();

        return view('books.index', compact(
            'books',
            'categories',
            'recommended',
            'categoryId',
            'search'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string',
            'author'      => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'sale_price'  => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $book = new Book();
        $book->title       = $request->title;
        $book->author      = $request->author;
        $book->description = $request->description;
        $book->price       = $request->price;
        $book->sale_price  = $request->sale_price;
        $book->category_id = $request->category_id;

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $book->cover = $filename; // يخزن الاسم فقط
        }

        $book->save();

        return redirect()
            ->route('admin.books')
            ->with('success', 'Book created successfully');
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
            'title'       => 'required|string',
            'author'      => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'sale_price'  => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $book = Book::findOrFail($id);

        $book->title       = $request->title;
        $book->author      = $request->author;
        $book->description = $request->description;
        $book->price       = $request->price;
        $book->sale_price  = $request->sale_price;
        $book->category_id = $request->category_id;

        if ($request->hasFile('cover')) {
            // حذف القديم لو موجود
            $oldPath = public_path('images/' . $book->cover);
            if ($book->cover && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $book->cover = $filename;
        }

        $book->save();

        return redirect()
            ->route('admin.books')
            ->with('success', 'Book updated successfully');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover) {
            $oldPath = public_path('images/' . $book->cover);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $book->delete();

        return redirect()
            ->route('admin.books')
            ->with('success', 'Book deleted successfully');
    }
}
