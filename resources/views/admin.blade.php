<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h2>Admin Panel</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        <label>Title:</label>
        <input type="text" name="title" required><br><br>

        <label>Category:</label>
        <input type="text" name="category" required><br><br>

        <label>Solves:</label>
        <input type="number" name="solves" required><br><br>

        <button type="submit">Add Challenge</button>
    </form>
</body>
</html>
