@extends('master')
@section('content')

<style>
    .avatar {
  position: relative;
  display: inline-block;
  width: 3rem;
  height: 3rem;
  font-size: 1.25rem;
}

.avatar-img,
.avatar-initials,
.avatar-placeholder {
  width: 100%;
  height: 100%;
  border-radius: inherit;
}

.avatar-img {
  display: block;
  -o-object-fit: cover;
  object-fit: cover;
}

.avatar-initials {
  position: absolute;
  top: 0;
  left: 0;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  -ms-flex-pack: center;
  justify-content: center;
  color: #fff;
  line-height: 0;
  background-color: #a0aec0;
}

.avatar-placeholder {
  position: absolute;
  top: 0;
  left: 0;
  background: #a0aec0
    url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='%23fff' d='M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z'/%3e%3c/svg%3e")
    no-repeat center/1.75rem;
}

.avatar-indicator {
  position: absolute;
  right: 0;
  bottom: 0;
  width: 20%;
  height: 20%;
  display: block;
  background-color: #a0aec0;
  border-radius: 50%;
}

.avatar-group {
  display: -ms-inline-flexbox;
  display: inline-flex;
}

.avatar-group .avatar + .avatar {
  margin-left: -0.75rem;
}

.avatar-group .avatar:hover {
  z-index: 1;
}

.avatar-sm,
.avatar-group-sm > .avatar {
  width: 2.125rem;
  height: 2.125rem;
  font-size: 1rem;
}

.avatar-sm .avatar-placeholder,
.avatar-group-sm > .avatar .avatar-placeholder {
  background-size: 1.25rem;
}

.avatar-group-sm > .avatar + .avatar {
  margin-left: -0.53125rem;
}

.avatar-lg,
.avatar-group-lg > .avatar {
  width: 4rem;
  height: 4rem;
  font-size: 1.5rem;
}

.avatar-lg .avatar-placeholder,
.avatar-group-lg > .avatar .avatar-placeholder {
  background-size: 2.25rem;
}

.avatar-group-lg > .avatar + .avatar {
  margin-left: -1rem;
}

.avatar-light .avatar-indicator {
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.75);
}

.avatar-group-light > .avatar {
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.75);
}

.avatar-dark .avatar-indicator {
  box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.25);
}

.avatar-group-dark > .avatar {
  box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.25);
}

/* Font not working in <textarea> for this version of bs */

textarea {
  font-family: inherit;
}

</style>


<section class="blog-single section-space">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{$blog->name}}</h1>
                <div class="header-bottom">
                    <div class="header-left">
                        <p class="card-text text-light-dark mb-0 d-inline">By <strong class="text-yellow">{{ $blog->user->name }}</strong></p>
                        <ul >
                            <li><span id="totalLikes">{{sizeof($blog->likes)}}</span> likes</li>
                            <li>{{sizeof($blog->comments)}} Comments</li>
                            <li>5 Shares</li>
                        </ul>
                    </div>
                    <div class="header-right">
                        @if(Auth::check())
                        <div class="right-button" onclick="like({{$blog->id}},{{ auth()->user()->id}})"><img src="{{asset('images/new_design/like-button.png')}}"> <span id="likeButton"> Like</span></div>
                        @endif
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
        
        <div class="row">
            <div class="col-md-12">
                <h1>Comments</h1>

                @foreach ($blog->comments as $comment)
                    <div class="container mt-2">
                        <div class="d-flex row">
                            <div class="col-md-12">
                                <div class="d-flex flex-column comment-section">
                                    <div class="bg-white p-2">
                                        <div class="d-flex flex-row user-info"><img class="rounded-circle" src="{{ env('APP_URL') . '/images/profile_picture/' . $comment->user->image}}" width="40">
                                            <div class="d-flex flex-column justify-content-start ml-2"><span class="d-block font-weight-bold name">{{$comment->user->name}}</span><span class="date text-black-50">Shared publicly - Jan 2020</span></div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="comment-text">{{$comment->comment}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><hr>
                @endforeach

                @if(Auth::check())
                <form action="{{ route('blogs.comment') }}" method="post" enctype="multipart/form-data" style="width: 100%;">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="model_id" value="{{$blog->id}}">
                        <textarea name="comment" id="comment" class="form-control" rows="5" placeholder="Write your Comment.." required></textarea><br>
                        <button type="submit" class="btn btn-primary float-right">Post Comment</button>
                    </div>
                </form>
                @endif
                
            </div>
        </div>  

    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>

<script>

    function likeStatus(){
        var likeStatus = `{!! $like !!}`;        
        if(likeStatus!=0){
            document.getElementById('likeButton').innerHTML = 'Liked';
        }
        else{
            document.getElementById('likeButton').innerHTML = 'Like';
        }
    }
    likeStatus();
    function like(blog_id,user_id){
        axios.post('http://alokitoteacher.localhost/public/api/blog/like',{
            'user_id': user_id,
            'model_id': blog_id
        } , {
            headers: { 'Content-Type': 'application/json'}
        })
        .then((response) => {
           if(response.data.status=='liked') {
            document.getElementById('likeButton').innerHTML = 'Liked';
           }
           else {
            document.getElementById('likeButton').innerHTML = 'Like';
           }
           document.getElementById('totalLikes').innerHTML = response.data.likes;
        })

    }

</script>

@endsection