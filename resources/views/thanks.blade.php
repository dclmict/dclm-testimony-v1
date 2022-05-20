@extends("layouts.main")

@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center gap-5">
        <img width="300" class="img-fluid" src="{{ asset('images/logo.png') }}" alt="">
        <span class="text-center" style="font-size: 36px;">
            THANKS <br>
            FOR YOUR TESTIMONY
        </span>
        <a href="{{ route('testimony.show') }}" class="btn btn-primary dlcf_btn_color">
            <i class="fa fa-home"></i>
            Share another Testimony ?
        </a>
        <div class="d-flex flex-column align-items-center gap-3" style="margin-top: 10vh">
            Connect with us
            <div class="d-flex gap-4">
                <a href="https://www.youtube.com/c/DCLMHQ" target="_blank"><img width="40"
                        src="{{ asset('images/yt.png') }}" alt=""></a>

                <a href="https://www.facebook.com/dclmhq" target="_blank"><img width="40"
                        src="{{ asset('images/fb.png') }}" alt=""></a>
                <a href="https://twitter.com/dclmhq" target="_blank"> <img width="40" src="{{ asset('images/tw.png') }}"
                        alt=""></a>


            </div>
        </div>
    </div>
@endsection
