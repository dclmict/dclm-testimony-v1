@extends('Admin.layout.main')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashbord</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="font-weight-bold text-dark">Welcome {{ Auth::user()->name ?? '' }} </h1>
                    <h2 class="text-dark font-weigth-thin">GCK Testimonies Portal</h2>

                    <div class="mt-3">
                        <h2 class="text-xs">Ongoing Crusade</h2>
                        <a href="#">{{ $active == null ? 'Undefined' : $active->slug }}</a>
                    </div>
                </div>

            </div>
        </div>


        <div class="col-md-6">

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bold text-dark text-center text-xs">Global Testimonies</h3>
                            <h2 class="text-dark font-weigth-thin text-center">{{ App\Models\Testimony::count() }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bold text-dark text-center text-xs">Crusade Tours</h3>
                            <h2 class="text-dark font-weigth-thin text-center">{{ App\Models\CrusadeTour::count() }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bold text-dark text-center text-xs">Countries</h3>
                            <h2 class="text-dark font-weigth-thin text-center">{{ 0 }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bold text-dark text-center text-xs">Ongoing Crusade Testimonies</h3>
                            <h2 class="text-dark font-weigth-thin text-center">{{ $active? $active->testimonies->count() :0 }}</h2>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
