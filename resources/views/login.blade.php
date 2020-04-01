@extends('master')
@section('content')


<section class="login_banner">

        <div class="jumbotron jumbotron-fluid">
          <div class="container">
            <h1 class="display-4">Log In Or Sign Up</h1>
            <p class="lead">Join Us To Take Teaching Style In To a New Level</p>
          </div>
        </div>
</section>


<section id="login-form " > 
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="login-form mt-5"><!--login form-->
                        <h2>Login to your account</h2>
                        <form method="post" action="{{ url('login') }}">
                            
                            {{csrf_field()}}

                            <input class="form-control @error('username') is-invalid @enderror" type="text" placeholder="Email or Username" name="username" required/>
                             @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" required/>

                             @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            
                            <button type="submit" class="btn btn-default">Login</button>

                          <div class="mt-3 mr-3" >
                                <label class="customcheck">Remember Me
                                  <input type="checkbox" checked="checked">
                                  <span class="checkmark"></span>
                                </label>   
                        </div>


                         <!--
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                 </div>

                               <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                           
                                login form-->


                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif

                            
                        </form>
                    </div><!--/login form-->
                </div>

                <div class="col-sm-2">
                    <h2 class="or">OR</h2>
                </div>

                <div class="col-sm-5">
                    <div class="signup-form"><!--sign up form-->
                        <h2>New User Signup!</h2>

                        <div class="mt-2 mb-5">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Teacher</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">School</a>
                                  </div>
                                </div>
                        </div>
                        <form action="{{ url('register')}}" method="post">

                            {{csrf_field()}}

                            <input type="text" placeholder="Full Name" name="name" required/>
                            <input type="text" placeholder="Username Name" name="username" required/>
                            <input type="email" placeholder="Email Address" name="customer_email" required/>
                            <input type="password" placeholder="Password" name="customer_email" required/>
                            <input type="text" placeholder="Mobile Number" name="mobile_number" required/>
                            

                            <button type="submit" class="btn btn-default mt-2 mb-5">Signup</button>
                        </form>
                    </div><!--/sign up form-->
                </div>


            </div>
        </div>
    </section><!--/form-->

    @endsection