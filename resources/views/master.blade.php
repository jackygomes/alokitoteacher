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
    <link rel="stylesheet" href="{{URL::asset('css/style1.css')}}">




</head>


<body>
    <!--navStart -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

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

            <ul class="navbar-nav ml-auto mr-3">


                <li class="nav-item active">
                    <a class="nav-link text-black" href="{{ url('/') }}">Home
                <span class="sr-only">(current)</span>
              </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn background-yellow text-black" href="{{ url('all') }}">Toolkits/Course</a>
                </li>
                <!--
                <li class="nav-item">
                    <a class="nav-link text-black" href="@if(Auth::check() && Auth::user()->identifier == 1) {{ url('jobs/all') }} @else {{ url('jobs') }} @endif">Jobs</a>
                </li>
-->

                <li class="nav-item">

                    <a class="nav-link text-black" href="{{ url('about_us') }}">About Us</a>

                </li>

                @guest
                <li class="nav-item">
                    <a class="nav-link text-black" href="{{ url('login') }}">Login</a>
                </li>
                @endguest @auth
                <div class="btn-group ml-2">
                    <button type="button" class="btn background-yellow text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu">
                        @if(Auth::user()->identifier == 101)
                        <a class="dropdown-item" href="@if(Auth::user()->identifier == 101) {{ url('admin') }}@endif/{{ Auth::user()->username }}">Dashboard</a>
                        @else
                        <a class="dropdown-item" href="@if(Auth::user()->identifier == 1){{ url('t') }}@elseif(Auth::user()->identifier == 2) {{ url('s') }}@endif/{{ Auth::user()->username }}">Profile</a>
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


    <!-- Start of Footer area -->
    <footer class="page-footer font-small special-color-dark pt-4 bg-dark">

        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center">
                    <h4 class="font-weight-bold text-white">QUICK LINKS</h4>
                    <ul class="list-unstyled">
                        <li> <a class="font-weight-bold text-orange custom-hover" href="{{ url('about_us') }}">About us</a></li>
                        <li> <a class="font-weight-bold text-orange custom-hover" href="{{ url('/') }}">Alokito Journey</a></li>
                        <li> <a class="font-weight-bold text-orange custom-hover" href="{{ url('/book_workshop') }}">Book a workshop</a></li>
                        <li> <a class="font-weight-bold text-orange custom-hover" href="{{ url('toolkit') }}">Toolkits</a></li>
                        <li> <a class="font-weight-bold text-orange custom-hover" href="{{ url('course') }}">Courses</a></li>
                        <li> <a class="font-weight-bold text-orange custom-hover" href="{{ url('contact_us') }}">Contact Us</a></li>
                    </ul>
                </div>



                <div class="col-md-3 text-center">
                    <h4 class="font-weight-bold text-white">GET IN TOUCH</h4>
                    <p class="font-weight-bold text-orange">3/11, Block B, Lalmatia, Dhaka 1207, Bangladesh</p>
                    <ul class="list-unstyled mb-5">
                        <li>
                            <a class="mt-3 font-weight-bold text-orange custom-hover" href="tel:+8801742812044">+880-1742812044</a>
                        </li>
                        <li>
                            <a class="mt-3 font-weight-bold text-orange custom-hover" href="mailto:info@alokitoteachers.com">info@alokitoteachers.com</a>
                        </li>
                    </ul>

                </div>


                <div class="col-md-3">
                    <h4 class="text-white text-center font-weight-bold">SUBSCRIBE TO OUR MAILING LIST</h4>
                    <form action="{{ url('email_subscribe') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="col-sm-3 col-md-12">
                                <div class="text-center">
                                    <form action="{{ url('email_subscribe') }}" method="POST">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email Address">
                                        <button type="submit" class="mt-3 btn background-yellow px-2 py-2 shadow font-weight-bold text-dark">SUBSCRIBE</button>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-3 text-center">
                    <h4 class="font-weight-bold text-white" id="footer-social">STAY CONNECTED</h4>
                    <div class="social-icon mb-5">
                        <a href="https://www.facebook.com/Alokito-Teachers-1022969321242132" target="_blank"><i class="fab fa-facebook fa-2x mr-2 custom-hover2" style="color:#3b5998;"></i></a>
                        <a href="https://www.youtube.com/channel/UCY4PBN9HLG5oxjCtYXGvfeg" target="_blank"><i class="fab fa-youtube fa-2x mr-2 custom-hover2"style="color: #c4302b"></i></a>
                        <a href="https://www.linkedin.com/company/14756318/" target="_blank"><i class="fab fa-linkedin fa-2x mr-2 custom-hover2"style="color:#0E76A8;"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-instagram fa-2x mr-2 custom-hover2"style="color:#C13584"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </footer>
    <!-- End of Footer area -->

    <section class="copyright" style="background: #f5b82f;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="text-center text-white">
                        &copy; Alokito Teachers {{ now()->year }}.
                    </div>
                </div>
            </div>
        </div>
    </section>



    <script src="{{URL::asset('js/app.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{URL::asset('js/custom.js')}}"></script>

    <script type="text/javascript">
        $('#popover').popover();
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy'
        });
    </script>

    @stack('js')

</body>

</html>
