
@extends('master')
@section('content')


<section class="container">
    <div class="row">
        <div class="col-lg-12">
           <h2 class="mt-3 text-center font-weight-bold">Workshops</h2>
        </div>
    </div>
</section>


<section>


    <div class="container">

        <div class="row">

            @foreach ($workshops as $workshop)
                <div class="col-md-4 mt-5">
                    <div class="card">
                        <a href="{{ route('workshops.overview',$workshop->slug) }}">
                            <img src="{{url('images\thumbnail')}}\{{ $workshop->thumbnail }}" style="height: 262px;" class="card-img-top">
                        </a>
                        <div class="card-body">
                            <a href="{{ route('workshops.overview',$workshop->slug) }}">
                                @if(strlen($workshop->name) < 26)
                                    <p class="card-title text-dark font-weight-bold mb-0" style="font-size: 20px">{{ str_limit(strip_tags($workshop->name), 26) }}</p>
                                @else
                                    <div class="ticker-wrap">
                                        <div class="ticker">
                                            <div class="ticker__item card-title text-dark font-weight-bold mb-0">
                                                {{$workshop->name}}</div>
                                        </div>
                                    </div>
                                @endif
                            </a>
                            {{-- <p class="text-light-dark">{{$v_course_info->lessons}} Lessons</p> --}}
                            <hr>
                            <p class="card-text text-light-dark">Posted By <strong class="text-dark">Alokito</strong></p>

                            <div class="text-dark">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($workshop->rating - $i >= 0)
                                        <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                    @else
                                        <i class="far fa-star text-light-dark"></i>
                                    @endif
                                @endfor
                                ({{$workshop->ratingCount}}) 
                                {{-- <span class="float-right text-success font-weight-bold">
                                    @if($v_course_info->isBought == 1)
                                        Owned
                                    @else
                                        @if($v_course_info->price == 0)
                                            Free
                                        @else
                                            {{ round($v_course_info->price, 2)}} BDT
                                        @endif
                                    @endif
                                </span> --}}
                            </div>
                            <div class="text-dark">
                                <div class="card-rating"><i class="fa fa-star text-white" aria-hidden="true"></i> <span>{{round($workshop->rating, 2)}} ({{$workshop->ratingCount}})</span></div>
                                <span class="float-right text-success font-weight-bold">
                                    @if($workshop->price == 0)
                                        Free
                                    @else
                                        {{ round($workshop->price, 2)}} BDT
                                    @endif
                                </span>
                            </div>
                            <div class="register-button">
                                @if(Auth::user())
                                <button type="button" class="mt-4 btn text-white background-yellow btn-lg btn-block" data-toggle="modal" data-target="#addJobModal_{{$workshop->id}}">Register Now</button>
                                @else
                                    <a href="{{ route('workshops.registerLogin', 'no-slug|'.$workshop->id) }}" class="login-to-register mt-4 btn text-white background-yellow btn-lg btn-block">Register Now</a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addJobModal_{{$workshop->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
            @endforeach
        </div>

        <div class="mt-5">
           {{$workshops->links()}}
         </div>
    </div>
    
</section>
@push('js')
<script>
    $(".login-to-register").mouseover(function() {
        $(this).html("Login To Register");
    });
    $(".login-to-register").mouseout(function() {
        $(this).html("Register Now");
    });
    let workshop_id = "<?php echo $workshopId; ?>";
    $("#addJobModal_"+workshop_id).modal('show');
</script>
@endpush
@endsection










