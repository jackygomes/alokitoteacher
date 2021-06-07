@extends('master')
@section('content')

<div class="explore-teaching">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2 class="text-center font-weight-bold">Explore Teaching Courses</h2>
                <button class="btn text-center background-yellow mt-3"><a class="text-white font-weight-bold px-3" href="{{url('course') }}">Explore More</a></button>
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

                                    <p class="card-title text-dark font-weight-bold mb-0" style="font-size: 19px">{{ str_limit(strip_tags($v_course_info->title), 22) }}</p>
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
<div class="explore-teaching dark-yellow-section text-white">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2 class="text-center font-weight-bold">Explore Teaching Resources</h2>
                <button class="btn text-center bg-white mt-3"><a class="text-dark font-weight-bold px-3" href="{{route('allResource') }}">View All Resources</a></button>
            </div>
        </div>
        <div class="row">
            <div id="exploreResource" class="owl-carousel card-slider">
                @foreach ($resource_info as $resource)
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
    </script>
@endpush

@endsection
