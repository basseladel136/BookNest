<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-light">
    <div class="container my-5">
        <!-- Logout Button -->
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-orange w-100">Logout</button>
            </form>
        </div>

        <h1 class="mb-4">Manage Books</h1>
        <p class="text-muted mb-4">Add, edit, and manage your book collection</p>

        <!-- Add Book Form -->
        <form class="bg-white p-4 rounded shadow mb-4" action="{{ route('books.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <h5 class="mb-3">Add New Book</h5>
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="title" class="form-control" placeholder="Enter book title" required>
                </div>

                <div class="col-md-3">
                    <input type="text" name="author" class="form-control" placeholder="Enter author name" required>
                </div>

                <div class="col-md-2">
                    <input type="number" name="price" class="form-control" placeholder="Price (EGP)" required>
                </div>

                <div class="col-md-2">
                    <input type="number" name="sale_price" class="form-control" placeholder="Sale Price (EGP)">
                </div>

                <div class="col-md-2">
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-9">
                    <textarea name="description" class="form-control" placeholder="Enter book description" rows="3"
                        required></textarea>
                </div>

                <div class="col-md-3">
                    <input type="file" name="cover" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-orange w-100">+ Add Book</button>
                </div>
            </div>
        </form>

        <!-- Books Table -->
        <div class="bg-white p-4 rounded shadow mb-4">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Sale</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>
                                @if($book->cover)
                                    <img src="{{ asset('images/' . $book->cover) }}" width="40">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category->name ?? '-' }}</td>
                            <td>{{ $book->price }}</td>
                            <td>{{ $book->sale_price ?? '-' }}</td>
                            <td>{{ Str::limit($book->description, 40) }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-primary mb-1" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#editBook{{ $book->id }}">Edit</button>

                                <!-- Delete Form -->
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Form (Collapsed) -->
                        <tr class="collapse" id="editBook{{ $book->id }}">
                            <td colspan="9">
                                <form class="bg-light p-3 rounded" action="{{ route('books.update', $book->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <input type="text" name="title" class="form-control" value="{{ $book->title }}"
                                                required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="author" class="form-control"
                                                value="{{ $book->author }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="price" class="form-control"
                                                value="{{ $book->price }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="sale_price" class="form-control"
                                                value="{{ $book->sale_price }}">
                                        </div>
                                        <div class="col-md-2">
                                            <select name="category_id" class="form-control" required>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-9">
                                            <textarea name="description" class="form-control" rows="2"
                                                required>{{ $book->description }}</textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="file" name="cover" class="form-control" accept="image/*">
                                            @if($book->cover)
                                                <img src="{{ asset('images/' . $book->cover) }}" width="60" class="mt-2">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-warning w-100">Update Book</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No books found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
