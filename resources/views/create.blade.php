@extends('layouts.main')
@section('content')
<div class="p-4 my-auto align-items-end">
    <h4 class="text-center my-5">
        Share your testimony
    </h4>
    <form action="{{route("testimony.store")}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="my-3">
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
                <select name="country_id" class="form-control" id="country_id">
                    <option value="">Country</option>
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
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type your testimony below" name="content"></textarea>
        </div>

        <div class="row my-5">
            <div class="col-md-6">
                <button type="button" class="btn col-12 btn-outline-primary mt-2"> Upload your testimony </button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn col-12 btn-primary mt-2" type="submit"> Submit </button>
            </div>
        </div>
    </form>
</div>
@endsection