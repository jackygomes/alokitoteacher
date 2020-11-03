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
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-12">--}}
{{--                    <form action="{{ route('allToolkit') }}" method="get" style="width: 100%;">--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="subjects" class="col-sm-1 col-form-label">Subject:</label>--}}
{{--                            <div class="col-sm-2">--}}
{{--                                <select class="custom-select mr-sm-2" name="subject" id="subjects">--}}
{{--                                    <option selected>Choose Subject...</option>--}}
{{--                                    @foreach($subjects as $subject)--}}
{{--                                        <option value="{{$subject->id}}"><a href="">{{$subject->subject_name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-1">--}}
{{--                                <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Filter</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}

            @php
                $temp_subject_id = -1;
            @endphp

            @foreach($resource_info as $key =>$resource)
                @if($temp_subject_id!=$resource->subject_id)

                    @php
                        $temp_subject_id = $resource->subject_id;
                    @endphp

                    @if($key > 0)

        </div>@endif


        <h4 class="mt-3 font-weight-bold">{{$resource->subject_name}}</h4>

        <div class="row">
            @endif
            <div class="col-md-3 my-3">
                <a href="{{ url('view') }}/t/{{$resource->slug}}">

                    <div class="card" style="min-height: 22.5vh">
                        <img src="{{url('images\thumbnail')}}\{{ $resource->thumbnail }}" class="card-img-top">
                        <div class="text-center">
                            <img src="{{url('images\profile_picture')}}\{{ $resource->user->image }}" alt="Avatar" class="avatar">
                        </div>
                        <div class="card-body">

                            <p class="card-title text-dark font-weight-bold">{{ str_limit(strip_tags($resource->resource_title), 30) }}</p>
                            <p class="card-text text-yellow font-weight-bold"><small>Posted By</small><br> {{ str_limit(strip_tags($resource->user->name), 20) }}</p>

                            <div class="text-dark">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($resource->rating - $i >= 0)
                                        <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
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





    </section>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                {{$resource_info->links()}}
            </div>
        </div>
    </div>



@endsection
