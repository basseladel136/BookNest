<div class="row">
    @foreach($books as $book)
        <div class="col-md-4 mb-4 book-item"> <!-- أضف class book-item -->
            <div class="card">
                <img src="{{ asset($book->cover) }}" class="card-img-top" style="height: 250px; object-fit: cover;"
                    alt="{{ $book->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text">{{ $book->author }}</p>
                    <p class="card-text">{{ $book->price }}$</p>
                    <p class="card-text"><small class="text-muted">{{ $book->category }}</small></p>
                    <a href="{{ route('books.index', $book->id) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    @endforeach
</div>