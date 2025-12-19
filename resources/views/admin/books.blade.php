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
        <h1 class="mb-4">Manage Books</h1>
        <p class="text-muted mb-4">Add, edit, and manage your book collection</p>

        <!-- Form لإضافة كتاب جديد -->
        <form id="bookForm" class="bg-white p-4 rounded shadow mb-4">
            <h5 class="mb-3">Add New Book</h5>
            <input type="hidden" id="book_id">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" id="title" class="form-control" placeholder="Enter book title" required>
                </div>
                <div class="col-md-3">
                    <input type="text" id="author" class="form-control" placeholder="Enter author name" required>
                </div>
                <div class="col-md-2">
                    <input type="number" id="price" class="form-control" placeholder="Price (EGP)" required>
                </div>
                <div class="col-md-2">
                    <input type="number" id="sale_price" class="form-control" placeholder="Sale Price (EGP)">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-orange w-100">+ Add Book</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <textarea id="description" class="form-control" placeholder="Enter book description" rows="3"
                        required></textarea>
                </div>
            </div>
        </form>

        <!-- جدول الكتب -->
        <div class="bg-white p-4 rounded shadow">
            <table class="table table-bordered table-hover" id="booksTable">
                <thead class="table-light">
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
                <tbody>
                    <!-- مثال صف -->
                    <tr>
                        <td>1</td>
                        <td>Book Title</td>
                        <td>Author Name</td>
                        <td>200</td>
                        <td>180</td>
                        <td>This is a sample description.</td>
                        <td>
                            <button class="btn btn-sm btn-primary me-1">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    <!-- صفوف ديناميكية هتتضاف من DB بواسطة JS -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/fundamentals.js') }}"></script>

    <style>
        .btn-orange {
            background-color: #ea8802;
            color: white;
        }

        .btn-orange:hover {
            background-color: #d77f00;
        }
    </style>
</body>

</html>
