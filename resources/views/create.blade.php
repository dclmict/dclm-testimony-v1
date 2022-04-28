@extends('layouts.main')
@push('styles')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
    <style>
        .select2-selection__rendered {
            line-height: 38px !important;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
        }

    </style>
@endpush
@section('content')
    <div class="p-4 my-auto align-items-end">
        <h4 class="text-center my-5">
            Share your testimony
        </h4>
        <form action="{{ route('testimony.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="my-3">
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Fullname"
                    name="full_name" value="{{ old('full_name') }}">
                <x-error name="full_name" />
            </div>
            <div class="form-group row">
                <div class="my-3 col-md-6">
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" name="email"
                        value="{{ old('email') }}">
                    <x-error name="email" />
                </div>
                <div class="my-3 col-md-6">
                    <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Phone"
                        name="phone" value="{{ old('phone') }}">
                    <x-error name="phone" />
                </div>
            </div>

            <div class="form-group row">
                <div class="my-3 col-md-6">
                    <select name="country_id" class="form-control js-example-basic-single" id="country_id"
                        style="width: 100%;">
                        <option value="">Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->libelle }}</option>
                        @endforeach
                    </select>
                    <x-error name="country_id" />
                </div>
                <div class="my-3 col-md-6">
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="city"
                        value="{{ old('city') }}" name="city">
                    <x-error name="city" />
                </div>
            </div>

            <div class="mb-3">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type your testimony below"
                    name="content">{{ old('content') }}</textarea>
                <x-error name="content" />
            </div>

            <div class="row my-5">
                <div class="col-md-6">
                    {{-- <button type="button" class="btn col-12 btn-outline-primary mt-2"> Upload your testimony </button> --}}
                    <input type="file" name="file_dir" class="btn col-12 btn-outline-primary mt-2" id="file_dir"
                        value="{{ old('file_dir') }}">
                    <x-error name="file_dir" />
                </div>
                <div class="col-md-6">
                    <button class="btn col-12 btn-primary mt-2" type="submit"> Submit </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



    <script src="{{ asset('js/select2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            placeholder: 'Select an option';
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>
@endpush
