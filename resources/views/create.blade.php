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

        #overlay {
            position: fixed;
            /* Sit on top of the page content */

            /* Hidden by default */
            width: 100%;
            /* Full width (cover the whole page) */
            height: 100%;
            /* Full height (cover the whole page) */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            /* Black background with opacity */
            z-index: 2;
            /* Specify a stack order in case you're using a different order for other elements */
            cursor: pointer;
            /* Add a pointer on hover */
            padding-inline: 10%;
        }
    </style>
@endpush
@section('content')
    <div class="p-4 my-auto align-items-end" id="testimony-section" x-data="app()">

        <div id="overlay" class="row align-items-center justify-content-center" x-show="false">

        </div>
        <h4 class="text-center my-5">
            Share your testimony
        </h4>
        <form action="{{ route('testimony.store') }}" method="POST" enctype="multipart/form-data" x-on:submit="submit()">
            @csrf
            <div class="my-3">

                <input required type="text" class="form-control" id="exampleFormControlInput1" placeholder="Fullname"
                    name="full_name" value="{{ old('full_name') }}">
                <x-error name="full_name" />
            </div>
            <div class="form-group row">
                <div class="my-3 col-md-6">
                    <input required type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email"
                        name="email" value="{{ old('email') }}">
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
                    <select required name="country_id" class="form-control js-example-basic-single" id="country_id"
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

            <div class="row my-5" x-show="!loading">
                <div class="text-muted font-weight-bold"> Upload your Picture or Video </div>
                <div class="col-md-6">
                    {{-- <button type="button" class="btn col-12 btn-outline-primary mt-2"> Upload your testimony </button> --}}
<<<<<<< HEAD

                    <input type="file" name="file_dir" class="btn col-12 btn-outline-primary mt-2" id="file_dir"
                        value="{{ old('file_dir') }}">
=======
                    <label for="file_dir" class="btn btn-outline-primary col-12">

                        <img src="{{ asset('icons/upload.svg') }}"> <span x-text="file_upload_label"></span>
                    </label>
                    <input x-on:change="uploaded" type="file" name="file_dir" hidden
                        class="btn col-12 btn-outline-primary mt-2" id="file_dir" value="{{ old('file_dir') }}">
>>>>>>> eac09abc77fb47cc328c0e6ffac6b1d3c26cc023
                    <x-error name="file_dir" />

                </div>
                <div class="col-md-6">
                    <button class="btn col-12 btn-primary mt-2 d-flex justify-content-center align-items-center"
                        type="submit"> <span x-text="button_text">Submit </span>
                        <div x-show="loading" class="spinner-border text-white" role="status" id="spinner">

                        </div>
                    </button>
                </div>

            </div>
<<<<<<< HEAD
            <div class="progress" style="height: 30px" x-on:click="submit()" x-show="loading">
                <div :style="`width: ${progress}%; transition: width 2s;`" class="progress-bar" role="progressbar"
                    :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100">
                    Sending your testimony...
=======
            <div class="progress" style="height: 30px" x-show="loading">
                <div :style="`width: ${progress}%; transition: width 2s;`" class="progress-bar" role="progressbar"
                    :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100" x-text="button_text">

>>>>>>> eac09abc77fb47cc328c0e6ffac6b1d3c26cc023
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/alpine.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery.form.js') }}"></script>


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
                loading: true,
                button_text: 'Submit',
                progressValue: 0,
<<<<<<< HEAD
                progress: 50,
=======
                progress: 00,
                button_texts: ['Uploading file...', 'Sending your testimony...', 'Submitting your testimony...',
                    'Wait a while...', 'Almost Done ...'
                ],

                file_upload_label: 'Upload your Picture or Video',

>>>>>>> eac09abc77fb47cc328c0e6ffac6b1d3c26cc023

                submit() {
                    this.loading = true;
                    this.button_text = 'Submitting...';

                    setInterval(() => {
                        this.progress += Math.floor(Math.random() * 10);
<<<<<<< HEAD
                    }, 1000);

                    /*  setInterval(() => {

                         this.progressValue += Math.floor(Math.random() * 10);

                         // $refs.progress_bar.style.width = this.progressValue + '%';
                         //in nextick update $refs.progress_bar.style value

                         if (this.progressValue >= 100) {
                             this.progressValue = 99;
                         }
                     }, 1000);
                     */
=======
                        this.button_text = this.button_texts[Math.floor(Math.random() * this.button_texts
                            .length)];

                        if (this.progress >= 100) {
                            this.progress = 100;

                            this.button_text = "Submitted. Don't close yet...";
                        }
                    }, 1000);


>>>>>>> eac09abc77fb47cc328c0e6ffac6b1d3c26cc023

                },

                uploaded(event,position, total, percentComplete) {

                    alert(position)

                    if (event.target.files.length > 0) {
                        //ten last caracters of the file name
                        let file_name = "..." + event.target.files[0].name.substr(event.target.files[0].name.length -
                            25);
                        this.file_upload_label = file_name
                    } else {
                        this.file_upload_label = 'Upload your Picture or video';
                    }
                }

            }
        }
    </script>
@endpush
