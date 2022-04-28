<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- imoort app.css --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Ogun state crusade testimony</title>
    <style>
        .main-side {
            background: linear-gradient(178.89deg, #226091 -9.6%, #507DA0 0.42%, rgba(196, 196, 196, 0) 46.37%);
            height: 100vh;
        }

        /* align center */
        .icon {

            margin-top: 10%;
        }

        .main-button {
            background: #226091;
            border-radius: 5px;
            color: white;
            width : 207px;
        }

        a{
            text-decoration: none;
            color: black;
        }

    </style>
</head>

<body class="container-fluid">
    <div class="row">
        <div class="col-md-6 main-side">

            <div class="justify-center align-center text-center">
                <img class="icon" width="500" src="{{ asset('images/icon.png') }}" alt="">
                <img src="{{ asset('images/logo.png') }}" alt="">

            </div>


        </div>

        <div class="col-md-6  align-self-center">

            @yield("content")

        </div>


    </div>
</body>

</html>
