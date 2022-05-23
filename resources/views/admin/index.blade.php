@extends('Admin.layout.main')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashbord</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="font-weight-bold text-dark">WELCOME ON </h1>
                    <h2 class="text-dark font-weigth-thin">GC-TESTIMONY ADMIN CENTER</h2>

                    <div class="mt-3">
                        <h2 class="text-xs">Ongoing crusade</h2>
                        <a href="#">{{ $active == null ? 'Undefined' : $active->slug }}</a>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
