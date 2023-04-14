@extends('Admin.layout.main')
{{-- @push('dataTableCss')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush --}}

@section('Admincontent')
    <!-- DataTales Example -->

    <form method="get">
        <div class="col">
            <label for=""> <b> Select Crusade Tour Category </b></label>
            <select class="form-control col  " name="crusadeTour" aria-label=".form-select-lg example">
                @foreach ($crusadeTours as $ct)
                    <option value="{{ $ct->name }}"> {{ $ct->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary my-2 d-inline" type="submit"> Submit </button>
        </div>

    </form>
    <div class="card shadow mb-4">

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
                        @foreach ($vts as $vettedTestimony)
                            <tr>

                                <td>{{ $vettedTestimony->name }}</td>
                                <td>{{ $vettedTestimony->email }}</td>
                                <td>{{ $vettedTestimony->phone }}</td>
                                <td>{{ $vettedTestimony->city }}</td>
                                {{-- <td>{{ $testimony->country->code }}</td> --}}
                                {{-- <td>{{ $testimony->country->libelle }}</td> --}}
                                <td>{{ substr($vettedTestimony->content, 0, 20) }}...</td>
                                <td><a href="{{ $vettedTestimony->path }}"
                                        target="_blank">{{ $vettedTestimony->path ? 'Media file' : 'No Media file' }}</a>
                                </td>

                                <td>{{ $vettedTestimony->created_at->format('d/m/Y') }} <br>
                                    {{ $vettedTestimony->created_at->addMinute()->addSecond()->diffForHumans(null, true, false, 2) }}
                                </td>
                                <td>


                                    <a href="{{ route('admin.testimonies.show', $vettedTestimony->id) }}"
                                        class="btn btn-sm btn-white text-primary mr-2"><i class="far fa-eye mr-1"></i>
                                        View</a>
                                    <a href="{{ route('admin.testimonies.delete', $vettedTestimony->id) }}"
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
