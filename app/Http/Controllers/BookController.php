<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $books = Book::when($category, function ($query) use ($category) {
            return $query->where('category', $category);
        })->when($search, function ($query) use ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        })->get();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'author' => 'required',
            'price' => 'required|numeric',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->price = $request->price;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $book->image = $imageName;
        }

        $book->save();

        return redirect()->route('books.index');
    }

    public function show($id)
    {
        $book = Book::find($id);
        return view('books.show', compact('book'));
    }

    public function edit($id)
    {
        $book = Book::find($id);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'image',
            'description' => 'required',
            'author' => 'required',
            'price' => 'required|numeric',
        ]);

        $book = Book::find($id);
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->price = $request->price;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $book->image = $imageName;
        }

        $book->save();

        return redirect()->route('books.index');
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        return redirect()->route('books.index');
    }
}
