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
 <div class="container mt-4" style="min-height: 90vh;">
     <div class="row">

         <div class="col-md-12 text-left mb-3">
             <small class="text-black"> Overview of</small>
             <h3 class="font-weight-bold"> {{ $info->title }} {{ $info->toolkit_title }}</h3>
         </div>

         <div class="col-md-8">

             {!! $thumbnailPart !!}

             <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                 <li class="nav-item">
                     <a class="nav-link active" id="home-tab" data-toggle="tab" href="#about" role="tab" aria-controls="home" aria-selected="true">About</a>
                 </li>
                 @if(Request::segment(2) == 'c')
                 <li class="nav-item">
                     <a class="nav-link" id="profile-tab" data-toggle="tab" href="#advisor" role="tab" aria-controls="profile" aria-selected="false">Course Advisor</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" id="contact-tab" data-toggle="tab" href="#designer" role="tab" aria-controls="contact" aria-selected="false">Course Designer</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" id="contact-tab" data-toggle="tab" href="#facilitators" role="tab" aria-controls="contact" aria-selected="false">Course Facilitators</a>
                 </li>
                 @endif
             </ul>
             <div class="tab-content pt-4" id="myTabContent">
                 <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab">
                     <p>{{$info->description}}</p>
                 </div>
                 <div class="tab-pane fade" id="advisor" role="tabpanel" aria-labelledby="profile-tab">
                     @if(isset($infoAdvisors) && count($infoAdvisors))
                     @foreach($infoAdvisors as $advisor)
                         <div class="col-lg-4 pb-3">
                             <div class="card text-center">
                                 <div class="card-header">
                                     <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/course_activist_image') }}/{{$advisor->image}}">
                                 </div>
                                 <div class="card-body">
                                     <h5 class="card-title">{{$advisor->name}}</h5>
                                     <p class="card-text">
                                         @if(strlen($advisor->description) < 40) {!! nl2br(e($advisor->description)) !!}
                                         @else
                                             {!! nl2br(e(substr($advisor->description,0,40))).'...' !!}
                                             <a href="#" class="" data-toggle="modal" data-target="#advisorModal_{{$advisor->id}}">
                                                 Read More
                                             </a>
                                             <!-- Modal -->
                                             <div class="modal fade" id="advisorModal_{{$advisor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered" role="document">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title" id="exampleModalLongTitle">Advisor</h5>
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                 <span aria-hidden="true">&times;</span>
                                                             </button>
                                                         </div>
                                                         <div class="modal-body">
                                                                 <p class="modal-title pb-4"><img class="img-fluid rounded-circle activist-details-image mr-4" src="{{ url('images/course_activist_image') }}/{{ $advisor->image }}"> <span>{{$advisor->name}}</span></p>
                                                                 {!! nl2br(e($advisor->description)) !!}
                                                             </div>
                                                             <div class="modal-footer">
                                                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                             </div>
                                                         </div>
                                                     </div>
                                             </div>
                                         @endif
                                     </p>
                                 </div>
                                 <div class="card-footer text-muted">
                                     {{$advisor->type}}
                                 </div>
                             </div>
                         </div>
                    @endforeach
                    @else
                        <p>No Advisor</p>
                    @endif
                 </div>
                 <div class="tab-pane fade" id="designer" role="tabpanel" aria-labelledby="contact-tab">
                     @if(isset($infoDesigners) && count($infoDesigners))
                     @foreach($infoDesigners as $Designer)
                         <div class="col-lg-4 pb-3">
                             <div class="card text-center">
                                 <div class="card-header">
                                     <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/course_activist_image') }}/{{$Designer->image}}">
                                 </div>
                                 <div class="card-body">
                                     <h5 class="card-title">{{$Designer->name}}</h5>
                                     <p class="card-text">
                                         @if(strlen($Designer->description) < 40) {!! nl2br(e($Designer->description)) !!}
                                         @else
                                             {!! nl2br(e(substr($Designer->description,0,40))).'...' !!}
                                             <a href="#" class="" data-toggle="modal" data-target="#advisorModal_{{$Designer->id}}">
                                                 Read More
                                             </a>
                                             <!-- Modal -->
                                             <div class="modal fade" id="advisorModal_{{$Designer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered" role="document">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title" id="exampleModalLongTitle">Advisor</h5>
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                 <span aria-hidden="true">&times;</span>
                                                             </button>
                                                         </div>
                                                         <div class="modal-body">
                                                             <p class="modal-title pb-4"><img class="img-fluid rounded-circle activist-details-image mr-4" src="{{ url('images/course_activist_image') }}/{{ $Designer->image }}"> <span>{{$Designer->name}}</span></p>
                                                             {!! nl2br(e($Designer->description)) !!}
                                                         </div>
                                                         <div class="modal-footer">
                                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         @endif
                                     </p>
                                 </div>
                                 <div class="card-footer text-muted">
                                     {{$Designer->type}}
                                 </div>
                             </div>
                         </div>
                     @endforeach
                     @else
                        <p>No Designer</p>
                     @endif
                 </div>
                 <div class="tab-pane fade" id="facilitators" role="tabpanel" aria-labelledby="contact-tab">
                     @if(isset($infoFacilitators) && count($infoFacilitators))
                     @foreach($infoFacilitators as $Facilitators)
                         <div class="col-lg-4 pb-3">
                             <div class="card text-center">
                                 <div class="card-header">
                                     <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/course_activist_image') }}/{{$Facilitators->image}}">
                                 </div>
                                 <div class="card-body">
                                     <h5 class="card-title">{{$Facilitators->name}}</h5>
                                     <p class="card-text">
                                         @if(strlen($Facilitators->description) < 40) {!! nl2br(e($Facilitators->description)) !!}
                                         @else
                                             {!! nl2br(e(substr($Facilitators->description,0,40))).'...' !!}
                                             <a href="#" class="" data-toggle="modal" data-target="#advisorModal_{{$Facilitators->id}}">
                                                 Read More
                                             </a>
                                             <!-- Modal -->
                                             <div class="modal fade" id="advisorModal_{{$Facilitators->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered" role="document">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title" id="exampleModalLongTitle">Advisor</h5>
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                 <span aria-hidden="true">&times;</span>
                                                             </button>
                                                         </div>
                                                         <div class="modal-body">
                                                             <p class="modal-title pb-4"><img class="img-fluid rounded-circle activist-details-image mr-4" src="{{ url('images/course_activist_image') }}/{{ $Facilitators->image }}"> <span>{{$Facilitators->name}}</span></p>
                                                             {!! nl2br(e($Facilitators->description)) !!}
                                                         </div>
                                                         <div class="modal-footer">
                                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                         </div>
                                                     </div>
                                                 </div>
                                            </div>
                                        @endif
                                    </p>
                                </div>
                                <div class="card-footer text-muted">
                                 {{$Facilitators->type}}
                                </div>
                            </div>
                         </div>
                     @endforeach
                    @else
                        <p>No Facilitator</p>
                    @endif
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
                 @if($creator->image == null)
                 <i class="fas fa-user-circle fa-10x text-white"></i>
                 @else
                 <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $creator->image }}">
                 @endif
             </div>
             <br>
             <h3><a href="{{ url('t') }}/{{ $creator->username }}" class="font-weight-bold text-white">{{ $creator->name }}</a></h3>


{{--             <span>--}}
{{--                 @if(Request::segment(2) == 't')--}}
{{--                 Toolkit Rating:--}}
{{--                 @elseif(Request::segment(2) == 'c')--}}
{{--                 Course Rating:--}}
{{--                 @endif--}}
{{--             </span>--}}

             @for($i = 1; $i <= 5; $i++) @if($content_rating - $i>= 0)
                 <i class="fa fa-star text-yellow" aria-hidden="true"></i>
                 @else
                 <i class="far fa-star rating-inactive"></i>
                 @endif
                 @endfor
                 <br>
                 <br>
                 <hr>
                 <br>
                 <span>
{{--                     @if(Request::segment(2) == 't')--}}
{{--                     Toolkit Price:--}}
{{--                     @elseif(Request::segment(2) == 'c')--}}
{{--                     Course Price:--}}
{{--                     @endif--}}
                     <span class="h3 text-success">
                         @if($info->price == 0)
                         Free
                         @else
                         {{ round($info->price, 2)}} BDT
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
                 @if(Auth::user()->identifier != 2)
                 @if($info->price == 0)
                 @if($trackHistory == null)
                 <form method="POST" action="{{ url('enroll_into_course') }}">
                     {{ csrf_field() }}
                     <input type="hidden" name="slug" value="{{ Request::segment(3) }}">
                     <input type="hidden" name="course_toolkit" value="{{ Request::segment(2) }}">

                     <button type="submit" class="mt-4 btn text-white background-yellow btn-lg">Enroll Now</button>

                 </form>
                 @else
                 <a href="{{ url('view') }}/{{ Request::segment(2) }}/{{ Request::segment(3) }}" class="mt-4 btn text-white background-yellow  btn-lg">
                     @if(Request::segment(2) == 't')
                     View Toolkit
                     @elseif(Request::segment(2) == 'c')
                     View Course
                     @endif
                 </a>
                 </form>
                 @endif
                 @else
                 @if(Request::segment(2) == 'c')
                 @if($info->isBought == 1 && Auth::check())
                 @if($trackHistory == null)
                 <form method="POST" action="{{ url('enroll_into_course') }}">
                     {{ csrf_field() }}
                     <input type="hidden" name="slug" value="{{ Request::segment(3) }}">
                     <input type="hidden" name="course_toolkit" value="{{ Request::segment(2) }}">

                     <button type="submit" class="mt-4 btn text-white background-yellow btn-lg">Enroll Now</button>

                 </form>
                 @else
                 <a href="{{ url('view') }}/{{ Request::segment(2) }}/{{ Request::segment(3) }}" class="mt-4 btn text-white background-yellow btn-lg">
                     @if(Request::segment(2) == 't')
                     View Toolkit
                     @elseif(Request::segment(2) == 'c')
                     View Course
                     @endif
                 </a>
                 </form>
                 @endif
                 @elseif(Auth::check())
                 @if($info->price > Auth::user()->balance)
                 <form onclick="return confirm('Insufficiant Balance. Deposit your balance first.')">
                     @csrf
                     <button type="submit" class="mt-4 btn text-white background-yellow btn-lg">Purchase</button>
                 </form>
                 @else
                 <form action="{{route('purchase.product', $info->id)}}" onclick="return confirm('Are you sure to purchase this course? if yes then click ok.')" method="post">
                     @csrf
                     <input type="hidden" name="type" value="course">
                     <button type="submit" class="mt-4 btn text-white background-yellow btn-lg">Purchase</button>
                 </form>
                 @endif
                 @else
                 <form action="{{route('purchase.product', $info->id)}}" method="post">
                     @csrf
                     <input type="hidden" name="type" value="course">
                     <button type="submit" class="mt-4 btn text-white background-yellow btn-lg">Purchase</button>
                 </form>
                 @endif
                 @elseif(Request::segment(2) == 't')
                 @if($info->isBought == 1 && Auth::check())
                 @if($trackHistory == null)
                 <form method="POST" action="{{ url('enroll_into_course') }}">
                     {{ csrf_field() }}
                     <input type="hidden" name="slug" value="{{ Request::segment(3) }}">
                     <input type="hidden" name="course_toolkit" value="{{ Request::segment(2) }}">

                     <button type="submit" class="mt-4 btn text-white background-yellow btn-lg">Enroll Now</button>

                 </form>
                 @else
                 <a href="{{ url('view') }}/{{ Request::segment(2) }}/{{ Request::segment(3) }}" class="mt-4 btn text-white background-yellow btn-lg">
                     @if(Request::segment(2) == 't')
                     View Toolkit
                     @endif
                 </a>
                 </form>
                 @endif
                 @elseif(Auth::check())
                 @if($info->price > Auth::user()->balance)
                 <form onclick="return confirm('Insufficiant Balance. Deposit your balance first.')">
                     @csrf
                     <button type="submit" class="mt-4 btn text-white background-yellow btn-lg">Purchase</button>
                 </form>
                 @else
                 <form action="{{route('purchase.product', $info->id)}}" onclick="return confirm('Are you sure to purchase this toolkit? if yes then click ok.')" method="post">
                     @csrf
                     <input type="hidden" name="type" value="toolkit">
                     <button type="submit" class="mt-4 btn text-white background-yellow btn-lg">Purchase</button>
                 </form>
                 @endif
                 @else
                 <form action="{{route('purchase.product', $info->id)}}" method="post">
                     @csrf
                     <input type="hidden" name="type" value="toolkit">
                     <button type="submit" class="mt-4 btn text-white background-yellow btn-lg">Purchase</button>
                 </form>
                 @endif
                 @endif
                 @endif
                 @endif

                 <p class="mt-2">Total enrolled: {{$histories->count()}}</p>

                 @if(Request::segment(2) == 't')
                 <p class="text-danger mt-3">***You can not retake this toolkit</p>
                 @elseif(Request::segment(2) == 'c')
                 <p class="text-danger mt-3">***You can not retake this course</p>
                 @endif
         </div>
         </div>




     </div>
 </div>
 <hr>





 @push('js')

 <script src="https://player.vimeo.com/api/player.js"></script>



 <script>
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
