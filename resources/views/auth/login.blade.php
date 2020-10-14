@extends('master')
@section('content')


<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <h1 class="font-weight-bold  mt-5 mb-5">Log In</h1>

                  <form action="{{ url('login')}}" method="POST" class="mb-5">
                    {{csrf_field()}}
                  <div class="container-fluid">
                    <div class="form-row mb-4">
                      <div class="col-md-12">

                         <input id="email" type="text" class="form-control border-yellow @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror



                      </div>

                    </div>
                   </div>
                  <div class="container-fluid">
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-5">

                        <input id="password" type="password" class="form-control border-yellow @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" placeholder="Password" autofocus>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                  </div>

                  <div class="container-fluid">
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                      <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white">Login</button>

                      </div>
                    </div>
                  </div>

                  <div class="container-fluid">
                    <div class="form-row">
                      <div class="col-md-12">

                        <a href="{{ route('password.request') }}" class="font-weight-bold text-yellow">Forgot Your Password ?</a>
                      </div>
                    </div>
                  </div>


                 </form>


         </div>

        <div class="col-md-2">
          <div class="m-auto text-center " style="background-color: #f5b82f; width: 100px; height: 100px; border-radius: 50%;">
            <h2 class="text-white" style="padding: 30%;">OR</h2>
          </div>
        </div>

        <div class="col-md-4 mr-1 ml-2">
            <h1 class="font-weight-bold my-5">Sign-Up</h1>
            <div>

                <form action="{{ url('register')}}" method="POST" class="mb-5">
                  {{csrf_field()}}
                  <div class="container-fluid">
                    <div class="form-row mb-4">
                      <div class="col-md-12">


                        <input id="name" type="text" class="form-control border-yellow @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Full Name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                   </div>
                  <div class="container-fluid">
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="username" type="text" class="form-control border-yellow @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="Username" autofocus>

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                  </div>

                  <div class="container-fluid">
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="email" type="email" class="form-control border-yellow @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                  </div>

                  <div class="container-fluid">
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="phone_number" type="tel" class="form-control border-yellow @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="phone_number" placeholder="Phone Ex: 01XXXXXXXXX"  pattern="[0-9]{11}" autofocus required>

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                  </div>

                    <div class="container-fluid">
                        <div class="form-row mt-1">
                            <div class="col-md-12">
                                <div class="form-group">
{{--                                    <label>Gender:</label>--}}
                                    <select class="form-control border-yellow" name="gender">
                                        <option value="" disabled selected>-- Select Your Gender --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                  <div class="container-fluid">
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="password" type="password" class="form-control border-yellow @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" placeholder="Password" autofocus>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                  </div>
                  <div class="container-fluid">
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="password_confirmation" type="password" class="form-control border-yellow @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="password_confirmation" placeholder="Confirm Password" autofocus>

                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>

                  </div>

                  <div class="container-fluid">
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <label>User Type:</label>
                          <select class="form-control border-yellow" name="identifier" required>
                            <option value="" disabled selected>-- Select User Type --</option>
                            <option value="1">Teacher</option>
                            <option value="2">School</option>
                            <!-- <option value="3">Parents</option> -->
                            <option value="4">Student</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="container-fluid">
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">
                        <button type="submit" class="mb-5 btn background-yellow text-white px-4 py-2 shadow font-weight-bold " >Signup</button>
                      </div>
                    </div>
                  </div>

                </form>
            </div>

         </div>




    </div>
</div>

    @endsection
