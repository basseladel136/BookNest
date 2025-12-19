<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'cover' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews_count' => 'nullable|integer|min:0',
        ]);

        $book = Book::create($data);

        return response()->json($book, 201);
    }


    public function show(Book $book)
    {
        return $book;
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'cover' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews_count' => 'nullable|integer|min:0',
        ]);

        $book->update($data);

        return response()->json($book);
    }


    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, 204);
    }
    public function __construct()
{
    $this->middleware(['auth:sanctum', 'admin']);
}

}
