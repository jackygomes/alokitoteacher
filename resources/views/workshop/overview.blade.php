@extends('master')
@section('content')
    <style>
        .card-body {
            min-height: 132px;
            height: 132px;
            overflow: hidden;
        }

        .activist-details-image {
            width: 80px;
            height: 80px;
        }
        .video-content {
            border-radius: 10px;
        }
        .right-panel {
            border: 2px solid #f59d1f;
            border-radius: 10px;
        }
        .rating-inactive {
            color: #9d9d9d;
        }
        .fa-star {
            font-size: 26px;
        }
        .nav-tabs .nav-link.active {
            color: #000;
            background-color: #fff;
            border: none;
            border-bottom: 2px solid #000;
        }
        .nav-tabs .nav-link {
            border:none;
        }
        .nav-tabs .nav-link:hover {
            border:none;
            color: #000;
            border-bottom: 2px solid #000;
        }
    </style>
<div class="container mt-4" style="min-height: 90vh;">
    <div class="row">

        <div class="col-md-12 text-left mb-3">
            <small class="text-black"> Overview of</small>
            <h3 class="font-weight-bold"> {{ $workshop->name }}</h3>
        </div>

        <div class="col-md-8">

            {!! $thumbnailPart !!}

            <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#about" role="tab" aria-controls="home" aria-selected="true">About this Workshop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#what" role="tab" aria-controls="profile" aria-selected="false">What you will learn</a>
                </li>
            </ul>
            <div class="tab-content pt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab">
                    <p>{!!$workshop->about_this_workshop!!}</p>
                </div>
                <div class="tab-pane fade show" id="what" role="tabpanel" aria-labelledby="about-tab">
                  <p>{!!$workshop->what_you_will_learn!!}</p>
                </div>
                
                
                
            </div>
        </div>

        <div class="col-md-4 text-center">
        <div class="right-panel p-5">
            @if($message = Session::get('success'))
            <div class="alert alert-success">
                {{$message}}
            </div>
            @endif
            <div style="width: 150px; height: 150px;" class="mx-auto">
                
                <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/logo/alokito_logo.png') }}">
            </div>
            <br>


            {{-- @for($i = 1; $i <= 5; $i++) @if($content_rating - $i>= 0)
                <i class="fa fa-star text-yellow" aria-hidden="true"></i>
                @else
                <i class="far fa-star rating-inactive"></i>
                @endif
                @endfor --}}
                <br>
                <br>
                <hr>
                <br>
                <span>
                    <span class="h3 text-success">
                        @if($workshop->price == 0)
                        Free
                        @else
                        {{ round($workshop->price, 2)}} BDT
                        @endif
                    </span>
                </span>
                <br>
                <!-- <button class="your-button-class" id="sslczPayBtn"
                 token="{{ csrf_token() }}"
                 postdata="your javascript arrays or objects which requires in backend"
                 order="If you already have the transaction generated for current order"
                 endpoint="{{ url('pay-via-ajax') }}"> Pay Now
         </button> -->
               

                {{-- <p class="mt-2">Total enrolled: {{$histories->count()}}</p> --}}

                @if(Request::segment(2) == 't')
                <p class="text-danger mt-3">***You can not retake this toolkit</p>
                @elseif(Request::segment(2) == 'c')
                <p class="text-danger mt-3">***You can not retake this course</p>
                @endif
        </div>
        </div>




    </div>
    <hr>
</div>
<div class="container">
   <div class="row">
       <div class="col-md-12">
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
   </div>
</div>






@push('js')

<script src="https://player.vimeo.com/api/player.js"></script>



<script>
   function insufficientBalance(url) {
       Swal.fire({
           icon: 'warning',
           title: 'Insufficiant Balance. Deposit your balance first.',
           confirmButtonColor: '#f5b82f',
           confirmButtonText: "Yes",
           showCancelButton: true,
           cancelButtonText: 'Cancel',
           cancelButtonColor: '#d33'
       }).then((result) => {
           if (result.isConfirmed) {
               window.location.href = url;
           }
       })
   }
    (function(window, document) {
        var loader = function() {
            var script = document.createElement("script"),
                tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>

@endpush

@endsection
