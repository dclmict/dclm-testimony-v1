@extends('Admin.layout.main')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Add Crusade Tours</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @if ($ct == null)
                        {{-- <h3>Add New</h3> --}}
                        <form action="{{ route('admin.crusade.tour.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="">Slug</label>
                                <input type="text" required name="slug" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" required name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Banner</label>
                                <input type="file"  name="banner_path" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    @else
                        <h3>Modify Crusade Tour</h3>

                        <form action="{{ route('admin.crusade.tour.update', $ct->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="">Slug</label>
                                <input type="text" required name="slug" class="form-control" value="{{ $ct->slug }}">
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" required name="name" class="form-control" value="{{$ct->name}}">
                            </div>
                            <div class="form-group">
                                <label for="">Banner</label>
                                <input type="file"  name="banner_path" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
