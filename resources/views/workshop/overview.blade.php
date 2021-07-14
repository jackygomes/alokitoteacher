@extends('master')
@section('content')
    <style>
        .card-body {
            min-height: 132px;
            height: 132px;
            overflow: hidden;
        }

        .activist-details-image {
            width: 80px;
            height: 80px;
        }
        .video-content {
            border-radius: 10px;
        }
        .right-panel {
            border: 2px solid #f59d1f;
            border-radius: 10px;
        }
        .rating-inactive {
            color: #9d9d9d;
        }
        .fa-star {
            font-size: 26px;
        }
        .nav-tabs .nav-link.active {
            color: #000;
            background-color: #fff;
            border: none;
            border-bottom: 2px solid #000;
        }
        .nav-tabs .nav-link {
            border:none;
        }
        .nav-tabs .nav-link:hover {
            border:none;
            color: #000;
            border-bottom: 2px solid #000;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<div class="container mt-4" style="min-height: 90vh;">
    <div class="row">

        <div class="col-md-12 text-left mb-3">
            <small class="text-black"> Overview of</small>
            <h3 class="font-weight-bold"> {{ $workshop->name }}</h3>
        </div>

        <div class="col-md-8">

            {!! $thumbnailPart !!}

            <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#about" role="tab" aria-controls="home" aria-selected="true">About this Workshop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#what" role="tab" aria-controls="profile" aria-selected="false">What you will learn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#details" role="tab" aria-controls="home" aria-selected="true">Workshop Details</a>
                </li>
            </ul>
            <div class="tab-content pt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab">
                    <p>{!!$workshop->about_this_workshop!!}</p>
                </div>
                <div class="tab-pane fade show" id="what" role="tabpanel" aria-labelledby="about-tab">
                  <p>{!!$workshop->what_you_will_learn!!}</p>
                </div>
                <div class="tab-pane fade show" id="details" role="tabpanel" aria-labelledby="about-tab">
                    <p>Workshop Type: {!!$workshop->type!!}</p>
                    <p>Workshop Duration: {!!$workshop->duration!!}</p>
                    <p>Total Credit Hours: {!!$workshop->total_credit_hours!!}</p>
                    <p>Date & Time: {!!$workshop->date_time!!}</p>
                  </div>
                
                
                
            </div>
        </div>

        <div class="col-md-4 text-center">
        <div class="right-panel p-5">
            @if($message = Session::get('success'))
            <div class="alert alert-success">
                {{$message}}
            </div>
            @endif
            <div style="width: 150px; height: 150px;" class="mx-auto">
                
                <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/logo/alokito_logo.png') }}">
            </div>
            <br>


            {{-- @for($i = 1; $i <= 5; $i++) @if($content_rating - $i>= 0)
                <i class="fa fa-star text-yellow" aria-hidden="true"></i>
                @else
                <i class="far fa-star rating-inactive"></i>
                @endif
                @endfor --}}

                <button type="submit" class="mt-4 btn text-white background-yellow btn-lg" data-toggle="modal" data-target="#addJobModal">Register</button>
                <br>
                <br>
                <hr>
                <br>
                <span>
                    <span class="h3 text-success">
                        @if($workshop->price == 0)
                        Free
                        @else
                        {{ round($workshop->price, 2)}} BDT
                        @endif
                    </span>
                </span>
                <br>
                <!-- <button class="your-button-class" id="sslczPayBtn"
                 token="{{ csrf_token() }}"
                 postdata="your javascript arrays or objects which requires in backend"
                 order="If you already have the transaction generated for current order"
                 endpoint="{{ url('pay-via-ajax') }}"> Pay Now
         </button> -->
               

                {{-- <p class="mt-2">Total enrolled: {{$histories->count()}}</p> --}}

                @if(Request::segment(2) == 't')
                <p class="text-danger mt-3">***You can not retake this toolkit</p>
                @elseif(Request::segment(2) == 'c')
                <p class="text-danger mt-3">***You can not retake this course</p>
                @endif
        </div>
        </div>




    </div>
    <hr>
</div>
<div class="container">
   <div class="row">
       <div class="col-md-12">
           <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
           <!-- Horizontal Ad -->
           <ins class="adsbygoogle"
               style="display:block"
               data-ad-client="ca-pub-1285809732280483"
               data-ad-slot="5536262823"
               data-ad-format="auto"
               data-full-width-responsive="true"></ins>
           <script>
               (adsbygoogle = window.adsbygoogle || []).push({});
           </script>
       </div>
   </div>
</div>


<div class="modal fade" id="addJobModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLongTitle">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modalBody">

                <form id="jobPost" action="{{ route('workshops.register') }}" method="POST" class="mb-5">
                    @csrf
                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>Name:</label>
                            <input type="hidden" name="id" value="{{Auth::user()->id}}">
                            <input type="hidden" name="workshop_id" value="{{$workshop->id}}">
                            <input id="title" type="text" class="form-control border-yellow" name="name" placeholder="Name">
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Gender:</label>
                            <select class="form-control border-yellow" name="gender">
                                <option value="" disabled selected>-- Select Prefered Gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Not Specified">Prefer not to say</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Date of Birth:</label>
                            <input id="dob" type="date" class="form-control border-yellow" name="dob">
                        </div>

                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>Phone:</label>
                            <input id="phone" type="text" class="form-control border-yellow" name="phone" placeholder="Phone">
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>Email:</label>
                            <input id="email" type="email" class="form-control border-yellow" name="email" placeholder="Email">
                        </div>
                    </div>




                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>From which institution have you completed your Bachelor's Degree?</label>
                            <input id="institution" type="text" class="form-control border-yellow" name="institution" placeholder="From which institution have you completed your Bachelor's Degree?">
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>In which year have you completed your Bachelor's Degree?</label>
                            <input id="passing_year" type="text" class="form-control border-yellow" name="passing_year" placeholder="In which year have you completed your Bachelor's Degree?">
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>In which subject have you completed your Bachelor's Degree?</label>
                            <input id="subject" type="text" class="form-control border-yellow" name="subject" placeholder="In which subject have you completed your Bachelor's Degree?">
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>What is your highest level of education?</label>
                            <input id="education_level" type="text" class="form-control border-yellow" name="education_level" placeholder="What is your highest level of education?">
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Are you a teacher?</label>
                            <select class="form-control border-yellow" name="is_teacher" >
                                <option value="" disabled selected>-- Select --</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>For how many years are you in teaching profession?</label>
                            <input id="years_teaching" type="text" class="form-control border-yellow" name="years_teaching" placeholder="For how many years are you in teaching profession?">
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>In which institution are you teaching?</label>
                            <input id="teaching_institution" type="text" class="form-control border-yellow" name="teaching_institution" placeholder="In which institution are you teaching?">
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>It is a/an</label>
                            <select class="form-control border-yellow" name="school_type" >
                                <option value="" disabled selected>-- Select --</option>
                                <option value="Bangla Medium">Bangla Medium</option>
                                <option value="English Medium">English Medium</option>
                                <option value="English Version">English Version</option>
                                <option value="Madrasa">Madrasa</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>In which classes do you teach in your school?</label>
                            <select class="form-control" name="classes[]" id="classes" multiple="multiple">
                                <option value="Playgroup">Playgroup</option>
                                <option value="Kindergarten">Kindergarten</option>
                                <option value="Nursery">Nursery</option>
                                <option value="Class 1">Class 1</option>
                                <option value="Class 2">Class 2</option>
                                <option value="Class 3">Class 3</option>
                                <option value="Class 4">Class 4</option>
                                <option value="Class 5">Class 5</option>
                                <option value="Class 6">Class 6</option>
                                <option value="Class 7">Class 7</option>
                                <option value="Class 8">Class 8</option>
                                <option value="Class 9">Class 9</option>
                                <option value="Class 10">Class 10</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn background-yellow float-right">Submit</button>

                </form>




            </div>
        </div>
    </div>
</div>



@push('js')

<script src="https://player.vimeo.com/api/player.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
   $('#classes').select2({
            multiple: true,
        });
    (function(window, document) {
        var loader = function() {
            var script = document.createElement("script"),
                tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>

@endpush

@endsection
