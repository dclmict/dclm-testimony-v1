@extends('Admin.layout.main')
{{-- @push('dataTableCss')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush --}}

@section('Admincontent')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <select class="form-select form-select-lg mb-3" name="crusadeTour" aria-label=".form-select-lg example">
            <option selected>Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>

        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
            <option selected>Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vetted Testimonies Table</h6>
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
                            <th>File</th>
                            <th>Time</th>
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
                            <th>File</th>
                            <th>Time</th>
                            <th> Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($vts as $testimony)
                            <tr>

                                <td>{{ $testimony->name }}</td>
                                <td>{{ $testimony->email }}</td>
                                <td>{{ $testimony->phone }}</td>
                                <td>{{ $testimony->city }}</td>
                                {{-- <td>{{ $testimony->country->code }}</td> --}}
                                {{-- <td>{{ $testimony->country->libelle }}</td> --}}
                                <td>{{ substr($testimony->content, 0, 20) }}...</td>
                                <td><a href="{{ $testimony->path }}"
                                        target="_blank">{{ $testimony->path ? 'Media file' : 'No Media file' }}</a>
                                </td>

                                <td>{{ $testimony->created_at->format('d/m/Y') }} <br>
                                    {{ $testimony->created_at->addMinute()->addSecond()->diffForHumans(null, true, false, 2) }}
                                </td>
                                <td>


                                    <a href="{{ route('admin.testimonies.show', $testimony->id) }}"
                                        class="btn btn-sm btn-white text-primary mr-2"><i class="far fa-eye mr-1"></i>
                                        View</a>
                                    <a href="{{ route('admin.testimonies.delete', $testimony->id) }}"
                                        class="btn btn-sm btn-white text-danger mr-2"
                                        onclick="return confirm('Warning! This is a dangerous action. Are you sure about this ? ');"><i
                                            class="far fa-trash-alt mr-1"></i>Delete</a>

                                </td>
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
