<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCK || {{$active->name ?? ''}} </title>
    <style>
        .container {
            width: 100%;
            margin: 0 auto;
        }

        body {
            background-color: white;
            color: black;
        }

        .container .header {
            width: 100%;
            height: 100px;

            text-align: center;
            padding-top: 20px;
        }

        .container .header .title {
            font-size: xx-large;
            font-weight: bold;
        }

        .container .header .subtitle {
            font-size: x-large;
            font-weight: bold;
        }

        .header .caption {
            margin: 0;
            font-size: large;
            font-weight: bold;
        }

        .container .list {
            width: 100%;
            height: auto;
            padding-top: 20px;
            margin-top: 15%;
        }

        .testimony-text {
            text-align: justify;
        }

        .container .list {
            display: flex;
            flex-direction: column;
        }

    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1 class="title">GCK || Global Crusade with Kumuyi</h1>
            <h2 class="subtitle">{{ $crusadeTour->slug }}</h2>
            <h3 class="caption">Testimonies</h3>
        </div>

        <div class="list">
            @foreach ($crusadeTour->testimonies as $testimony)
                @php
                    $testifier = $testimony->testifier;
                @endphp
                <div class="testimony">
                    <div class="testimony-content">
                        <h3 class="testimony-title">#{{$loop->index+1}} - {{ $testifier->full_name }} ,
                            {{ $testifier->city }}/{{ $testifier->country->libelle }} , {{ $testifier->phone }} ,
                            {{ $testifier->phone }} </h3>
                        <p class="testimony-text">
                            {{ $testimony->content }}
                        </p>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
</body>

</html>
