@extends('master')
@section('content')

    <div class="container mt-4" style="min-height: 90vh;">
        <div class="row">

            <div class="col-md-12 text-center mb-3">
                <small class="font-weight-bold "> Overview of</small>
                <h3 class="font-weight-bold">{{ $info->resource_title }}</h3>
            </div>

            <div class="col-md-8">

                <img src="{{asset('images/thumbnail').'/'. $info->thumbnail}} " class="img-fluid">'

                <p style="margin-bottom: 0; background-color: #f3f2f0;" class="mt-5 p-5 card font-weight-bold text-center"> {{ $info->description }}</p>

            </div>
            <div class="col-md-4 background-yellow text-center p-5">

                <div style="width: 150px; height: 150px;" class="mx-auto">
                    @if($creator->image == null)
                        <i class="fas fa-user-circle fa-10x text-white"></i>
                    @else
                        <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $creator->image }}">
                    @endif
                </div>
                <br>
                <h3><a href="{{ url('t') }}/{{ $creator->username }}" class="font-weight-bold text-white">{{ $creator->name }}</a></h3>


{{--                <span>--}}
{{--            @if(Request::segment(2) == 't')--}}
{{--                        Toolkit Rating:--}}
{{--                    @elseif(Request::segment(2) == 'c')--}}
{{--                        Course Rating:--}}
{{--                    @endif--}}
{{--        </span>--}}

{{--                @for($i = 1; $i <= 5; $i++)--}}
{{--                    @if($content_rating - $i >= 0)--}}
{{--                        <i class="fa fa-star" aria-hidden="true"></i>--}}
{{--                    @else--}}
{{--                        <i class="far fa-star text-white"></i>--}}
{{--                    @endif--}}
{{--                @endfor--}}
                <br>
                <br>
                <span>
            @if(Request::segment(2) == 't')
                        Toolkit Price:
                    @elseif(Request::segment(2) == 'c')
                        Course Price:
                    @endif
        <span class="h3">
            @if($info->price == 0)
                Free
            @else
                {{ round($info->price, 2)}} BDT
            @endif
        </span></span>
                <br>
            <a href="{{ url('view') }}/{{ Request::segment(2) }}/{{ Request::segment(3) }}" class="mt-4 btn btn-success btn-lg">
                @if(Request::segment(2) == 'r')
                    View Resource
                @endif
            </a>

            </div>

            @if($info->title != null)

                <div class="col-md-12 text-center mt-5">
                    <h3 class="font-weight-bold"> Certification</h3>
                </div>

                <div class="col-md-12 text-center mb-5 border-yellow-image" style="position: relative;">
                    <img  class="img-fluid my-3" src="{{ url('images/certificate.png') }}">
                    <h3 class="font-weight-bold" style="position: absolute; top: 65%; left: 50%; transform: translate(-50%, -50%);">{{ $info->title }}</h3>
                    <h3 class="font-weight-bold" style="position: absolute; top: 48%; left: 50%; transform: translate(-50%, -50%);">{{ Auth::user()->name }}</h3>
                </div>

            @endif




        </div>
    </div>








    @push('js')

        <script src="https://player.vimeo.com/api/player.js"></script>



        <script>
            (function (window, document) {
                var loader = function () {
                    var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
                    script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
                    tag.parentNode.insertBefore(script, tag);
                };

                window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
            })(window, document);
        </script>

    @endpush

@endsection
