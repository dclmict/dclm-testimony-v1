@extends('Admin.layout.main')
{{-- @push('dataTableCss')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush --}}

@section('Admincontent')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
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
                            <th>Country</th>
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
                            <th>Country</th>
                            <th>Content</th>
                            <th>file</th>
                            <th>Uploaded_at</th>
                            <th> Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($testimonies as $testimony)
                            <tr>
                                <td>{{ $testimony->full_name }}</td>
                                <td>{{ $testimony->email}}</td>
                                <td>{{ $testimony->phone }}</td>
                                <td>{{ $testimony->city }}</td>
                                <td>{{ $testimony->country->code }}</td>
                                {{-- <td>{{ $testimony->country->libelle }}</td> --}}
                                <td>{{ $testimony->content }}</td>
                                <td>{{ $testimony->file_dir }}</td>
                                <td>{{ $testimony->created_at }}</td>
                                <td> <button  class="btn btn-primary"> View </button></td>

                                
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
