@extends('layouts.main')
@section('content')
<div class="p-4 my-auto align-items-end">
    <h4 class="text-center my-5">
        Share your testimony
    </h4>

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
    
    <div class="form-group">
        <textarea class="form-control my-3" id="exampleFormControlTextarea1" rows="3" placeholder="Type your testimony below"></textarea>
    </div>

    <div class="row ">
        <div class="col-md-6">
            <button type="button" class="btn col-12 btn-outline-primary mt-2"> Upload your testimony </button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn col-12 btn-primary mt-2" type="submit"> Submit </button>
        </div>
        
    </div>
</div>
@endsection