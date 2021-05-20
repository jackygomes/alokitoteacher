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

<header class="container mt-5" style="min-height: 62vh">

    <div class="row">
        <div class="col-sm-8">
          <h2 class="font-weight-bold text-yellow">২১ শতকের দক্ষ শিক্ষক এবং শিক্ষার্থী গড়ে তোলার লক্ষ্যে আপনার আলোকিত যাত্রা শুরু করুন</h2>
          <!--<h4 class="font-weight-bold mt-4">আপনার আলোকিতোর যাত্রা শুরু করুন</h4>-->
        </div>

        <div class="col-sm-4">
           <img src="{{asset('images\logo\alokito_logo.png')}}" class="img-responsive">
        </div>
      </div>



      <div class="row  mb-5 mt-5 justify-content-center">

        <div class="col-md-5">
          <p class="text-center font-weight-bold mt-5" style="font-size: 1.3rem;"> I Would Like To Learn:</p>
          <div class="border border-yellow px-5 py-2 text-center rounded" style="font-size: 16px; ">
            <div class="col-md-12 col-md-offset-1 ">
              <p class="font-weight-bold ">View All Courses and toolkit</p>
              <div class=""><a href="{{ url('all') }}" class="btn btn-warning text-white" style="background-color: #f5b82f">Be a member and learn with us</a></div>
            </div>
          </div>
        </div>
        <div class="col-md-1">

        </div>

        <div class="col-md-5 text-center">
          <p class="font-weight-bold mt-5" style="font-size: 1.3rem;"> I Would Like To Search Job:</p>
          <div class="border border-yellow px-5 py-2 text-center rounded" style="font-size: 16px; ">
            <div class="col-md-12 col-md-offset-1 ">
              <p class="font-weight-bold ">View Jobs</p>
              <div class=""><a href="{{ url('jobs') }}" class="btn btn-warning text-white" style="background-color: #f5b82f">Become an Alokito Teacher</a></div>
            </div>
          </div>
        </div>
        <div class="col-md-2 ">

        </div>
      </div>

</header>

<section class="container-fluid">
    <div class="row background-yellow py-5">
      <div class="col-md-8 text-center">
          <div class="text mt-4 text-white text-center ">
              <h2 class="font-weight-bold">বিস্তারিত জানতে ভিডিওটি দেখুন</h2>
          </div>
      </div>

      <div class="col-md-4 text-center picture">
          <a href="#" class="" style="color: #ffffff;" data-toggle="modal" data-target="#homeVideo">
           <!--<i class=" fas fa-play-circle mt-4" style="background: #f5b82f; font-size: 70px;"></i> -->
           <div class="zoom">
              <img class="border border-success" src="{{asset('images\logo\wat3.jpg')}}" style="width:50%">
           </div>

          </a>
      </div>
    </div>
</section>


<!--Start of Fun Factor Area-->
<div class="container-fluid">
  <div class="fun-factor-area text-center fix" style="background: #f9f9f9 url({{ url('images/logo/sec-bg.png')}}) !important;">
      <div class="container">
          <div class=" row fun">
              <div class="col-sm-6" >
                  <div class="single-fun-factor">

                      <h1><span class="counter-count text-yellow font-weight-bold">{{$stat->teacher}}</span></h1>
                      <p class="counter-name">Educators Trained</p>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="single-fun-factor">

                      <h1><span class="counter-count text-yellow font-weight-bold">{{$stat->future_number}}</span></h1>
                      <p class="counter-name">Future Changemakers Being Developed</p>
                  </div>
              </div>

          </div>
        </div>
      </div>
  </div>
  <!--End of Fun Factor Area-->

{{--new design--}}
{{--course--}}
<div class="explore-teaching">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2 class="text-center font-weight-bold">Explore Teaching Courses</h2>
                <button class="btn text-center background-yellow mt-3"><a class="text-white font-weight-bold px-3" href="{{ url('login') }}">Explore More</a></button>
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

                                <p class="card-title text-dark font-weight-bold" style="font-size: 19px">{{ str_limit(strip_tags($v_course_info->title), 22) }}</p>
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
<div class="explore-teaching dark-yellow-section text-white">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2 class="text-center font-weight-bold">Explore Teachers Toolkits</h2>
                <p>Make your teaching life easier and more effective by applying these creative methods and elements</p>
                <button class="btn text-center bg-white mt-3"><a class="text-dark font-weight-bold px-3" href="{{ url('login') }}">View All Toolkits</a></button>
            </div>
        </div>
        <div class="row">
            <div id="exploreToolkit" class="owl-carousel card-slider">
                @foreach ($toolkit_info as $toolkit)
                    <div class="item mt-5">
                        <a href="{{ url('view') }}/t/{{$toolkit->slug}}">
                            <div class="card">
                                <img src="{{url('images\thumbnail')}}\{{ $toolkit->thumbnail }}" style="height: 262px;" class="card-img-top">
                                <div class="card-body">

                                    <p class="card-title text-dark font-weight-bold" style="font-size: 19px">{{ str_limit(strip_tags($toolkit->toolkit_title), 22) }}</p>
                                    <hr>
                                    <p class="card-text text-light-dark">Posted By <strong class="text-dark">{{ str_limit(strip_tags($toolkit->name), 20) }}</strong></p>

                                    <div class="text-dark">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($toolkit->rating - $i >= 0)
                                                <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                            @else
                                                <i class="far fa-star text-light-dark"></i>
                                            @endif
                                        @endfor
                                        <span class="float-right text-success font-weight-bold">
                                        @if($toolkit->isBought == 1)
                                                Owned
                                            @else
                                                @if($toolkit->price == 0)
                                                    Free
                                                @else
                                                    {{ round($toolkit->price, 2)}} BDT
                                                @endif
                                            @endif
                                    </span>
                                    </div>

                                </div>
                                {{--                            <div class="card-footer" style="background:--}}
                                {{--                            @if($toolkit->isBought == 1)--}}
                                {{--                                #98b59d;--}}
                                {{--                            @else--}}
                                {{--                                #51b964;--}}
                                {{--                            @endif--}}
                                {{--                                ">--}}
                                {{--                                <h5 class="text-white text-center">--}}
                                {{--                                    @if($toolkit->isBought == 1)--}}
                                {{--                                        Owned--}}
                                {{--                                    @else--}}
                                {{--                                        @if($toolkit->price == 0)--}}
                                {{--                                            Free--}}
                                {{--                                        @else--}}
                                {{--                                            {{ round($toolkit->price, 2)}} BDT--}}
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
{{--toolkit end--}}

{{--resource--}}
<div class="explore-teaching">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2 class="text-center font-weight-bold">Explore Teaching Resources</h2>
                <button class="btn text-center background-yellow mt-3"><a class="text-white font-weight-bold px-3" href="{{ url('login') }}">View All Resources</a></button>
            </div>
        </div>
        <div class="row">
            <div id="exploreResource" class="owl-carousel card-slider">
                @foreach ($resources as $resource)
                    <div class="item mt-5">
                        <a href="{{ url('view') }}/c/{{$resource->slug}}">
                            <div class="card">
                                <img src="{{url('images\thumbnail')}}\{{ $resource->thumbnail }}" style="height: 262px;" class="card-img-top">
                                <div class="card-body">

                                    <p class="card-title text-dark font-weight-bold" style="font-size: 19px">{{ str_limit(strip_tags($resource->resource_title), 22) }}</p>
                                    <hr>
                                    <p class="card-text text-light-dark">Posted By <strong class="text-dark">{{ str_limit(strip_tags($resource->user->name), 20) }}</strong></p>

                                    <div class="text-dark">
{{--                                        @for($i = 1; $i <= 5; $i++)--}}
{{--                                            @if($resources->rating - $i >= 0)--}}
{{--                                                <i class="fa fa-star checked-yellow" aria-hidden="true"></i>--}}
{{--                                            @else--}}
{{--                                                <i class="far fa-star text-light-dark"></i>--}}
{{--                                            @endif--}}
{{--                                        @endfor--}}
                                        <span class="float-left text-success font-weight-bold">
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
<div class="container-fluid pb-5 home-leaderboard">
  <div class="row">
    <div class="col-md-12">
      <div class="teachers-toolkits">
        <h2 class="font-weight-bold text-center mt-5 mb-5 text-dark">Leaderboard</h2>
          <div class="d-flex justify-content-center">
              <div class="col-md-4">
                  <div class="top-3 mt-4 text-center">
                      <div class="second top-3-card">
                          <div class="image">
                              @if($leaderBoard[2]['user']->image == null)
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                              @else
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/{{$leaderBoard[2]['user']->image}}">
                              @endif
                              <span class="position">2</span>
                          </div>
                          <div class="content">
                              <p class="m-0">{{ str_limit(strip_tags($leaderBoard[2]['user']->name), 10) }}</p>
                              <p class="m-0">{{ $leaderBoard[2]->score }} points</p>
                          </div>
                      </div>
                      <div class="first top-3-card">
                          <div class="image">
                              @if($leaderBoard[1]['user']->image == null)
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                              @else
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/{{$leaderBoard[1]['user']->image}}">
                              @endif
                                  <span class="position background-yellow">1</span>
                                  <img class="crown" src="{{asset('images/new_design/crown.png')}}" alt="">
                          </div>
                          <div class="content">
                              <p class="m-0">{{ str_limit(strip_tags($leaderBoard[1]['user']->name), 10) }}</p>
                              <p class="m-0">{{ $leaderBoard[1]->score }} points</p>
                          </div>
                      </div>
                      <div class="third top-3-card">
                          <div class="image">
                              @if($leaderBoard[3]['user']->image == null)
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                              @else
                                  <img class="img-fluid rounded-circle" src="{{ url('images/profile_picture') }}/{{$leaderBoard[3]['user']->image}}">
                              @endif
                              <span class="position">3</span>
                          </div>
                          <div class="content">
                              <p class="m-0">{{ str_limit(strip_tags($leaderBoard[3]['user']->name), 10) }}</p>
                              <p class="m-0">{{ $leaderBoard[3]->score }} points</p>
                          </div>
                      </div>
                  </div>
                  <ul>
                  @foreach ($leaderBoard as $key =>$leader)
                      @if($key > 3)

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


<div class="container alokito-journey">
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
    <script>
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
        $('#exploreToolkit').owlCarousel({
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
        })
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
        })
    </script>
@endpush

@endsection

