<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>

<body>
    {{-- New crusade tour form --}}
    <form action="{{ route('crusade-tour.store') }}" method="POST">
        @csrf
        <input type="text" name="slug">
        <x-error name="slug" />
        <button type="submit">Valider</button>
    </form>
</body>

</html>
