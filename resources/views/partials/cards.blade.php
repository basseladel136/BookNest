<div class="row" id="books-container">
    @include('partials.books_list', ['books' => $books])
    @foreach($books as $book)
        <div class="col-md-4 mb-4 book-item">
            <div class="card">
                <img src="{{ asset('images/' . $book->cover) }}" class="card-img-top" alt="{{ $book->title }}">

                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text">{{ $book->author }}</p>
                    <p class="card-text">{{ $book->price }}$</p>
                    <p class="card-text">
                        <small class="text-muted">{{ $book->category->name ?? 'No category' }}</small>
                    </p>
                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

    <script src="{{ asset('js/fundamentals.js') }}"></script>
