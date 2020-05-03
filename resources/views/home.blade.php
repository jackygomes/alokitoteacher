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


       <!-- <form class="form-inline pt-2">
          <div class="col-md-3">

              <div class="form-group">
                  <h6 class="font-weight-bold">Course</h6>
                  <input type="text" class="form-control is-valid border-yellow" placeholder="Course Name" >
              </div>
          </div>

          <div class="col-md-3">
              <h6 class="font-weight-bold">Subject</h6>
              <div class="form-group">
                  <input type="text" class="form-control is-valid border-yellow" placeholder="Pick Subject" >
              </div>
          </div>

          <div class="col-md-3 ">

                <div class="btn-group mt-4">
                  <button type="button" class="btn btn-dark dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Choose By Category
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Course</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Toolkit</a>
                  </div>
                </div>
          </div>

          <div class="col-md-3 col-sm-12 mt-4">
              <button type="submit" class="btn background-yellow text-white">Search</button>
          </div>

        </form> -->




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
        {{--<div class="col-md-1">--}}
          {{----}}
        {{--</div>--}}

        {{--<div class="col-md-5">--}}
          {{--<p class="font-weight-bold mt-5" style="font-size: 1.3rem;"> I Would Like To Search Job:</p>--}}
          {{--<div class="border border-yellow px-5 py-2 text-center rounded" style="font-size: 16px; ">--}}
            {{--<div class="col-md-12 col-md-offset-1 ">--}}
              {{--<p class="font-weight-bold ">View Jobs</p>--}}
              {{--<div class=""><a href="{{ url('jobs') }}" class="btn btn-warning text-white" style="background-color: #f5b82f">Become an Alokito Teacher</a></div>--}}
            {{--</div>--}}
          {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-md-2 ">--}}
          {{----}}
        {{--</div>--}}
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

                      <h1><span class="counter-count text-yellow font-weight-bold">250</span></h1>
                      <p class="counter-name">Teachers Trained</p>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="single-fun-factor">

                      <h1><span class="counter-count text-yellow font-weight-bold">6100</span></h1>
                      <p class="counter-name">Future Changemakers Being Developed</p>
                  </div>
              </div>

          </div>
        </div>
      </div>
  </div>
  <!--End of Fun Factor Area-->





<!--start of explore Area-->
  <div class="explore-teaching-courses pb-3" style="min-height: 100vh; background: #f9f9f9 url({{ url('images/logo/A25A435311.jpg')}}) !important;">
    <div class="container">
      <div class="row">


          <div class="col-sm-12">
            <h2 class="text-center text-white font-weight-bold">Explore Teaching Courses</h2>

              <h4 class="text-center bg-white py-2 mt-5 col-lg-8 offset-lg-2" style="border-radius: 10px;"><a class="text-yellow" href="{{ url('login') }}">আপনার প্রথম ফ্রি কোর্সটি দেখতে রেজিস্টার করুন</a></h4>
          </div>

      @foreach ($course_info as $v_course_info)
        <div class="col-md-4 mt-5">
          <a href="{{ url('view') }}/c/{{$v_course_info->slug}}">
          <div class="card">
            <img src="{{url('images\thumbnail')}}\{{ $v_course_info->thumbnail }}" class="card-img-top">
            <div class="text-center">
              <img src="{{url('images\profile_picture')}}\{{ $v_course_info->image }}" alt="Avatar" class="avatar">
             </div>
            <div class="card-body">

              <p class="card-title text-dark font-weight-bold">{{ str_limit(strip_tags($v_course_info->title), 30) }}</p>
              <p class="card-text text-yellow font-weight-bold"><small>Posted By</small><br> {{ str_limit(strip_tags($v_course_info->name), 20) }}</p>

                  <div class="text-dark">
                @for($i = 1; $i <= 5; $i++)
                      @if($v_course_info->rating - $i >= 0)
                      <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                      @else
                      <i class="far fa-star"></i>
                      @endif
                    @endfor
              </div>

            </div>
            <div class="card-footer" style="background: #51b964;">
              <h5 class="text-white text-center">Free</h5>
            </div>
          </div>
        </a>
        </div>
      @endforeach

      </div>
    </div>
  </div>
<!--end of explore Area-->



<!--Toolkits Area-->
<div class="container-fluid bg-light " style="min-height: 100vh">
  <div class="row">
    <div class="col-md-12">

      <div class="teachers-toolkits">

          <h2 class=" font-weight-bold text-center mt-5 mb-5 text-orange">Teachers Toolkits</h2>

          <h4 class="text-center background-yellow py-2 my-5 col-lg-8 offset-lg-2" style="border-radius: 10px;"><a class="text-white">আপনার শিক্ষকতা জীবনকে আরো সহজ ও কার্যকরী করুন এই সৃজনশীল পদ্ধতি ও উপাদান প্রয়োগ করে</a></h4>

            <section class="carousel slide mt-5 d-none d-md-block" data-ride="carousel" id="postsCarousel">
              <div class="container-fluid">
                  <div class="row float-right mr-5 mb-3">
                    <div class="col-md-12">
                      <a class="carousel-control-prev" href="#postsCarousel" data-slide="prev"><i class="mb-5 far fa-caret-square-left fa-3x mr-4 custom-hover2 text-yellow"></i></a>
                      <a class="carousel-control-next" href="#postsCarousel"  data-slide="next"><i class="mb-5 far fa-caret-square-right fa-3x ml-4 custom-hover2 text-yellow"></i></a>
                    </div>
                  </div>
              </div>

              <div class="container-fluid carousel-inner">
                @foreach($toolkit_info as $key=> $toolkit)
                  @if(($key+1) % 4 == 1)
                  <div class="row carousel-item {{ $key == 0? 'active' : '' }} ">
                    <div class="card-deck text-center">
                  @endif
                      <div class="col-md-3">
                       <a href="{{ url('view') }}/t/{{$toolkit->slug}}">
                        <div class="card">
                          <img src="{{url('images\thumbnail')}}\{{ $toolkit->thumbnail }}" class="card-img-top">
                          <div class="text-center">
                            <img src="{{url('images\profile_picture')}}\{{ $toolkit->image }}" alt="Avatar" class="avatar">
                           </div>
                          <div class="card-body">

                            <p class="card-title text-dark font-weight-bold">{{ str_limit(strip_tags($toolkit->toolkit_title), 25) }}</p>
                            <p class="card-text text-yellow font-weight-bold"><small>Posted By</small><br> {{ str_limit(strip_tags($toolkit->name), 20) }}</p>

                              <div class="text-dark">
                              @for($i = 1; $i <= 5; $i++)
                                @if($toolkit->rating - $i >= 0)
                                  <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                @else
                                  <i class="far fa-star"></i>
                                @endif
                              @endfor
                              </div>
                          </div>
                          <div class="card-footer" style="background: #51b964;">
                            <h5 class="text-white text-center">Free</h5>
                          </div>


                        </div>
                      </a>
                    </div>
                  @if(($key+1) % 4 == 0)
                    </div>
                  </div>
                  @endif
                @endforeach
              </div>
            </section>

            <section class="carousel slide mt-5 d-sm-none" data-ride="carousel" id="postsCarousel_mobile">
              <div class="container-fluid">
                  <div class="row float-right mr-5 mb-3">
                    <div class="col-md-12">
                      <a class="carousel-control-prev" href="#postsCarousel_mobile" data-slide="prev"><i class="mb-5 far fa-caret-square-left fa-3x mr-4 custom-hover2 text-yellow"></i></a>
                      <a class="carousel-control-next" href="#postsCarousel_mobile"  data-slide="next"><i class="mb-5 far fa-caret-square-right fa-3x ml-4 custom-hover2 text-yellow"></i></a>
                    </div>
                  </div>
              </div>



                <div class="container-fluid carousel-inner">
                    @foreach($toolkit_info as $key=> $toolkit)
                      <div class="carousel-item {{ $key == 0? 'active' : '' }} ">
                        <div class="card-deck text-center">

                           <a href="{{ url('view') }}/t/{{$toolkit->slug}}">
                            <div class="card">
                              <img src="{{url('images\thumbnail')}}\{{ $toolkit->thumbnail }}" class="card-img-top">
                              <div class="text-center">
                                <img src="{{url('images\profile_picture')}}\{{ $toolkit->image }}" alt="Avatar" class="avatar">
                               </div>
                              <div class="card-body">

                                <p class="card-title text-dark font-weight-bold">{{ str_limit(strip_tags($toolkit->toolkit_title), 25) }}</p>
                                <p class="card-text text-yellow font-weight-bold"><small>Posted By</small><br> {{ str_limit(strip_tags($toolkit->name), 20) }}</p>

                                  <div class="text-dark">
                                  @for($i = 1; $i <= 5; $i++)
                                    @if($toolkit->rating - $i >= 0)
                                      <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                    @else
                                      <i class="far fa-star"></i>
                                    @endif
                                  @endfor
                                  </div>
                              </div>
                              <div class="card-footer" style="background: #51b964;">
                                <h5 class="text-white text-center">Free</h5>
                              </div>


                            </div>
                          </a>
                        </div>
                      </div>

                    @endforeach
                  </div>
              </section>
          </div>
          <div class="text-center">
            <button type="button" class="btn background-yellow shadow text-white px-5 py-3 mt-5 mb-5 font-weight-bold">
              <a class="text-white" href="{{ url('toolkit') }}">View All Toolkits</a></button>
          </div>
        </div>
      </div>
    </div>

<!--end of Toolkits Area-->

<!--Leaderboard Area-->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="teachers-toolkits">
        <h2 class="font-weight-bold text-center mt-5 mb-5 text-yellow">Leaderboard</h2>


        <section class="carousel slide mt-5 d-none d-md-block" data-ride="carousel" id="leadLargeCarousel">
          <div class="container-fluid">
              <div class="row float-right mr-5 mb-3">
                <div class="col-md-12">
                  <a class="carousel-control-prev" href="#leadLargeCarousel" data-slide="prev"><i class="mb-5 far fa-caret-square-left fa-3x mr-4 custom-hover2 text-yellow"></i></a>
                  <a class="carousel-control-next" href="#leadLargeCarousel"  data-slide="next"><i class="mb-5 far fa-caret-square-right fa-3x ml-4 custom-hover2 text-yellow"></i></a>
                </div>
              </div>
          </div>

          <div class="container-fluid carousel-inner">
            @foreach($users as $key=> $user)
              @if(($key+1) % 4 == 1)
              <div class="row carousel-item {{ $key == 0? 'active' : '' }} ">
                <div class="card-deck text-center">
              @endif
                  <div class="col-md-3">
                    <a href="{{ url('t') }}/{{$user->username}}">
                      <div class="card">
                        <div class="py-3 bg-secondary">
                        @if($user->image == null)
                          <img class="img-fluid rounded-circle" style="height: 150px; width: 150px;" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                        @else
                          <img class="img-fluid rounded-circle" style="height: 150px; width: 150px;" src="{{ url('images/profile_picture') }}/{{ $user->image }}">
                        @endif
                        </div>
                        <div class="card-body">

                          <h4 class="card-title text-yellow  font-weight-bold">
                            @if($key < 3) <i class="fas fa-trophy" style="color: @if($key == 0) #d4af37 @elseif($key == 1) #aaa9ad @elseif($key == 2) #cd7f32 @else #fff @endif"></i>@endif
                            {{ $user->name }}
                          </h4>


                          <div class="text-dark">
                          @for($i = 1; $i <= 5; $i++)
                            @if($user->rating - $i >= 0)
                              <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                            @else
                              <i class="far fa-star"></i>
                            @endif
                          @endfor
                          </div>
                        </div>
                      </div>
                    </a>

                </div>
              @if(($key+1) % 4 == 0)
                </div>
              </div>
              @endif
            @endforeach
            </div>
          </section>


          <section class="carousel slide mt-5 d-sm-none" data-ride="carousel" id="leadSmallCarousel">
            <div class="container-fluid">
                <div class="row float-right mr-5 mb-3">
                  <div class="col-md-12">
                    <a class="carousel-control-prev" href="#leadSmallCarousel" data-slide="prev"><i class="mb-5 far fa-caret-square-left fa-3x mr-4 custom-hover2 text-yellow"></i></a>
                    <a class="carousel-control-next" href="#leadSmallCarousel"  data-slide="next"><i class="mb-5 far fa-caret-square-right fa-3x ml-4 custom-hover2 text-yellow"></i></a>
                  </div>
                </div>
            </div>

            <div class="container-fluid carousel-inner">
              @foreach($users as $key=> $user)
                <div class="carousel-item {{ $key == 0? 'active' : '' }} ">
                  <div class="card-deck text-center">
                      <a href="{{ url('t') }}/{{$user->username}}">
                        <div class="card">
                          <div class="py-3 bg-secondary">
                          @if($user->image == null)
                            <img class="img-fluid rounded-circle" style="height: 150px; width: 150px;" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                          @else
                            <img class="img-fluid rounded-circle" style="height: 150px; width: 150px;" src="{{ url('images/profile_picture') }}/{{ $user->image }}">
                          @endif
                          </div>
                          <div class="card-body">

                            <h4 class="card-title text-yellow  font-weight-bold">
                              @if($key < 3) <i class="fas fa-trophy" style="color: @if($key == 0) #d4af37 @elseif($key == 1) #aaa9ad @elseif($key == 2) #cd7f32 @else #fff @endif"></i>@endif
                              {{ $user->name }}
                            </h4>


                            <div class="text-dark">
                            @for($i = 1; $i <= 5; $i++)
                              @if($user->rating - $i >= 0)
                                <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                              @else
                                <i class="far fa-star"></i>
                              @endif
                            @endfor
                            </div>
                          </div>
                        </div>
                      </a>
                  </div>
                </div>
              @endforeach
              </div>
          </section>



      </div>
    </div>
  </div>
</div>
<!-- Leaderboar area ends -->


<div class="container-fluid pt-5">
      <h2 class="text-center font-weight-bold journey text-orange">Your Alokito Journey</h2>
      <div class="d-flex flex-row justify-content-center align-items-center" style="background: url({{ url('images/logo/sec-bg.png')}}) !important;min-height: 100vh">
        <div class="row mx-5 px-5">

          <div class="col-sm-4 col-md-4 col-lg-3 mt-4 zoom">
              <img class="card-img-top border-yellow-image img-fluid" src="{{asset('images\logo\step1.jpg')}}"alt="Responsive image" >

                  <p class="card-text text-center font-weight-bold text-yellow ">Step 1</p>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-3 mt-4 zoom">
              <img class="card-img-top border-yellow-image img-fluid" src="{{asset('images\logo\step2.jpg')}}"alt="Responsive image" >
                  <p class="card-text text-center font-weight-bold text-yellow">Step 2</p>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-3 mt-4 zoom">
              <img class="card-img-top border-yellow-image img-fluid " src="{{asset('images\logo\step3.jpg')}}"alt="Responsive image">
                  <p class="card-text text-center font-weight-bold text-yellow">Step 3</p>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-3 mt-4 zoom">
              <img class="card-img-top border-yellow-image img-fluid" src="{{asset('images\logo\step4.jpg')}}"alt="Responsive image">
                  <p class="card-text text-center font-weight-bold text-yellow">Step 4</p>
          </div>

        </div>

      </div>
</div>

 <!-- journey ends area -->

<div class="row">
  <div class="col-md-3">

  </div>
  <div class="col-md-3">

  </div>
  <div class="col-md-3">

  </div>
  <div class="col-md-3">

  </div>
</div>




<div class="bg-light justify-content-center align-items-center" style="min-height: 78vh">
  <div class="container py-5">
        <div class="row">
          <div class="row col-md-6">

            <div class="col-6 mt-4 zoom">
              <img class="card-img-top border-yellow-image img-fluid" src="{{asset('images\logo\pic01.png')}}"alt="Responsive image" >
            </div>
            <div class="col-6 mt-4 zoom">
                <img class="card-img-top border-yellow-image img-fluid" src="{{asset('images\logo\pic02.png')}}"alt="Responsive image">
            </div>
            <div class="col-6 mt-4 zoom">
                <img class="card-img-top border-yellow-image img-fluid " src="{{asset('images\logo\pic03.png')}}"alt="Responsive image">
            </div>
            <div class="col-6 mt-4 zoom">
                <img class="card-img-top border-yellow-image img-fluid" src="{{asset('images\logo\pic04.png')}}"alt="Responsive image">
            </div>




           </div>


          <div class="col-md-6 my-auto">
            <h1 class="text-center mt-5 mb-3 font-weight-bold text-orange" >Share your creativity</h1>
            <hr class="border-yellow-image mb-5" width="80%">
            <h4 class="text-dark m-3">আমরা বিশ্বাস করি আমাদের উদ্ভাবনী চিন্তাগুলো যখন কাজে পরিনত করা হয় তখনই সৃজনশীলতা অর্জন হয়। আপনাদের প্রতিভাগুলোকে আমাদের প্লাটফরমে শেয়ার করার মাধ্যমে তা থেকে আয় করুন ও স্বীকৃতি অর্জন করুন</h4>
          </div>
    </div>
  </div>
</div>


<div class="py-5 background-yellow">

      <h1 class="text-center text-white font-weight-bold mb-3">Teach at Alokito</h1>
      <h5 class="text-center text-white mb-3">Share Your Creativity. Earn money. Grow with us</h5>
      <div class="d-flex justify-content-center">
        <a href="{{ url('about_us') }}" class="btn btn-dark font-weight-bold text-white ">Learn More</a>
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





@endsection

