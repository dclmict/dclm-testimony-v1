@extends('layouts.main')
@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
        <form action="{{ route('testimony.store') }}" method="POST" enctype="multipart/form-data" @submit.prevent="submit">
            {{-- x-on:submit="submt" --}}
            @csrf
            <div class="my-3">

                <input required type="text" class="form-control" id="exampleFormControlInput1" placeholder="Fullname"
                    name="full_name" value="{{ old('full_name') }}" x-model="attr.name">
                <x-error name="full_name" />
            </div>
            <div class="form-group row">
                <div class="my-3 col-md-6">
                    <input required type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email"
                        name="email" value="{{ old('email') }}" x-model="attr.email">
                    <x-error name="email" />
                </div>
                <div class="my-3 col-md-6">
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Phone"
                        name="phone" value="{{ old('phone') }}" x-model="attr.phone">
                    <x-error name="phone" />
                </div>
            </div>

            <div class="form-group row">
                <div class="my-3 col-md-6">
                    <select required name="country_id" class="form-control js-example-basic-single" id="country_id"
                        style="width: 100%;" x-model="attr.country_id">
                        <option value="">Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->libelle }}</option>
                        @endforeach
                    </select>
                    <x-error name="country_id" />
                </div>
                <div class="my-3 col-md-6">
                    <input required type="text" class="form-control" id="exampleFormControlInput1" placeholder="city"
                        value="{{ old('city') }}" name="city" x-model="attr.city">
                    <x-error name="city" />
                </div>
            </div>

            <div class="mb-3">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type your testimony below"
                    name="content" x-model="attr.content">{{ old('content') }}</textarea>
                <x-error name="content" />
            </div>

            <div class="row my-5" x-show="!loading">
                <div class="text-muted font-weight-bold"> Upload your Picture or Video </div>
                <div class="col-md-6">
                    {{-- <button type="button" class="btn col-12 btn-outline-primary mt-2"> Upload your testimony </button> --}}
                    <label for="file_dir" class="btn btn-outline-primary col-12">

                        <img src="{{ asset('icons/upload.svg') }}"> <span x-text="file_upload_label"></span>
                    </label>
                    <input x-on:change="uploaded" type="file" name="file_dir" hidden
                        class="btn col-12 btn-outline-primary mt-2" id="file_dir" value="{{ old('file_dir') }}"
                        x-model="attr.file_dir">
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
            <div class="progress" style="height: 30px" x-show="loading">
                <div :style="`width: ${progress}%; transition: width 2s;`" class="progress-bar" role="progressbar"
                    :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100" x-text="button_text">

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
                form: new FormData,
                attr: {
                    name: null,
                    email:null ,
                    phone:null ,
                    country_id: null ,
                    city: null,
                    content: null,
                    file_dr: null,
                },
                loading: false,
                button_text: 'Submit',
                progressValue: 0,
                progress: 00,
                button_texts: ['Uploading file...', 'Sending your testimony...', 'Submitting your testimony...',
                    'Wait a while...', 'Almost Done ...'
                ],

                file_upload_label: 'Upload your Picture or Video',

                submit() {
                    this.form.append('full_name', JSON.stringify(this.attr.name))
                    this.form.append('emailk', JSON.stringify(this.attr.email))
                    this.form.append('country_id', JSON.stringify(this.attr.country_id))
                    this.form.append('cityf', JSON.stringify(this.attr.city))
                    this.form.append('content', JSON.stringify(this.attr.content))
                    this.form.append('file_dir', this.attr.file_dir)
                    this.form.append('phonev', JSON.stringify(this.attr.phone))
                    // for (const value of this.form.values()) {
                    //     console.log(value);
                    // }
                    // const config = {

                    // }
            
                    fetch(
                            '{{ route("testimony.store") }}', {
                                method: 'POST',
                                headers: {

                        
                                    'Accept': 'application/json',
                                    
                                    //I had to comment that because what is supposed to be a solution is actually a problem.  I mean that above !
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: this.form
                                
                            })
                        .then(() => {
                            console.log(response.data);
                            this.loading = true;
                            this.button_text = 'Submitting...';
                            setInterval(() => {
                                this.progress += Math.floor(Math.random() * 10);
                                this.button_text = this.button_texts[Math.floor(Math.random() * this
                                    .button_texts
                                    .length)];

                                if (this.progress >= 100) {
                                    this.progress = 100;
                                    this.button_text = "Testimony successfully submitted !";
                                }
                            }, 1000);
                        }).catch(() => {
                            console.log('Something definitely went wrong')
                        })


                },

                uploaded(event, position, total, percentComplete) {

                    if (event.target.files.length > 0) {
                        //ten last caracters of the file name
                        let file_name = "..." + event.target.files[0].name.substr(event.target.files[0].name.length -
                            21);
                        this.file_upload_label = file_name
                    } else {
                        this.file_upload_label = 'Upload your Picture or o';
                    }
                }

            }
        }
    </script>
@endpush
