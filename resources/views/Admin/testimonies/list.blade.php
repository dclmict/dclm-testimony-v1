@extends('Admin.layout.main')
{{-- @push('dataTableCss')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush --}}

@section('Admincontent')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Testimonies Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            {{-- <th>Country</th> --}}
                            <th>Content</th>
                            <th>file</th>
                            <th>Uploaded_at</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            {{-- <th>Country</th> --}}
                            <th>Content</th>
                            <th>file</th>
                            <th>Uploaded_at</th>
                            <th> Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($testimonies as $testimony)
                            <tr>
                                <td>{{ $testimony->testifier->full_name }}</td>
                                <td>{{ $testimony->testifier->email}}</td>
                                <td>{{ $testimony->testifier->phone }}</td>
                                <td>{{ $testimony->testifier->city }}</td>
                                {{-- <td>{{ $testimony->testifier->code }}</td> --}}
                                {{-- <td>{{ $testimony->country->libelle }}</td> --}}
                                <td>{{ substr($testimony->content, 0, 4) }}...</td>
                                <td>{{ $testimony->file_dir  }}</td>
                                <td>{{ $testimony->created_at }}</td>
                                <td> <a href="{{ route("admin.testimonies.show", $testimony->id) }}"  class="btn btn-primary"> View </button></td>

                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('dataTableScripts')
    <!-- Page level plugins -->
    <script src=" {{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src=" {{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush
