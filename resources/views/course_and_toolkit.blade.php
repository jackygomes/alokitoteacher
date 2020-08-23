@extends('master') @section('content')



<section class="container" style="min-height: 49.2vh">
    @if($user_info->identifier != 4)
    <div class="row">
        <div class="col-lg-12">
            <h2 class="mt-3 text-center font-weight-bold">Courses</h2>
        </div>

        @foreach ($course_info as $v_course_info)
        <div class="col-md-3 mt-3">
            <a href="{{ url('view') }}/c/{{$v_course_info->slug}}">
                <div class="card">
                    <img src="{{url('images\thumbnail')}}\{{ $v_course_info->thumbnail }}" style="height: 190px;" class="card-img-top">
                    <div class="text-center">
                        <img src="{{url('images\profile_picture')}}\{{ $v_course_info->image }}" alt="Avatar" class="avatar">
                    </div>
                    <div class="card-body">

                        <p class="card-title text-dark font-weight-bold">{{ str_limit(strip_tags($v_course_info->title), 30) }}</p>
                        <p class="card-text text-yellow font-weight-bold"><small>Posted By</small>
                            <br> {{ str_limit(strip_tags($v_course_info->name), 20) }}</p>

                        <div class="text-dark">
                            @for($i = 1; $i
                            <=5 ; $i++) @if($v_course_info->rating - $i >= 0)
                                <i class="fa fa-star checked-yellow" aria-hidden="true"></i> @else
                                <i class="far fa-star"></i> @endif @endfor
                        </div>

                    </div>
                    <div class="card-footer" style="background:
                    @if($v_course_info->isBought == 1)
                        #98b59d;
                    @else
                        #51b964;
                    @endif
                        ">
                        <h5 class="text-white text-center">
                            @if($v_course_info->isBought == 1)
                                Owned
                            @else
                                @if($v_course_info->price == 0)
                                    Free
                                @else
                                    {{ round($v_course_info->price, 2)}} BDT
                                @endif
                            @endif
                        </h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    @if(count($course_info) > 0)

    <div class="justify-content-right">
        <div class="row  ">
            <div class="col-md-12 text-center">
                <a href="{{url('course') }}" class="btn shadow  px-5 py-3 mt-5 mb-5 font-weight-bold background-yellow text-white">View More Courses</a>
            </div>

        </div>
    </div>
    @else
    <h4 class="text-center text-muted">No Coureses Available</h4>
    @endif
    @endif


    <div class="row">
        <div class="col-lg-12">
            <h2 class="mt-3 text-center font-weight-bold">Toolkits</h2>
        </div>


        @foreach ($toolkit_info as $toolkit)
        <div class="col-md-3 mt-3">
            <a href="{{ url('view') }}/t/{{$toolkit->slug}}">
                <div class="card" style="min-height: 22.5vh">
                    <img src="{{url('images\thumbnail')}}\{{ $toolkit->thumbnail }}" class="card-img-top">
                    <div class="text-center">
                        <img src="{{url('images\profile_picture')}}\{{ $toolkit->image }}" alt="Avatar" class="avatar">
                    </div>
                    <div class="card-body">

                        <p class="card-title text-dark font-weight-bold">{{ str_limit(strip_tags($toolkit->toolkit_title), 30) }}</p>
                        <p class="card-text text-yellow font-weight-bold"><small>Posted By</small>
                            <br> {{ str_limit(strip_tags($toolkit->name), 20) }}</p>

                        <div class="text-dark">
                            @for($i = 1; $i
                            <=5 ; $i++) @if($toolkit->rating - $i >= 0)
                                <i class="fa fa-star checked-yellow" aria-hidden="true"></i> @else
                                <i class="far fa-star"></i> @endif @endfor
                        </div>
                    </div>
                    <div class="card-footer" style="background:
                    @if($toolkit->isBought == 1)
                        #98b59d;
                    @else
                        #51b964;
                    @endif
                        ">
                        <h5 class="text-white text-center">
                            @if($toolkit->isBought == 1)
                                Owned
                            @else
                                @if($toolkit->price == 0)
                                    Free
                                @else
                                    {{ round($toolkit->price, 2)}} BDT
                                @endif
                            @endif
                        </h5>
                    </div>
                </div>
            </a>

        </div>
        @endforeach
    </div>




    @if(count($toolkit_info) > 0)
    <div class="justify-content-right">
        <div class="row  ">
            <div class="col-md-12 text-center">
                <a href="{{url('toolkit') }}" class="btn shadow  px-5 py-3 mt-5 mb-5 font-weight-bold background-yellow text-white">View More Toolkits</a>
            </div>
        </div>
    </div>
    @else
    <h4 class="text-center text-muted mb-4">No Toolkit Available</h4>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <h2 class="mt-3 text-center font-weight-bold">Resources</h2>
        </div>


        @foreach ($resource_info as $resource)
            <div class="col-md-3 mt-3">
                <a href="{{ url('overview') }}/r/{{$resource->slug}}">
                    <div class="card" style="min-height: 22.5vh">
                        <img src="{{url('images\thumbnail')}}\{{ $resource->thumbnail }}" class="card-img-top">
                        <div class="text-center">
                            <img src="{{url('images\profile_picture')}}\{{ $resource->user->image }}" alt="Avatar" class="avatar">
                        </div>
                        <div class="card-body">

                            <p class="card-title text-dark font-weight-bold">{{ str_limit(strip_tags($resource->resource_title), 30) }}</p>
                            <p class="card-text text-yellow font-weight-bold"><small>Posted By</small>
                                <br> {{ str_limit(strip_tags($resource->user->name), 20) }}</p>

                            <div class="text-dark">
                                    <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                    <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                    <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                            </div>
                        </div>

                        <div class="card-footer" style="background:
                        @if($resource->isBought == 1)
                            #98b59d;
                        @else
                            #51b964;
                        @endif
                            ">
                            <h5 class="text-white text-center">
                                @if($resource->isBought == 1)
                                    Owned
                                @else
                                    @if($resource->price == 0)
                                        Free
                                    @else
                                        {{ round($resource->price, 2)}} BDT
                                    @endif
                                @endif
                            </h5>
                        </div>
                    </div>
                </a>

            </div>
        @endforeach
    </div>




    @if(count($resource_info) > 0)
        <div class="justify-content-right">
            <div class="row  ">
                <div class="col-md-12 text-center">
                    <a href="{{url('allResource') }}" class="btn shadow  px-5 py-3 mt-5 mb-5 font-weight-bold background-yellow text-white">View More Resources</a>
                </div>
            </div>
        </div>
    @else
        <h4 class="text-center text-muted mb-5">No Resource Available</h4>
    @endif


</section>

@endsection
