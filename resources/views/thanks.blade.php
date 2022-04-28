@extends("layouts.main")

@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center gap-5">
        <img width="300" class="img-fluid" src="{{ asset('images/logo.png') }}" alt="">
        <span class="text-center" style="font-size: 36px;">
            THANKS <br>
           FOR YOUR TESTIMONY
        </span>

        <div class="d-flex flex-column align-items-center gap-3" style="margin-top: 10vh">
            Connect with us
            <div class="d-flex gap-4">
                <img width="40" src="{{asset('images/yt.png')}}" alt="">
                <img width="40" src="{{asset('images/fb.png')}}" alt="">
                <img width="40" src="{{asset('images/tw.png')}}" alt="">
            </div>
        </div>
    </div>
@endsection
