<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alokito Teachers</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{URL::asset('css/app.css')}}">
    <link rel="shortcut icon" href="{{URL::asset('favicon.ico')}}">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/style1.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/custom.css')}}">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-178521926-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-178521926-1');
    </script>



</head>


<body>
<!--navStart -->
<nav class="navbar navbar-expand-lg navbar-light">

    @if( Request::segment(1) == 'view')
        <ul class="navbar-nav mr-auto d-none d-md-block">
            <li class="nav-item">
                <div id="toggle">
                    <button type="button" id="sidebarCollapse" class="btn background-yellow">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <!-- <button type="button" class="navbar-toggle rarr collapsed" id="sidebarCollapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>   -->
                </div>
            </li>

        </ul>
        <a class="navbar-brand alokitologo ml-2" href="{{ url('/') }}"><img src="{{asset('images\logo\alokito_logo.png')}}"></a>
    @else
        <a class="navbar-brand alokitologo ml-5" href="{{ url('/') }}"><img src="{{asset('images\logo\alokito_logo.png')}}"></a>

@endif



<!-- <a href="" class="text-white font-weight-bold px-2 rounded" style="font-size: 2.0rem; background-color:#f5b82f ">Alokito Teacher</a> -->




    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav mr-auto ml-2">

            <li class="nav-item active">
                <a class="nav-link text-black" href="{{ url('/') }}">Home
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black" href="{{ route('jobBoard') }}">Job Board</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black" href="{{ url('all') }}">Course</a>
            </li>


            <li class="nav-item">

                <a class="nav-link text-black" href="{{ url('about_us') }}">About Us</a>

            </li>


        </ul>
        <ul class="navbar-nav ml-auto ml-2">
            @guest
                <li class="nav-item">
                    <a class="nav-link btn px-4 mr-2 text-black login-button" href="{{ url('login') }}">Login</a>
                </li>
                <li>
                    <a class="nav-link btn background-yellow px-4 text-white" href="{{ url('login') }}">Sign Up</a>
                </li>
            @endguest @auth
                <div class="btn-group ml-2">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu">
                        @if(Auth::user()->identifier == 101 || Auth::user()->identifier == 104)
                            <a class="dropdown-item" href="@if(Auth::user()->identifier == 101 || Auth::user()->identifier == 104) {{ url('dashboard') }}@endif">Dashboard</a>
                        @else
                            @if(Auth::user()->identifier == 1)
                                <a class="dropdown-item" href="{{url('t/dashboard')}}">Dashboard</a>
                            @elseif(Auth::user()->identifier == 2)
                                <a class="dropdown-item" href="{{url('s/dashboard')}}">Dashboard</a>
                            @endif
                            <a class="dropdown-item" href="@if(Auth::user()->identifier == 1){{ url('t') }}@elseif(Auth::user()->identifier == 2) {{ url('s') }}@elseif(Auth::user()->identifier == 4) {{ url('stu') }}@endif/{{ Auth::user()->username }}">Profile</a>
                        @endif
                        <a class="dropdown-item" href="{{ url('settings') }}">Settings</a>
                        <form action="{{ url('logout') }}" method="POST">
                            {{csrf_field()}}
                            <button type="submit" class="dropdown-item" href="{{ url('logout') }}">Logout</button>
                        </form>
                    </div>

                </div>
            @endauth
        </ul>
    </div>
</nav>


@yield('content')

<!-- End of Footer area -->

<section class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="">
                    Copyright &copy; Alokito Teachers {{ now()->year }}. All right reserved.
                </div>
            </div>
            <div class="col-md-5">
                <ul>
                    <li><a href="">Terms and Conditions</a></li>
                    <li><a href="">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>



<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="{{URL::asset('js/app.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-datepicker.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{URL::asset('js/jquery.checkImageSize.min.js')}}"></script>
<script src="{{URL::asset('js/owl.carousel.min.js')}}"></script>

<script src="{{URL::asset('js/custom.js')}}"></script>

<script type="text/javascript">
    $('#popover').popover();
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy'
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

@stack('js')

</body>

</html>
