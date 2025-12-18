<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile | BookNest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>My Profile</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>First Name:</strong> {{ $user->first_name }}</li>
            <li class="list-group-item"><strong>Last Name:</strong> {{ $user->last_name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        </ul>

        <a href="{{ route('users.edit') }}" class="btn btn-warning">Edit Profile</a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </div>
</body>

</html>
