@extends('master')
@section('content')
<style>
    .right-panel {
        border: 2px solid #f59d1f;
        border-radius: 10px;
        min-height: 100vh;
    }
    .rating-inactive {
        color: #9d9d9d;
    }
    .fa-star {
        font-size: 26px;
    }
</style>
    <div class="container mt-4" style="min-height: 90vh;">
        <div class="row">

            <div class="col-md-12 text-left mb-3">
                <small class="font-weight-bold "> Overview of</small>
                <h3 class="font-weight-bold">{{ $info->resource_title }}</h3>
            </div>

            <div class="col-md-8">

                <img src="{{asset('images/thumbnail').'/'. $info->thumbnail}} " class="img-fluid" style="width: 100%; border-radius: 10px">

                <h3 class="mt-5">About</h3>
                <p class="my-3"> {{ $info->description }}</p>

            </div>
            <div class="col-md-4 text-center">
                <div class="right-panel p-5">
                    @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{$message}}
                    </div>
                    @endif
                    <div style="width: 150px; height: 150px;" class="mx-auto">
                        @if($creator->image == null)
                        <i class="fas fa-user-circle fa-10x text-white"></i>
                        @else
                        <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $creator->image }}">
                        @endif
                    </div>
                    <br>
                    <h3><a href="{{ url('t') }}/{{ $creator->username }}" class="font-weight-bold text-capitalize mb-5">{{ $creator->name }}</a></h3>
                    
                    <div class="mt-5">
                        @for($i = 1; $i <= 5; $i++) @if($content_rating - $i>= 0)
                            <i class="fa fa-star text-yellow" aria-hidden="true"></i>
                            @else
                            <i class="far fa-star rating-inactive"></i>
                            @endif
                        @endfor
                    </div>
                        <br>
                        <br>
                        <hr>
                        <br>
                        <br>
                <!-- @if(Auth::user()->identifier != 2)
                    @if($info->price == 0)
                        <a href="{{ url('view') }}/{{ Request::segment(2) }}/{{ Request::segment(3) }}" class="mt-4 btn btn-success btn-lg">
                            View Resource
                        </a>
                    @else
                        @if($info->isBought == 1 && Auth::check())
                        <a href="{{ url('view') }}/{{ Request::segment(2) }}/{{ Request::segment(3) }}" class="mt-4 btn btn-success btn-lg">
                            View Resource
                        </a>
                        @elseif(Auth::check())
                            @if($info->price > Auth::user()->balance)
                                <form onclick="return confirm('Insufficiant Balance. Deposit your balance first.')">
                                    @csrf
                                    <button type="submit" class="mt-4 btn btn-success btn-lg">Purchase</button>
                                </form>
                            @else
                                <form action="{{route('purchase.product', $info->id)}}" onclick="return confirm('Are you sure to purchase this resource? if yes then click ok.')" method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="resource">
                                    <button type="submit" class="mt-4 btn btn-success btn-lg">Purchase</button>
                                </form>
                            @endif
                        @endif
                    @endif
                @endif -->
                @if(isset($content_rating))
                <button class="mt-4 btn text-white background-yellow btn-lg" data-toggle="modal" data-target="#ratingModal" disabled>Rate this innovation</button>
                @else
                <button class="mt-4 btn text-white background-yellow btn-lg" data-toggle="modal" data-target="#ratingModal">Rate this innovation</button>
                @endif
            </div>
        </div>
    </div> 
    <hr>

<!-- rating -->
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rate This Innovation</h5>

      </div>
      <div class="modal-body text-center">
        <form method="POST" action="{{ route('rate.resource') }}">
            {{csrf_field()}}
            <input type="hidden" name="resource_id" value="{{$info->id}}">
            <label for="">Innovation rating</label>
            <div class="rating mb-3">
                <label>
                    <input type="radio" name="resourceRating" class="d-none" value="5" title="5 stars" required>
                </label>
                <label>
                    <input type="radio" name="resourceRating" class="d-none" value="4" title="4 stars">
                </label>
                <label>
                    <input type="radio" name="resourceRating" class="d-none" value="3" title="3 stars">
                </label>
                <label>
                    <input type="radio" name="resourceRating" class="d-none" value="2" title="2 stars">
                </label>
                <label>
                    <input type="radio" name="resourceRating" class="d-none" value="1" title="1 star">
                </label>
            </div>

            <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white">Submit</button>
        </form>

      </div>

    </div>
  </div>
</div>
<div>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Horizontal Ad -->
    <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-1285809732280483"
        data-ad-slot="5536262823"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
 </div>
@push('js')
<script>
    $('.rating input').change(function () {
        var $radio = $(this);
        $('.rating .selected').removeClass('selected');
        $radio.closest('label').addClass('selected');
    });
</script>
@endpush
@endsection
