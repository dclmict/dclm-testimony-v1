<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="Testify to the greatness and goodness of God through the on-going global crusades" />
    <meta name="keywords"
        content="DCLM, DCLM Webcast, DCLM Testimony, Pastor Kumuyi live, deeperLife, Pastor Kumuyi, Messages, live messages webcast, dclm, #DCLM" />
    {{-- imoort app.css --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dlcmbrand.css') }}">
    

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    @stack('styles')

    <title>DCLM Testimony: May Global Crusade </title>
    <style>
        .main-side {
            background: linear-gradient(178.89deg, #226091 -9.6%, #507DA0 0.42%, rgba(196, 196, 196, 0) 46.37%);
            height: 100vh;
        }

        .main-side-mobile {
            background: linear-gradient(172.76deg, rgba(34, 96, 145, 0.6887) 30.21%, rgba(196, 196, 196, 0) 103.3%);
            filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
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

        .mob-menu {
            position: absolute;
            top: 0;
            margin-top: 10%
        }

        .mob-menu-v2 div a{
            color: orange;
            font-weight: bold;
        }



        /*  @media only screen and (max-width=600px) {
             .center-on-mobile {
                text-align: center !important;

            }
        } */

    </style>
</head>

<body class="container-fluid">
    <div class="row {{request()->routeIs('home')?'d-none':''}} d-md-flex">
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
                            <a href="{{ route('testimony.show') }}">Testify</a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex d-md-none gap-4 mob-menu">
                <div class="col-md-auto">
                    <a href="https://dclm.org/contact/" target="_blank">Contact us</a>
                </div>
                <div class="col-md-auto">
                    <a href="https://www.youtube.com/c/DCLMHQ" target="_blank">Go live</a>
                </div>
                <div class="col-md-auto">
                    <a href="{{ route('testimony.show') }}#testimony-section">Testify</a>
                </div>
            </div>
            <img class="icon img-fluid" width="500" src="{{ asset('images/icon.png') }}" alt="">
            @if (!request()->routeIs('thanks'))
                <img width="200" class="img-fluid" src="{{ asset('images/logo.png') }}" alt="">
            @endif


        </div>

        <div class="col-md-6  align-self-center">

            @yield('content')

        </div>


    </div>
    @if (request()->routeIs('home'))
    <div class="row d-md-none">
        <div class="col-md-12 main-side-mobile">
            <div class="d-flex gap-4 justify-content-center mt-3 mob-menu-v2">
                <div class="col-md-auto">
                    <a href="https://dclm.org/contact/" target="_blank">Contact us</a>
                </div>
                <div class="col-md-auto">
                    <a href="https://www.youtube.com/c/DCLMHQ" target="_blank">Go live</a>
                </div>
                <div class="col-md-auto">
                    <a href="{{ route('testimony.show') }}#testimony-section">Testify</a>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center justify-content-center" style="margin-top:25vh">
                <div>
                    <h1 class="text-center" style="font-size: 20px; color:whitesmoke">TESTIMONY FOR OGUN STATE
                        CRUSADE
                    </h1>
                </div>
                <div class="bg-warning px-2 pt-2" style="opacity: 0.7">
                    <h2 style="font-size: 10px">Testify to the goodness of God</h2>
                </div>
                <img class="icon img-fluid" style="opacity: 0.3" width="500" src="{{ asset('images/icon.png') }}"
                    alt="">

                <div class="mt-5">

                    <a href="{{route('testimony.show')}}#testimony-section" class="btn main-button mb-5">SHARE MY TESTIMONY</a>

                </div>
            </div>
        </div>
    </div>
    @endif
    @stack('scripts')
</body>

</html>
