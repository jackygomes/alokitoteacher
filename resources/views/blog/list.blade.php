
@extends('master')
@section('content')
<section class="section-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="font-weight-bold">Top Blogs</h2>
            </div>
        </div>
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-md-4">
                    <div class="item mt-5 blog-card">
                        <div class="card">
                            <div class="img-wrap">
                                <a href="{{ route('blogs.single', $blog->slug) }}">
                                    <img src="{{url('images\thumbnail')}}\{{ $blog->thumbnail }}" style="height: 262px;" class="card-img-top">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('blogs.single', $blog->slug) }}">
                                    @if(strlen($blog->name) < 26)
                                        <p class="card-title text-dark font-weight-bold mb-0" style="font-size: 20px">{{ str_limit(strip_tags($blog->name), 26) }}</p>
                                    @else
                                        <div class="ticker-wrap">
                                            <div class="ticker">
                                                <div class="ticker__item card-title text-dark font-weight-bold mb-0">
                                                    {{$blog->name}}</div>
                                            </div>
                                        </div>
                                    @endif
                                </a>
                                <div class="posted-by mt-2">
                                    <p class="card-text text-light-dark mb-0">By <strong class="text-yellow">{{ str_limit(strip_tags($blog->user->name), 20) }}</strong></p>
                                    <div class="share-button">
                                        <div><img src="{{asset('images/new_design/main-share.png')}}"> Share</div>
                                        <div class="share-options">
                                            <div class="fb-share-button" 
                                            data-href="" 
                                            data-layout="button">
                                            </div>
                                            <script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
                                            <script type="IN/Share" data-url=""></script>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <ul>
                                    <li>26 likes</li>
                                    <li>2 Comments</li>
                                    <li>5 Shares</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="recent-blogs section-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="font-weight-bold">Recent Blogs<a href="#" class="float-right"><span class="fa-clickable blog-view-all" data-toggle="modal" data-target="#addJobModal">View all</span></a></h2>
            </div>
        </div>
        <div class="row">
            <div id="blogSlider" class="owl-carousel card-slider">
                @foreach ($blogs as $blog)
                    <div class="item mt-5 blog-card">
                        <div class="card">
                            <div class="img-wrap">
                                <a href="{{ route('blogs.single', $blog->slug) }}">
                                    <img src="{{url('images\thumbnail')}}\{{ $blog->thumbnail }}" style="height: 262px;" class="card-img-top">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('blogs.single', $blog->slug) }}">
                                    @if(strlen($blog->name) < 26)
                                        <p class="card-title text-dark font-weight-bold mb-0" style="font-size: 20px">{{ str_limit(strip_tags($blog->name), 26) }}</p>
                                    @else
                                        <div class="ticker-wrap">
                                            <div class="ticker">
                                                <div class="ticker__item card-title text-dark font-weight-bold mb-0">
                                                    {{$blog->name}}</div>
                                            </div>
                                        </div>
                                    @endif
                                </a>
                                <div class="posted-by mt-2">
                                    <p class="card-text text-light-dark mb-0">By <strong class="text-yellow">{{ str_limit(strip_tags($blog->user->name), 20) }}</strong></p>
                                    <div class="share-button">
                                        <div><img src="{{asset('images/new_design/main-share.png')}}"> Share</div>
                                        <div class="share-options">
                                            <div class="fb-share-button" 
                                            data-href="" 
                                            data-layout="button">
                                            </div>
                                            <script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
                                            <script type="IN/Share" data-url=""></script>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <ul>
                                    <li>26 likes</li>
                                    <li>2 Comments</li>
                                    <li>5 Shares</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@push('js')
    <script>
        $('#blogSlider').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            autoplay:false,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
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










