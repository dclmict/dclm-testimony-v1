@extends('layouts.main')
@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <link href="{{ asset('css/select2.css') }}" rel="stylesheet" /> --}}

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


        .modal-confirm {
            color: #434e65;
            width: 525px;
        }

        .modal-confirm .modal-content {
            padding: 20px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }

        .modal-confirm .modal-header {
            background: #47c9a2;
            border-bottom: none;
            position: relative;
            text-align: center;
            margin: -20px -20px 0;
            border-radius: 5px 5px 0 0;
            padding: 35px;
        }

        .modal-confirm h4 {
            text-align: center;
            font-size: 36px;
            margin: 10px 0;
        }

        .modal-confirm .form-control,
        .modal-confirm .btn {
            min-height: 40px;
            border-radius: 3px;
        }

        .modal-confirm .close {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #fff;
            text-shadow: none;
            opacity: 0.5;
        }

        .modal-confirm .close:hover {
            opacity: 0.8;
        }

        .modal-confirm .icon-box {
            color: #fff;
            width: 95px;
            height: 95px;
            display: inline-block;
            border-radius: 50%;
            z-index: 9;
            border: 5px solid #fff;
            padding: 15px;
            text-align: center;
        }

        .modal-confirm .icon-box i {
            font-size: 64px;
            margin: -4px 0 0 -4px;
        }

        .modal-confirm.modal-dialog {
            margin-top: 80px;
        }

        .modal-confirm .btn,
        .modal-confirm .btn:active {
            color: #fff;
            border-radius: 4px;
            background: #eeb711 !important;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            border-radius: 30px;
            margin-top: 10px;
            padding: 6px 20px;
            border: none;
        }

        .modal-confirm .btn:hover,
        .modal-confirm .btn:focus {
            background: #eda645 !important;
            outline: none;
        }

        .modal-confirm .btn span {
            margin: 1px 3px 0;
            float: left;
        }

        .modal-confirm .btn i {
            margin-left: 1px;
            font-size: 20px;
            float: right;
        }

        .trigger-btn {
            display: inline-block;
            margin: 100px auto;
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
        <form @submit.prevent="submit" autocomplete="off">
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
                    <select class="form-select" id="country_id" x-model="attr.country_id" autocomplete="off" required>
                        <option selected disabled value="">Choose...</option>
                        <option value="3"> testing </option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->libelle }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="my-3 col-md-6">
                    <input required type="text" class="form-control" id="exampleFormControlInput1" placeholder="city"
                        x-model="attr.city">

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

    <!-- Modal HTML -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" x-ref="modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Submitted Successfully !
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('testimony.show') }}"><button type="button" class="btn btn-primary">Share another
                            testimony ?</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <div class="icon-box">
                        <i class="material-icons">&#xE876;</i>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <h4>Great!</h4>
                    <p>Your account has been created successfully.</p>
                    <button class="btn btn-success" data-dismiss="modal"><span>Start Exploring</span> <i
                            class="material-icons">&#xE5C8;</i></button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('scripts')
    {{-- SO you want to mind how you stack  the javascripts for now  --}}
    <script src="{{ asset('js/axios.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}

    <script src="{{ asset('js/alpine.min.js') }}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> --}}

    {{-- <script src="{{ asset('js/jquery.form.js') }}"></script> --}}

{{-- 
    <script src="{{ asset('js/select2.js') }}"></script> --}}
    <script>
        // let it be for now, jquery plugin is classing with boorstap js...we can manage it 
        // $(document).ready(function() {
        //     $('.js-example-basic-single').select2();
        //     $('#country_id').select2().val();
        //     placeholder: 'Select an option';

        //     $(document).on('select2:open', () => {
        //         document.querySelector('.select2-search__field').focus();
        //     });
        // });
    </script>

    <script>
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        window.app = function() {

            return {
                form: new FormData(),
                attr: {
                    name: "",
                    email: "",
                    phone: "",
                    country_id: "",
                    city: "",
                    content: "",

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
                    const bar = document.getElementById('progress-bar');

                    this.form.append('full_name', this.attr.name),
                        this.form.append('email', this.attr.email),
                        this.form.append('country_id', this.attr.country_id),
                        this.form.append('city', this.attr.city),
                        this.form.append('content', this.attr.content),
                        this.form.append('phone', this.attr.phone),
                        this.form.append('file_dir', document.getElementById('file_dir').files[0])
                    for (const value of this.form.values()) {
                        console.log(value);
                    }
                    // no need for multiform part, axios has a way of doing that by itself
                    //also, 

                    // Axios
                    const config = {
                        onUploadProgress: function(progressEvent) {
                            this.loading = true;
                            this.progress = Math.round((progressEvent.loaded / progressEvent.total) *
                                100);
                            this.button_text = this.progress
                            if (this.progress === 100) {
                                this.loading = false
                                this.button_text = "Submit"
                                myModal.show()
                                var myModalEl = document.getElementById('exampleModal')
                                myModalEl.addEventListener('hidden.bs.modal', function(event) {
                                    location.reload();
                                })

                            }

                        }.bind(
                            this
                        ) //attach or bind this function to use alpinejs (this) instance nside the onUploadProgress 
                    }
                    axios.post(
                            '{{ route('testimony.store') }}', this.form, config, {
                                headers: {
                                    // 'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                            })
                        .then(() => {
                            console.log(response.data);
                        }).catch(() => {
                            console.log('Something definitely went wrong')
                        })
                },

                //fucntion to shorten higlight the text once an image has been selected
                uploaded(event, position, total, percentComplete) {
                    if (event.target.files.length > 0) {
                        //ten last caracters of the file name
                        let file_name = "..." + event.target.files[0].name.substr(event.target.files[0].name.length -
                            21);
                        this.file_upload_label = file_name
                    } else {
                        this.file_upload_label = 'Upload your Picture or o';
                    }
                },

            }
        }
    </script>
@endpush
