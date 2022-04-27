@extends('layouts.main')
@section('content')
<div class="p-4">
    <h1 class="text-center">
        Share your testimony
    </h1>

    <div class="my-3">
        {{-- <label for="exampleFormControlInput1" class="form-label">Email address</label> --}}
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Fullname">
    </div>
    <div class="form-group row">
        <div class="my-3 col-md-6">
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email">
        </div>
        <div class="my-3 col-md-6">
            <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Phone">
        </div>
    </div>

    <div class="form-group row">
        <div class="my-3 col-md-6">
            <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="country">
        </div>
        <div class="my-3 col-md-6">
            <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="city">
        </div>
    </div>
    
    <div class="mb-3">
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type your testimony below"></textarea>
    </div>
</div>
@endsection