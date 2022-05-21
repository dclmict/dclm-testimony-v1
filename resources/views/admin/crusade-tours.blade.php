<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    {{-- all crusade tours --}}

    @foreach ($crusadeTours as $crusadeTour)
        <b>{{ $crusadeTour }}</b>
    @endforeach
</body>

</html>
