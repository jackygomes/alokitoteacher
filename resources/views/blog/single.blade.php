@extends('master')
@section('content')
<section class="blog-single section-space">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{$blog->name}}</h1>
                <div class="header-bottom">
                    <div class="header-left">
                        <p class="card-text text-light-dark mb-0 d-inline">By <strong class="text-yellow">{{ $blog->user->name }}</strong></p>
                        <ul >
                            <li>26 likes</li>
                            <li>2 Comments</li>
                            <li>5 Shares</li>
                        </ul>
                    </div>
                    <div class="header-right">
                        <div class="right-button"><img src="{{asset('images/new_design/like-button.png')}}"> Like</div>
                        <div class="share-button right-button">
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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="banner-image">
                    <img src="{{asset('images/thumbnail')}}/{{ $blog->thumbnail }}" alt="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!!$blog->content!!}
            </div>
        </div>
    </div>
</section>
@endsection