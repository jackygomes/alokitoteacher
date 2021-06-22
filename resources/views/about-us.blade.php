@extends('master')
@section('content')

<div class="about-page">
    <div class="top-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-5 mb-5">
                    <div class="banner-text-content">
                    <h1 class="banner-header font-weight-bold">Alokito Teacher</h1>
                    <p class="text-secondary">‎The teacher is the artisan of the next generation. We want to support, evaluate and empower them to make them skilled teachers of the 21st century. One of the many qualities of such teachers is creativity, empathy and leadership‎.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid mx-auto d-block" src="{{asset('images\new_design\about-us-banner.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="about-us-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 pl-5 text-center">
                    <h3 class="font-weight-bold section-header">About Us</h3>
                    <p class="text-light-dark mt-5 mb-5">As teachers and researchers we bring to you our proven teaching ideas, materials and a variety of courses. We have been working on teacher development in our pilot school& govt. schools where we designed various training programs & tools to motivate the teachers, develop their skills & to make them the change makers in their classrooms & community. We are a team of 10 passionate educators with diverse experience eager to explore, unlearn and learn new ways of approaching the existing problems in the education system. We are constantly experimenting and innovating within the ecosystem. By pushing each other and sharing constructive criticism we keep growing and increasing our propensity to bolder social innovations and experimentation.</p>
                </div>
            </div>
        </div>
        <img class="top-left" style="position: absolute; top: -68px; left: 80px; width: 300px;" src="{{asset('images/new_design/about-us-top-left.png')}}" alt="">
        <img class="top-right" style="position: absolute; top: -24px; right: -37px; width: 300px;" src="{{asset('images/new_design/about-us-top-right.png')}}" alt="">
        <img class="bottom-left" style="position: absolute; bottom: 74px; left: -28px; width: 300px;" src="{{asset('images/new_design/about-us-bottom-left.png')}}" alt="">
        <img class="bottom-right" style="position: absolute; bottom: -48px; right: 60px; z-index:1; width: 300px;" src="{{asset('images/new_design/about-us-bottom-right.png')}}" alt="">
    </div>
    <div class="our-vision">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 pl-5 text-center">
                    <h3 class="font-weight-bold section-header">Our Vision</h3>
                    <p class="text-light-dark mt-5 mb-5">Support, nurture and empower outstanding educators to build an enlightened generation of tomorrow.</p>
                </div>
            </div>
        </div>
        <img class="left-cloud" style="position: absolute; top: 118px; left: 114px;" src="{{asset('images/new_design/our-vision-left.png')}}" alt="">
        <img class="right-cloud" style="position: absolute; top: 98px; right: 74px; width:170px" src="{{asset('images/new_design/our-vision-right-top.png')}}" alt="">
        <img class="rocket" style="position: absolute; bottom: 74px; right: 214px; width:300px" src="{{asset('images/new_design/our-vision-rocket.png')}}" alt="">
    </div>
</div>



@push('js')
    <script>
        $(document).ready(function(){
            if( $( window ).width() < 1366) {
                $('.our-vision .left-cloud').css("top", "154px");
                $('.our-vision .left-cloud').css("width", "210px");
                
                $('.our-vision .right-cloud').css("top", "128px");
                $('.our-vision .right-cloud').css("width", "110px");

                $('.our-vision .rocket').css("bottom", "112px");
                $('.our-vision .rocket').css("right", "112px");
                $('.our-vision .rocket').css("width", "260px");
            }
        });
    </script>

@endpush

@endsection
