@extends('master')
@section('content')


    <section class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mt-3 text-center font-weight-bold">Resources</h2>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
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
            </div>
            <div class="row">
                @foreach ($resource_info as $resource)
                    <div class="col-md-4 mt-5">
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
    </section>


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                {{$resource_info->links()}}
            </div>
        </div>
    </div>



@endsection
