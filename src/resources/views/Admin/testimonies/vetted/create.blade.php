@extends('Admin.layout.main')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Add Vetted Testimonies </h1>


    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <h3>Add </h3>
                    <form action="{{ route('admin.testimony.vetted.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-6">
                                <label for="">Name</label>
                                <input type="text" required name="name" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Email</label>
                                <input type="email" required name="email" class="form-control">
                            </div>


                            <div class="form-group col-6">
                                <label for="">Phone</label>
                                <input type="number" required name="phone" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="">City</label>
                                <input type="text" name="city" class="form-control">
                            </div>


                            <div class="form-group col-6">
                                <label for="">Country</label>
                                <select class="custom-select" name="country">
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}">{{$country->libelle}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="">Media </label>
                                <input type="file" name="banner_path" class="form-control">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
