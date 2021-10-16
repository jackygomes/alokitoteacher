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
        .select2-container  {
            width: 100% !important;
        }
        .select2-selection--multiple {
            border-color: #f5b82f !important;
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
            @if($thumbnailPart)
            {!! $thumbnailPart !!}
            @else
            <img src="{{url('images\thumbnail')}}\{{ $workshop->thumbnail }}" style="" class="card-img-top">
            @endif

            <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#about" role="tab" aria-controls="home" aria-selected="true">About this Workshop</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#what" role="tab" aria-controls="profile" aria-selected="false">What you will learn</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#details" role="tab" aria-controls="home" aria-selected="true">Workshop Details</a>
                </li>
            </ul>
            <div class="tab-content pt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab">
                    <p>{!!$workshop->about_this_workshop!!}</p>
                </div>
                <!-- <div class="tab-pane fade show" id="what" role="tabpanel" aria-labelledby="about-tab">
                  <p>{!!$workshop->what_you_will_learn!!}</p>
                </div> -->
                <div class="tab-pane fade show" id="details" role="tabpanel" aria-labelledby="about-tab">
                    <p><span class="text-yellow">Workshop Type:</span> {!!$workshop->type!!}</p>
                    <p><span class="text-yellow">Workshop Duration:</span> {!!$workshop->duration!!}</p>
                    <p><span class="text-yellow">Total Credit Hours:</span> {!!$workshop->total_credit_hours!!}</p>
                    <p><span class="text-yellow">Date & Time:</span> {!!$workshop->date_time!!}</p>
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


            @for($i = 1; $i <= 5; $i++) @if($content_rating - $i>= 0)
            <i class="fa fa-star text-yellow" aria-hidden="true"></i>
            @else
            <i class="far fa-star rating-inactive"></i>
            @endif
            @endfor

            @if(Auth::user())
            <button type="submit" class="mt-4 btn text-white background-yellow btn-lg" data-toggle="modal" data-target="#addJobModal">Register Now</button>
            @else
            <a href="{{ route('workshops.registerLogin', $workshop->slug) }}" class="login-to-register mt-4 btn text-white background-yellow btn-lg">Register Now</a>
            @endif
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
            @if($alreadyRegistered && !$ratingGiven)
            <button class="mt-4 btn text-white background-yellow btn-lg" data-toggle="modal" data-target="#ratingModal">Rate this Workshop</button>
            
            @else
            <button class="mt-4 btn text-white background-yellow btn-lg" data-toggle="modal" data-target="#ratingModal" disabled>Rate this Workshop</button>
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

<!-- rating -->
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rate This Workshop</h5>

      </div>
      <div class="modal-body text-center">
        <form method="POST" action="{{ route('workshops.rate') }}">
            {{csrf_field()}}
            <input type="hidden" name="workshop_id" value="{{$workshop->id}}">
            <label for="">Workshop rating</label>
            <div class="rating mb-3">
                <label>
                    <input type="radio" name="workshopRating" class="d-none" value="5" title="5 stars" required>
                </label>
                <label>
                    <input type="radio" name="workshopRating" class="d-none" value="4" title="4 stars">
                </label>
                <label>
                    <input type="radio" name="workshopRating" class="d-none" value="3" title="3 stars">
                </label>
                <label>
                    <input type="radio" name="workshopRating" class="d-none" value="2" title="2 stars">
                </label>
                <label>
                    <input type="radio" name="workshopRating" class="d-none" value="1" title="1 star">
                </label>
            </div>

            <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white">Submit</button>
        </form>

      </div>

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

                <form id="jobPost" action="{{ route('workshops.register') }}" method="POST" class="mb-5" name="jobPost">
                    @csrf
                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>Name<span class="text-danger font-weight-bold"> *</span>:</label>
                            @if(Auth::user())
                            <input type="hidden" name="id" value="{{Auth::user()->id}}">
                            <input type="hidden" name="workshop_id" value="{{$workshop->id}}">
                            @endif
                            <input id="title" type="text" class="form-control border-yellow" value="{{$formData ? $formData['name'] : ''}}" name="name" placeholder="Name" required>
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Gender<span class="text-danger font-weight-bold"> *</span>:</label>
                            <select class="form-control border-yellow" name="gender" id="gender" required>
                                <option value="" disabled selected>-- Select Prefered Gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Not Specified">Prefer not to say</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Date of Birth<span class="text-danger font-weight-bold"> *</span>:</label>
                            <input  value="{{$formData ? $formData['dob'] : ''}}" id="dob" type="date" class="form-control border-yellow" name="dob" required>
                        </div>

                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>Phone<span class="text-danger font-weight-bold"> *</span>:</label>
                            <input  value="{{$formData ? $formData['phone'] : ''}}" id="phone" type="text" class="form-control border-yellow" name="phone" placeholder="Phone" required>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>Email<span class="text-danger font-weight-bold"> *</span>:</label>
                            <input value="{{$formData ?  $formData['email'] : ''}}" id="email" type="email" class="form-control border-yellow" name="email" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>From which institution have you completed your Bachelor's Degree?<span class="text-danger font-weight-bold"> *</span></label>
                            <input value="{{$formData ? $formData['institution'] : ''}}" id="institution" type="text" class="form-control border-yellow" name="institution" placeholder="From which institution have you completed your Bachelor's Degree?" required>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>In which year have you completed your Bachelor's Degree?<span class="text-danger font-weight-bold"> *</span></label>
                            <input value="{{$formData ? $formData['passing_year'] : ''}}" id="passing_year" type="text" class="form-control border-yellow" name="passing_year" placeholder="In which year have you completed your Bachelor's Degree?" required>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>In which subject have you completed your Bachelor's Degree?<span class="text-danger font-weight-bold"> *</span></label>
                            <input value="{{$formData ? $formData['subject'] : ''}}" id="subject" type="text" class="form-control border-yellow" name="subject" placeholder="In which subject have you completed your Bachelor's Degree?" required>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>What is your highest level of education?<span class="text-danger font-weight-bold"> *</span></label>
                            <input value="{{$formData ? $formData['education_level'] : ''}}" id="education_level" type="text" class="form-control border-yellow" name="education_level" placeholder="What is your highest level of education?" required>
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Are you a teacher?<span class="text-danger font-weight-bold"> *</span></label>
                            <select class="form-control border-yellow" name="is_teacher" id="is_teacher" required>
                                <option value="" disabled selected>-- Select --</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>For how many years are you in teaching profession?<span class="text-danger font-weight-bold"> *</span></label>
                            <input value="{{$formData ? $formData['years_teaching'] : ''}}" id="years_teaching" type="text" class="form-control border-yellow" name="years_teaching" placeholder="For how many years are you in teaching profession?" required>
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>In which institution are you teaching?<span class="text-danger font-weight-bold"> *</span></label>
                            <input value="{{$formData ? $formData['teaching_institution'] : ''}}" id="teaching_institution" type="text" class="form-control border-yellow" name="teaching_institution" placeholder="In which institution are you teaching?" required>
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>It is a/an<span class="text-danger font-weight-bold"> *</span></label>
                            <select class="form-control border-yellow" name="school_type" required>
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
                            <label>In which classes do you teach in your school?<span class="text-danger font-weight-bold"> *</span></label>
                            <select class="form-control" name="classes[]" id="classes" multiple="multiple" required>
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
                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Which subjects do you teach in your school?<span class="text-danger font-weight-bold"> *</span></label>
                            <select class="form-control" name="subjects[]" id="subjects" multiple="multiple" required>
                                <option value="Bangla">Bangla</option>
                                <option value="English">English</option>
                                <option value="Math">Math</option>
                                <option value="Social Science">Social Science</option>
                                <option value="Science">Science</option>
                                <option value="Physics">Physics</option>
                                <option value="Chemistry">Chemistry</option>
                                <option value="Biology">Biology</option>
                                <option value="Geography">Geography</option>
                                <option value="Religion">Religion</option>
                                <option value="ICT">ICT</option>
                                <option value="Accounting">Accounting</option>
                                <option value="Finance">Finance</option>
                                <option value="Marketing">Marketing</option>
                                <option value="History">History</option>
                                <option value="Health & Moral Education">Health & Moral Education</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Have you completed any training previously?<span class="text-danger font-weight-bold"> *</span></label>
                            <select class="form-control border-yellow" name="previous_training" required>
                                <option value="" disabled selected>-- Select --</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>Mention the training programs you have attended</label>
                            <input value="{{$formData ? $formData['training_programs'] : ''}}" id="training_programs" type="text" class="form-control border-yellow" name="training_programs" placeholder="Mention the training programs you have attended">
                        </div>
                    </div>
                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>Mention a topic that you want us to cover in our next online workshop<span class="text-danger font-weight-bold"> *</span></label>
                            <input value="{{$formData ? $formData['online_workshop'] : ''}}" id="online_workshop" type="text" class="form-control border-yellow" name="online_workshop" placeholder="Mention a topic that you want us to cover in our next online workshop" required>
                        </div>
                    </div>
                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Are you a teacher ambassador of 'Alokito Teachers'?<span class="text-danger font-weight-bold"> *</span></label>
                            <select class="form-control border-yellow" name="ambassador" required>
                                <option value="" disabled selected>-- Select --</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-4">
                        <div class="col-md-12">
                            <label>Reference of the teacher ambassador (Alokito Teachers) (if any)</label>
                            <input id="ambassador_ref" value="{{$formData ? $formData['ambassador_ref'] : ''}}" type="text" class="form-control border-yellow" name="ambassador_ref" placeholder="Reference of the teacher ambassador (Alokito Teachers) (if any)">
                        </div>
                    </div>
                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>From where did you know about this workshop?<span class="text-danger font-weight-bold"> *</span></label>
                            <select class="form-control" name="lead" id="lead" required>
                                <option value="Collegue">Collegue</option>
                                <option value="Facebook Add">Facebook Add</option>
                                <option value="Alokito Teachers Facebook Page">Alokito Teachers Facebook Page</option>
                                <option value="School">School</option>
                                <option value="Alokito Teachers' Ambassador">Alokito Teachers' Ambassador</option>
                                <option value="Friends">Friends</option>
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
    $(".login-to-register").mouseover(function() {
        $(this).html("Login To Register");
    });
    $(".login-to-register").mouseout(function() {
        $(this).html("Register Now");
    });

    $('#classes').select2({
            multiple: true,
        });
        $('#subjects').select2({
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

    $('.rating input').change(function () {
        var $radio = $(this);
        $('.rating .selected').removeClass('selected');
        $radio.closest('label').addClass('selected');
    });
</script>

<script>
    document.forms['jobPost'].elements['gender'].value=`{{$formData['gender']}}`;
    document.forms['jobPost'].elements['is_teacher'].value=`{{$formData['is_teacher']}}`;
    document.forms['jobPost'].elements['school_type'].value=`{{$formData['school_type']}}`;
    document.forms['jobPost'].elements['previous_training'].value=`{{$formData['previous_training']}}`;
    document.forms['jobPost'].elements['ambassador'].value=`{{$formData['ambassador']}}`;
    document.forms['jobPost'].elements['lead'].value=`{{$formData['lead']}}`;
    
</script>

@endpush

@endsection
