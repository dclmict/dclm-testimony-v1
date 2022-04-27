@extends('layouts.main')
@section('content')
<div class="p-4">
    <h1 class="text-center">
        Share your testimony
    </h1>
    <form action="{{route("testimony.store")}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="my-3">
            {{-- <label for="exampleFormControlInput1" class="form-label">Email address</label> --}}
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Fullname" name="full_name">
        </div>
        <div class="form-group row">
            <div class="my-3 col-md-6">
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" name="email">
            </div>
            <div class="my-3 col-md-6">
                <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Phone" name="phone">
            </div>
        </div>

        <div class="form-group row">
            <div class="my-3 col-md-6">
                <select name="country_id" id="country_id">
                    @foreach ($countries as $country)
                        <option value="{{$country->id}}">{{$country->libelle}}</option>
                    @endforeach
                </select>
            </div>
            <div class="my-3 col-md-6">
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="city" name="city">
            </div>
        </div>
        
        <div class="mb-3">
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type your testimony below"></textarea name="content">
        </div>

        <div class="row">
            <button type="button" class="col btn btn-outline-primary"> Upload your testimony </button>
            <input type="file" name="file_dir" id="file_dir">
            <button type="submit" class="col justify-content-end  btn btn-primary"> Submit </button>
        </div>
    </form>
</div>
@endsection