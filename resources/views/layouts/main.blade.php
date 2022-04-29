<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- imoort app.css --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')

    <title>Ogun state crusade testimony</title>
    <style>
        .main-side {
            background: linear-gradient(178.89deg, #226091 -9.6%, #507DA0 0.42%, rgba(196, 196, 196, 0) 46.37%);
            height: 100vh;
        }

        /* align center */
        .icon {

            /*             margin-top: 10%; */
        }

        .main-button {
            background: #226091;
            border-radius: 5px;
            color: white;
            width: 207px;
        }

        .main-button:hover {

            color: yellow;
        }

        a {
            text-decoration: none;
            color: black;
        }

        .mob-menu div a {
            color: white;
            font-weight: bold;
            text-decoration: underline;
            text-decoration-style: solid;
        }

        .menu div a {
            color: white;
            font-weight: bold;
        }

        .mob-menu{
            position: absolute;
            top: 0;
            margin-top: 10%
        }



        /*  @media only screen and (max-width=600px) {
             .center-on-mobile {
                text-align: center !important;

            }
        } */

    </style>
</head>

<body class="container-fluid">
    <div class="row">
        <div class="col-md-6  main-side d-flex flex-column justify-content-center align-items-center ">
            @if (!request()->routeIs('home'))
                <div class="d-none d-md-flex flex-column mt-3" style="position: absolute; top:0">
                    <div class="row align-self-center menu">
                        <div class="col-md-auto">
                            <a href="#">Contact us</a>
                        </div>
                        <div class="col-md-auto">
                             <a href="https://www.youtube.com/c/DCLMHQ" target="_blank">Go live</a>
                        </div>
                        <div class="col-md-auto">
                            <a href="{{route('testimony.show')}}">Testify</a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex d-md-none gap-4 mob-menu" >
                <div class="col-md-auto">
                    <a href="https://dclm.org/contact/" target="_blank">Contact us</a>
                </div>
                <div class="col-md-auto">
                     <a href="https://www.youtube.com/c/DCLMHQ" target="_blank">Go live</a>
                </div>
                <div class="col-md-auto">
                    <a href="{{route('testimony.show')}}#testimony-section">Testify</a>
                </div>
            </div>
            <img class="icon img-fluid" width="500" src="{{ asset('images/icon.png') }}" alt="">
            @if (!request()->routeIs('thanks'))
                <img width="200" class="img-fluid" src="{{ asset('images/logo.png') }}" alt="">
            @endif


        </div>

        <div class="col-md-6  align-self-center">

            @yield("content")

        </div>


    </div>

    @stack('scripts')
</body>

</html>
