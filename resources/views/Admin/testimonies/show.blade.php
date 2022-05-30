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
                <div class="card-header pt-2 pb-0 d-flex flex-row align-items-center justify-content-between">

                    <div class="col" >
                          <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th >Testifier</th>
                                        <td> {{ $testimony->testifier->full_name }}</td>
                                        <th >City</th>
                                        <td> {{ $testimony->testifier->city }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th >Email</th>
                                        <td>{{ $testimony->testifier->email }}</td>
                                        <th scope="row">Country</th>
                                        <td> {{ $testimony->testifier->country->libelle }}</td>
                                    </tr>
                                    <tr>
                                        <th >Phone</th>
                                        <td> {{ $testimony->testifier->phone }}
                                        </td>
                                        <th >Media-File</th>
                                        <td> <a href="{{ $testimony->path }}"
                                                target="_blank">{{ $testimony->path ? 'Media file' : 'No Media file' }}</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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

                        <span class="m-0 font-weight-bold text-primary">Testimony: </span> {{ $testimony->content }}

                    @section('user')
                        {{ $testimony->testifier->full_name }}
                    @endsection

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
