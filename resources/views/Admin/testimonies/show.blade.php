@extends('Admin.layout.main')
{{-- @push('dataTableCss')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush --}}

@section('Admincontent')
    <div class="row">
        <div class="col">
            <!-- Dropdown Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Testimony</h6>
                    <h6 class="m-0 font-weight-bold text-primary">Testifier: {{ $testimony->full_name }}</h6>
                    {{-- <h6 class="m-0 font-weight-bold text-primary">Country: {{ $testimony->Country->code }}</h6> --}}
                    <h6 class="m-0 font-weight-bold text-primary">Phone: {{ $testimony->phone }}</h6>
                    <a href="{{ $testimony->path }}"
                        target="_blank">{{ $testimony->path ? 'Media file' : 'No Media file' }}</a>

                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <div class="row">

                            {{ $testimony->content }}


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
