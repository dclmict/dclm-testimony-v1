@extends("layouts.main")


@section('content')
    <div class="d-none d-md-flex flex-column mt-3">
        <div class="row align-self-center" >
            <div class="col-md-auto">
                <a href="#">Contact us</a>
            </div>
            <div class="col-md-auto">
                <a href="#">Go live</a>
            </div>
            <div class="col-md-auto">
                <a href="#">Testify</a>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column justify-content-center" style="height: 93%">
        {{-- flex menu --}}
        <div class="d-flex">
            <div class="d-flex flex-column center-on-mobile ">
                <h1  style="font-size: 6vw">
                    Testimony For
                    Ogun State Crusade
                </h1>

                <h2 style="font-size: 3vw">
                    Testify to the goodness of God
                </h2>
                <button class="btn main-button" style="margin-top:44px">
                    Share My Testimony
                </button>
            </div>
        </div>


    </div>
@endsection
