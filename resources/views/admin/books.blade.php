<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4">Admin - Manage Books</h1>

        <!-- Form لإضافة كتاب جديد -->
        <form id="bookForm" class="mb-4">
            <input type="hidden" id="book_id">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" id="title" class="form-control" placeholder="Title" required>
                </div>
                <div class="col-md-3">
                    <input type="text" id="author" class="form-control" placeholder="Author" required>
                </div>
                <div class="col-md-2">
                    <input type="number" id="price" class="form-control" placeholder="Price" required>
                </div>
                <div class="col-md-2">
                    <input type="number" id="sale_price" class="form-control" placeholder="Sale Price">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Save Book</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <input type="text" id="description" class="form-control" placeholder="Description" required>
                </div>
            </div>
        </form>

        <!-- جدول الكتب -->
        <table class="table table-bordered" id="booksTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Sale Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/fundamentals.js') }}"></script>


</body>

</html>
