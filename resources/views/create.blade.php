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
    <div class="p-4 my-auto align-items-end" id="testimony-section">
        <h4 class="text-center my-5">
            Share your testimony
        </h4>
        <form action="{{ route('testimony.store') }}" method="POST" enctype="multipart/form-data" x-data="app()" x-on:submit="submit()">
            @csrf
            <div class="my-3">

                <input required type="text" class="form-control" id="exampleFormControlInput1" placeholder="Fullname"
                    name="full_name" value="{{ old('full_name') }}">
                <x-error name="full_name" />
            </div>
            <div class="form-group row">
                <div class="my-3 col-md-6">
                    <input required type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" name="email"
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
                    <select  required name="country_id" class="form-control js-example-basic-single" id="country_id"
                        style="width: 100%;">
                        <option value="">Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->libelle }}</option>
                        @endforeach
                    </select>
                    <x-error name="country_id" />
                </div>
                <div class="my-3 col-md-6">
                    <input required type="text" class="form-control" id="exampleFormControlInput1" placeholder="city"
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
                    <button  class="btn col-12 btn-primary mt-2 d-flex justify-content-center align-items-center" type="submit"> <span
                            x-text="button_text" >Submit </span>
                        <div x-show="loading" class="spinner-border text-white" role="status" id="spinner">

                        </div>
                    </button>
                </div>

                {{-- spiner bootstrap --}}

                {{-- <div class="progress" >
                    <div class="progress-bar" x-ref="progress_bar" :style="`width:${progressValue}+'%'`" role="progressbar"  aria-valuenow="0" aria-valuemin="0"
                        aria-valuemax="100" x-text="progressValue+'%'">25%</div>
                </div> --}}
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/alpine.min.js') }}">

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery.form.js') }}">

    </script>


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

    <script>
        window.app = function() {
            return {
                loading: false,
                button_text: 'Submit',
                progressValue: 0,

                submit() {
                    this.loading = true;
                    this.button_text = 'Submitting...';

                   /*  setInterval(() => {

                        this.progressValue += Math.floor(Math.random() * 10);

                        // $refs.progress_bar.style.width = this.progressValue + '%';
                        //in nextick update $refs.progress_bar.style value

                        if (this.progressValue >= 100) {
                            this.progressValue = 99;
                        }
                    }, 1000);
                    */

                },

            }
        }
    </script>
@endpush
