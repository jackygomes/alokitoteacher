@extends('master')

@section('content')


<!-- Page Content -->

<style type="text/css">
  .modal-dialog {
      max-width: 800px;
      margin: 30px auto;
  }
  .modal-body {
    position:relative;
    padding:0px;
  }
  .close {
    position:absolute;
    right:-30px;
    top:0;
    z-index:999;
    font-size:2rem;
    font-weight: normal;
    color:#fff;
    opacity:1;
  }
</style>

<div class="home-hero-slider">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="headerSlider" class="owl-carousel">
                    <div class="home-hero-slider-wrap d-flex justify-content-between">
                        <div class="left">
                            <h1 class="font-weight-bold">Problem-based Learning</h1>
                            <p class="pb-0 mb-0">In this course, we will discuss what is Problem-based Learning (PbL), what are the steps to follow in PbL, what will be a teacher's role in PbL and how will you assess students in PbL.</p>
                            <div class="buttons mt-5">
                                <a class="btn background-yellow px-5 py-3 text-white" href="{{ url('view') }}/c/problem-based-learning-O2Vk1SIHe3">Enrol Now</a>
{{--                                <a class="btn px-5 py-3 mr-2 text-black login-button" href="#">Explore Jobs</a>--}}
                            </div>
                        </div>
                        <div class="right">
                            <img src="{{asset('images/new_design/pbl.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="home-hero-slider-wrap d-flex justify-content-between">
                        <div class="left">
                            <h1 class="font-weight-bold">21st Century Classroom</h1>
                            <p class="pb-0 mb-0">In this course we will discuss what is the 21st century classroom, how does it look like and how can a teacher transform his/her classroom to a 21st century classroom.</p>
                            <div class="buttons mt-5">
                                <a class="btn background-yellow px-5 py-3 text-white" href="{{ url('view') }}/c/21st-century-classroom-Fpu9a1">Enrol Now</a>
{{--                                <a class="btn px-5 py-3 mr-2 text-black login-button" href="#">Explore Jobs</a>--}}
                            </div>
                        </div>
                        <div class="right">
                            <img src="{{asset('images/new_design/21st.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="home-hero-slider-wrap d-flex justify-content-between">
                        <div class="left">
                            <h1 class="font-weight-bold">Game-based Learning</h1>
                            <p class="pb-0 mb-0">In this course, we will discuss what is Game-based Learning (GbL), how can a lesson be taught using GbL and how will you assess students in GbL.</p>
                            <div class="buttons mt-5">
                                <a class="btn background-yellow px-5 py-3 text-white" href="{{ url('view') }}/c/game-based-learning-wKZ1DSase1">Enrol Now</a>
                                {{--                                <a class="btn px-5 py-3 mr-2 text-black login-button" href="#">Explore Jobs</a>--}}
                            </div>
                        </div>
                        <div class="right">
                            <img src="{{asset('images/new_design/GbL.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="home-hero-slider-wrap d-flex justify-content-between">
                        <div class="left">
                            <h1 class="font-weight-bold">Class Management</h1>
                            <p class="pb-0 mb-0">In this course we will talk about different aspects of classroom management which includes preventative and corrective measures as well as importance of building good relationships with student.</p>
                            <div class="buttons mt-5">
                                <a class="btn background-yellow px-5 py-3 text-white" href="{{ url('view') }}/c/class-management-XtTZUr">Enrol Now</a>
                                {{--                                <a class="btn px-5 py-3 mr-2 text-black login-button" href="#">Explore Jobs</a>--}}
                            </div>
                        </div>
                        <div class="right">
                            <img src="{{asset('images/new_design/CM.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="home-hero-slider-wrap d-flex justify-content-between">
                        <div class="left">
                            <h1 class="font-weight-bold">Psychological Development of Students</h1>
                            <p class="pb-0 mb-0">In this course we will talk about the importance of proper psychological development and share techniques to build empathy, self-confidence, resilience and grit within our students.</p>
                            <div class="buttons mt-5">
                                <a class="btn background-yellow px-5 py-3 text-white" href="{{ url('view') }}/c/psychological-development-of-students-YQg9yW">Enrol Now</a>
                                {{--                                <a class="btn px-5 py-3 mr-2 text-black login-button" href="#">Explore Jobs</a>--}}
                            </div>
                        </div>
                        <div class="right">
                            <img src="{{asset('images/new_design/Psy.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="home-hero-slider-wrap d-flex justify-content-between">
                        <div class="left">
                            <h1 class="font-weight-bold">Inquiry-based Learning</h1>
                            <p class="pb-0 mb-0">In this course, we will discuss what is Inquiry-based Learning (IbL), what are the steps to follow in IbL, what will be a teacher's role in IbL and how will you assess students in IbL.</p>
                            <div class="buttons mt-5">
                                <a class="btn background-yellow px-5 py-3 text-white" href="{{ url('view') }}/c/inquiry-based-learning-IhDGWbSNdh">Enrol Now</a>
                                {{--                                <a class="btn px-5 py-3 mr-2 text-black login-button" href="#">Explore Jobs</a>--}}
                            </div>
                        </div>
                        <div class="right">
                            <img src="{{asset('images/new_design/IbL.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="home-hero-slider-wrap d-flex justify-content-between">
                        <div class="left">
                            <h1 class="font-weight-bold">Math Pedagogy</h1>
                            <p class="pb-0 mb-0">This course contains tips to introduce basic math concepts to primary students.</p>
                            <div class="buttons mt-5">
                                <a class="btn background-yellow px-5 py-3 text-white" href="{{ url('view') }}/c/math-pedagogy-f4lYZe">Enrol Now</a>
                                {{--                                <a class="btn px-5 py-3 mr-2 text-black login-button" href="#">Explore Jobs</a>--}}
                            </div>
                        </div>
                        <div class="right">
                            <img src="{{asset('images/new_design/MP.jpg')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{--new design--}}
{{--statistics--}}
<div class="container statistic-section">
    <div class="row">
        <div class="col-md-4">
            <div class="stat-block">
                <div>
                    <img src="{{asset('images/new_design/feature-icon-1.png')}}" alt="">
                </div>
                <div>
                    <h3 class="font-weight-bold">{{$stat->teacher}}</h3>
                    <p>Teachers Trained</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-block">
                <div>
                    <img src="{{asset('images/new_design/feature-icon-2.png')}}" alt="">
                </div>
                <div>
                    <h3 class="font-weight-bold">{{$stat->future_number}}</h3>
                    <p>Changemakers Developed</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-block">
                <div>
                    <img src="{{asset('images/new_design/feature-icon-3.png')}}" alt="">
                </div>
                <div>
                    <h3 class="font-weight-bold">100+</h3>
                    <p>Courses Created</p>
                </div>
            </div>
        </div>
    </div>
</div>
{{--statistics end--}}
{{--video section--}}
<div class="video-section" style="background-image: url('{{asset('images/new_design/line_wave.png')}}')">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2 class="text-center font-weight-bold mb-5">Watch the video for details.</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="hero text-center">
                    <a class="hero__play" href="#nogo">
                        <img src="{{asset('images/new_design/video-thumbnail-final.jpg')}}"/>
                        <img class="play-button" src="{{asset('images/new_design/video-section-play.png')}}"/>
                    </a>
                </div>

                <!-- The following is only needed when the video is in the html
                    otherwise the who .hero__overlay html can be removed -->
                <div class="hero__overlay">
                    <div class="hero__modal">
                        <a class="hero__close" href="#">Close</a>

                        <iframe allowscriptaccess="always" id="hero-video" class="hero__player" src="https://www.youtube.com/embed/MTBDnRDdE_E?enablejsapi=1&html5=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

                    </div><!-- /.hero__modal -->
                </div><!-- /.hero__overlay -->
            </div>
        </div>
    </div>
</div>
{{--video section end--}}
{{--course--}}
<div class="explore-teaching">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2 class="text-center font-weight-bold">Explore Teaching Courses</h2>
                <a href="{{ url('course') }}" class="mt-3 btn text-center background-yellow text-white font-weight-bold home-explore-button">Explore More</a>
            </div>
        </div>
        <div class="row">
            <div id="exploreCourse" class="owl-carousel card-slider">
            @foreach ($course_info as $v_course_info)
                <div class="item mt-5">
                    <a href="{{ url('view') }}/c/{{$v_course_info->slug}}">
                        <div class="card">
                            <img src="{{url('images\thumbnail')}}\{{ $v_course_info->thumbnail }}" style="height: 262px;" class="card-img-top">
                            <div class="card-body">
                                @if(strlen($v_course_info->title) < 26)
                                <p class="card-title text-dark font-weight-bold mb-0" style="font-size: 20px">{{ str_limit(strip_tags($v_course_info->title), 26) }}</p>
                                @else
                                <div class="ticker-wrap">
                                    <div class="ticker">
                                        <div class="ticker__item card-title text-dark font-weight-bold mb-0">
                                            {{$v_course_info->title}}</div>
                                    </div>
                                </div>
                                @endif
                                <p class="text-light-dark">{{$v_course_info->lessons}} Lessons</p>
                                <hr>
                                <p class="card-text text-light-dark">Posted By <strong class="text-dark">{{ str_limit(strip_tags($v_course_info->name), 20) }}</strong></p>

                                <div class="text-dark">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($v_course_info->rating - $i >= 0)
                                            <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                        @else
                                            <i class="far fa-star text-light-dark"></i>
                                        @endif
                                    @endfor
                                    ({{$v_course_info->rating_count}})
                                    <span class="float-right text-success font-weight-bold">
                                        @if($v_course_info->isBought == 1)
                                            Owned
                                        @else
                                            @if($v_course_info->price == 0)
                                                Free
                                            @else
                                                {{ round($v_course_info->price, 2)}} BDT
                                            @endif
                                        @endif
                                    </span>
                                </div>

                            </div>
{{--                            <div class="card-footer" style="background:--}}
{{--                            @if($v_course_info->isBought == 1)--}}
{{--                                #98b59d;--}}
{{--                            @else--}}
{{--                                #51b964;--}}
{{--                            @endif--}}
{{--                                ">--}}
{{--                                <h5 class="text-white text-center">--}}
{{--                                    @if($v_course_info->isBought == 1)--}}
{{--                                        Owned--}}
{{--                                    @else--}}
{{--                                        @if($v_course_info->price == 0)--}}
{{--                                            Free--}}
{{--                                        @else--}}
{{--                                            {{ round($v_course_info->price, 2)}} BDT--}}
{{--                                        @endif--}}
{{--                                    @endif--}}
{{--                                </h5>--}}
{{--                            </div>--}}
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
{{--course end--}}

{{--toolkit--}}
{{--<div class="explore-teaching dark-yellow-section text-white">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-sm-12 text-center">--}}
{{--                <h2 class="text-center font-weight-bold">Explore Teachers Toolkits</h2>--}}
{{--                <p>Make your teaching life easier and more effective by applying these creative methods and elements</p>--}}
{{--                <button class="btn text-center bg-white mt-3"><a class="text-dark font-weight-bold px-3" href="{{ url('login') }}">View All Toolkits</a></button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row">--}}
{{--            <div id="exploreToolkit" class="owl-carousel card-slider">--}}
{{--                @foreach ($toolkit_info as $toolkit)--}}
{{--                    <div class="item mt-5">--}}
{{--                        <a href="{{ url('view') }}/t/{{$toolkit->slug}}">--}}
{{--                            <div class="card">--}}
{{--                                <img src="{{url('images\thumbnail')}}\{{ $toolkit->thumbnail }}" style="height: 262px;" class="card-img-top">--}}
{{--                                <div class="card-body">--}}

{{--                                    <p class="card-title text-dark font-weight-bold" style="font-size: 19px">{{ str_limit(strip_tags($toolkit->toolkit_title), 22) }}</p>--}}
{{--                                    <hr>--}}
{{--                                    <p class="card-text text-light-dark">Posted By <strong class="text-dark">{{ str_limit(strip_tags($toolkit->name), 20) }}</strong></p>--}}

{{--                                    <div class="text-dark">--}}
{{--                                        @for($i = 1; $i <= 5; $i++)--}}
{{--                                            @if($toolkit->rating - $i >= 0)--}}
{{--                                                <i class="fa fa-star checked-yellow" aria-hidden="true"></i>--}}
{{--                                            @else--}}
{{--                                                <i class="far fa-star text-light-dark"></i>--}}
{{--                                            @endif--}}
{{--                                        @endfor--}}
{{--                                        <span class="float-right text-success font-weight-bold">--}}
{{--                                        @if($toolkit->isBought == 1)--}}
{{--                                                Owned--}}
{{--                                            @else--}}
{{--                                                @if($toolkit->price == 0)--}}
{{--                                                    Free--}}
{{--                                                @else--}}
{{--                                                    {{ round($toolkit->price, 2)}} BDT--}}
{{--                                                @endif--}}
{{--                                            @endif--}}
{{--                                    </span>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--toolkit end--}}

{{--resource--}}
<div class="explore-teaching dark-yellow-section text-white">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2 class="text-center font-weight-bold">Explore Teaching Innovations</h2>
                <a href="{{ route('resource.create') }}" class="btn mt-3 text-center bg-white text-dark font-weight-bold home-explore-button">Submit My Innovation</a>
                <a href="{{ route('allResource') }}" class="btn mt-3 text-center bg-white text-dark font-weight-bold home-explore-button">View All Innovations</a>
            </div>
        </div>
        <div class="row">
            <div id="exploreResource" class="owl-carousel card-slider">
                @foreach ($resources as $resource)
                    <div class="item mt-5">
                        <a href="{{ url('overview') }}/r/{{$resource->slug}}">
                            <div class="card">
                                <div class="img-wrap">
                                    <img src="{{url('images\thumbnail')}}\{{ $resource->thumbnail }}" style="height: 262px;" class="card-img-top">
                                    <div class="overlay">
                                        <span>Read & Rate</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(strlen($resource->resource_title) < 26)
                                        <p class="card-title text-dark font-weight-bold mb-0" style="font-size: 20px">{{ str_limit(strip_tags($resource->resource_title), 26) }}</p>
                                    @else
                                        <div class="ticker-wrap">
                                            <div class="ticker">
                                                <div class="ticker__item card-title text-dark font-weight-bold mb-0">
                                                    {{$resource->resource_title}}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <hr>
                                    <p class="card-text text-light-dark">Posted By <strong class="text-dark">{{ str_limit(strip_tags($resource->user->name), 20) }}</strong></p>

                                    <div class="text-dark">
                                        @for($i = 0; $i < 5; $i++)
                                            @if(round($resource->ratingCount->avg('rating')) - $i > 0)
                                                <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                            @else
                                                <i class="far fa-star text-light-dark"></i>
                                            @endif
                                        @endfor
                                        ({{$resource->ratingCount->count()}})
                                        <span class="float-right text-success font-weight-bold">
                                        @if($resource->isBought == 1)
                                                Owned
                                            @else
                                                @if($resource->price == 0)
                                                    Free
                                                @else
                                                    {{ round($resource->price, 2)}} BDT
                                                @endif
                                            @endif
                                    </span>
                                    </div>

                                </div>
                                {{--                            <div class="card-footer" style="background:--}}
                                {{--                            @if($v_course_info->isBought == 1)--}}
                                {{--                                #98b59d;--}}
                                {{--                            @else--}}
                                {{--                                #51b964;--}}
                                {{--                            @endif--}}
                                {{--                                ">--}}
                                {{--                                <h5 class="text-white text-center">--}}
                                {{--                                    @if($v_course_info->isBought == 1)--}}
                                {{--                                        Owned--}}
                                {{--                                    @else--}}
                                {{--                                        @if($v_course_info->price == 0)--}}
                                {{--                                            Free--}}
                                {{--                                        @else--}}
                                {{--                                            {{ round($v_course_info->price, 2)}} BDT--}}
                                {{--                                        @endif--}}
                                {{--                                    @endif--}}
                                {{--                                </h5>--}}
                                {{--                            </div>--}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
{{--resource end--}}
{{--new design end--}}

<!--Leaderboard Area-->
<div class="container-fluid pb-5 home-leaderboard mb-4">
  <div class="row">
    <div class="col-md-12">
      <div class="teachers-toolkits">
        <h2 class="font-weight-bold text-center mt-5 mb-5 text-dark pt-5">Leaderboard</h2>
          <div class="d-flex justify-content-center">
              <div class="col-md-6">
                  <div class="top-3 mt-4 text-center">
                      <div class="second top-3-card">
                          <div class="image">
                              @if($leaderBoard[1]['user']->image == null)
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                              @else
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/{{$leaderBoard[1]['user']->image}}">
                              @endif
                              <span class="position">2</span>
                          </div>
                          <div class="content">
                              <p class="m-0">{{ str_limit(strip_tags($leaderBoard[1]['user']->name), 16) }}</p>
                              <p class="m-0">{{ $leaderBoard[1]->score }} points</p>
                          </div>
                      </div>
                      <div class="first top-3-card">
                          <div class="image">
                              @if($leaderBoard[0]['user']->image == null)
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                              @else
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/{{$leaderBoard[0]['user']->image}}">
                              @endif
                                  <span class="position background-yellow">1</span>
                                  <img class="crown" src="{{asset('images/new_design/crown.png')}}" alt="">
                          </div>
                          <div class="content">
                              <p class="m-0">{{ str_limit(strip_tags($leaderBoard[0]['user']->name), 16) }}</p>
                              <p class="m-0">{{ $leaderBoard[0]->score }} points</p>
                          </div>
                      </div>
                      <div class="third top-3-card">
                          <div class="image">
                              @if($leaderBoard[2]['user']->image == null)
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                              @else
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/{{$leaderBoard[2]['user']->image}}">
                              @endif
                              <span class="position">3</span>
                          </div>
                          <div class="content">
                              <p class="m-0">{{ str_limit(strip_tags($leaderBoard[2]['user']->name), 16) }}</p>
                              <p class="m-0">{{ $leaderBoard[2]->score }} points</p>
                          </div>
                      </div>
                  </div>
                  <ul>
                  @foreach ($leaderBoard as $key =>$leader)
                      @if($key > 2)

                          <li>
                              <a href="{{ url('t')}}/{{ $leader['user']->username }}">
                               <div class="serial">{{$key + 1}}.</div>
                               <div class="image">
                                   @if($leader['user']->image == null)
                                       <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                                   @else
                                       <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/profile_picture') }}/{{ $leader['user']->image }}">
                                   @endif
                               </div>
                               <div class="name">{{ $leader['user']->name }}</div>
                               <div class="points">{{$leader->score}} points</div>
                              </a>
                          </li>

                      @endif
                  @endforeach
                  </ul>
              </div>
          </div>

      </div>
    </div>
  </div>
</div>
<!-- Leaderboar area ends -->

<!-- <div class="alokito-journey">
    <div class="container">
        <h2 class="text-center font-weight-bold text-dark mb-4">Your Alokito Journey</h2>
        <div class="row">
            <div class="col-md-6 mt-5">
                <div class="media">
                    <img class="mr-3" src="{{asset('images/new_design/step-icon-1.png')}}" alt="Generic placeholder image">
                    <div class="media-body">
                        <span class="text-uppercase">Step 1</span>
                        <h5 class="mt-2 font-weight-bold">Create Account</h5>
                        <p>You can get all the courses and toolkits by registration <br> in our platform.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="media">
                    <img class="mr-3" src="{{asset('images/new_design/step-icon-2.png')}}" alt="Generic placeholder image">
                    <div class="media-body">
                        <span class="text-uppercase">Step 2</span>
                        <h5 class="mt-2 font-weight-bold">Earn Certificates</h5>
                        <p>To earn money by creating your own toolkit you have to complete our 5 classroom toolkit and 1 course first.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="media">
                    <img class="mr-3" src="{{asset('images/new_design/step-icon-3.png')}}" alt="Generic placeholder image">
                    <div class="media-body">
                        <span class="text-uppercase">Step 3</span>
                        <h5 class="mt-2 font-weight-bold">Share and Earn</h5>
                        <p>You can earn by creating your own course, worksheet, toolkit and by sharing with others.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="media">
                    <img class="mr-3" src="{{asset('images/new_design/step-icon-4.png')}}" alt="Generic placeholder image">
                    <div class="media-body">
                        <span class="text-uppercase">Step 4</span>
                        <h5 class="mt-2 font-weight-bold">Become an Online Trainer</h5>
                        <p>You can make course and earn from it if at least 10 users view your course.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

 <!-- journey ends area -->
<div class="container px-0">
    <div class="teachAtAlokito" style="background-image: url('{{asset('images/new_design/journey_line.png')}}')">
        <h1 class="text-center text-white font-weight-bold mb-3">Teach at Alokito</h1>
        <p class="text-center text-white mb-3">Share Your Creativity. Earn money. Grow with us</p>
        <div class="d-flex justify-content-center">
            <button class="btn text-center background-yellow mt-3"><a class="text-white font-weight-bold px-3" href="{{ url('about_us') }}">Learn More</a></button>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="homeVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <!-- 16:9 aspect ratio -->
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/350048312?autoplay=0&loop=1&aut" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js"></script>
    <script>
        $('#headerSlider').owlCarousel({
            loop:true,
            margin:30,
            nav:false,
            autoplay:true,
            autoplayTimeout:4000,
            autoplayHoverPause:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
        $('#exploreCourse').owlCarousel({
            loop:false,
            margin:30,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:3
                }
            }
        });
        // $('#exploreToolkit').owlCarousel({
        //     loop:false,
        //     margin:30,
        //     nav:true,
        //     responsive:{
        //         0:{
        //             items:1
        //         },
        //         600:{
        //             items:3
        //         },
        //         1000:{
        //             items:3
        //         }
        //     }
        // });
        $('#exploreResource').owlCarousel({
            loop:false,
            margin:30,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:3
                }
            }
        });
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // global variable for the player
        var player;

        // this function gets called when API is ready to use
        function onYouTubePlayerAPIReady() {
            // create the global player from the specific iframe (#video)
            player = new YT.Player('hero-video',{
                events: {
                    'onReady': onPlayerReady,
                }
            });
        }



        function onPlayerReady(event) {

            var playBtn = $('.hero__play');
            var closeBtn = $('.hero__close');
            var overlay = $('.hero__overlay');
            var modal = $('.hero__modal');

            $(playBtn).click(function (e) {
                $(overlay).css('left', 0);
                $(overlay).addClass('hero__overlay--active');
                // player.api("play");
                player.playVideo();

                e.preventDefault();
            });

            $.merge(closeBtn, overlay).click(function (e) {
                $(overlay).removeClass('hero__overlay--active');
                setTimeout(function () {
                    $(overlay).css('left', '-100%');
                }, 300);
                player.stopVideo();

                e.preventDefault();

            });

            // Used for the full width videos
            $(modal).fitVids();

        }
    </script>
@endpush

@endsection

