@extends('master')
@section('content')


    <section class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="mt-5  font-weight-bold">Teacher Innovation</h2>
                <a href="{{ route('resource.create') }}" class="mt-3 btn text-center background-yellow text-white font-weight-bold home-explore-button">Submit My Innovation</a>
                <p class="my-3">To celebrate and inspire teachers, Alokito Teachers is launching <strong>Alokito Teachers calls for Teacher Innovators</strong> aimed to get teachers to think creatively and contribute towards minimizing the challenges emerging from education disruption and the digital divide. This challenge will serve as a platform where teachers will be able to share their innovations and assume the role of leadership in these unprecedented times.</p>
                <p class="text-yellow" style="font-size: 20px;"><strong>Innovation submission ends at 30th July, 2021</strong></p>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            {{-- <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('allResource')}}" method="get" style="width: 100%;">
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-1 col-form-label">Category:</label>
                            <div class="col-sm-2">
                                <select class="custom-select mr-sm-2" name="category" id="category">
                                    <option selected>All...</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{$category->id == app('request')->input('category') ? "selected" : ""}}><a href="">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}
            <div class="row">
                @foreach ($resource_info as $resource)
                    <div class="col-md-4 mt-5">
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
                                    <div class="posted-by">
                                        <p class="card-text text-light-dark">Posted By <strong class="text-dark">{{ str_limit(strip_tags($resource->user->name), 20) }}</strong></p>
                                        <div class="share-button">
                                            <i class="fa fa-share-alt" aria-hidden="true"></i>
                                            <div class="share-options">
                                                <div class="fb-share-button" 
                                                data-href="{{ route('metaResource', $resource->slug) }}" 
                                                data-layout="button">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    </section>


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                {{$resource_info->links()}}
            </div>
        </div>
    </div>



@endsection
