@extends('master')
@section('content')
<style>
    input {
        padding: 24px 20px !important;
        border-radius: 8px !important;
    }
    .image {
        opacity: 0.8;
        width: 130px;
        height: 130px;
        background-position: center center;
        display: inline-block;
        margin: 10px;
        padding: 14%;
        position: relative;
    }
    .image:hover {
         opacity: 1;
     }

    .radio-img > input {
        display:none;
    }
    .image p {
        font-size: 12px;
        margin-top: 9px !important;
        line-height: 14px;
        margin: 0;
    }
    .image .checkmark{
        position: absolute;
        top: 7px;
        right: 7px;
        display: none;
    }
    .radio-img > .image{
        cursor:pointer;
        border: 1px solid #E1E1E1;
        border-radius: 8px;

    }
    .radio-img > input:checked + .image .checkmark{
        display: block;
    }
    .radio-img > input:checked + .image{
        border:1px solid #F59D1F;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-5">
            <h1 class="font-weight-bold  mt-3 mb-4">Log In</h1>
              <form action="{{ url('login')}}" method="POST" class="mb-5">
                    {{csrf_field()}}
                    <div class="form-row mb-4">
                      <div class="col-md-12">
                         <input id="email" type="text" class="form-control border-grey @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>

                    </div>
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-2">
                        <input id="password" type="password" class="form-control border-grey @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" placeholder="Password" autofocus>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-12 text-center pt-3 pb-4">
                          <a href="{{ route('password.request') }}" class="font-weight-bold" style="border-bottom: 1px solid #000;">Forgot Password ?</a>
                      </div>
                    </div>
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">
                        <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white btn-block">Login</button>
                      </div>
                    </div>
                 </form>


         </div>

        <div class="col-md-2">
            <div class="or-wrap">
                <p class="text-light-dark">OR</p>
            </div>
        </div>

        <div class="col-md-5">
            <h1 class="font-weight-bold mt-3 mb-4">Sign Up</h1>
            <div>

                <form action="{{ url('register')}}" method="POST">
                  {{csrf_field()}}
                    <div class="form-row mt-1 d-flex justify-content-center text-center">
                        <label class="radio-img">
                            <input type="radio" name="identifier" value="1" checked/>
                            <div class="image" >
                                <img src="{{asset('images/new_design/education.png')}}" alt="">
                                <img class="checkmark" src="{{asset('images/new_design/login-checkmark-circle.png')}}" alt="">
                                <p>Educator</p>
                            </div>
                        </label>

                        <label class="radio-img">
                            <input type="radio" name="identifier" value="2" />
                            <div class="image">
                                <img src="{{asset('images/new_design/institution.png')}}" alt="">
                                <img class="checkmark" src="{{asset('images/new_design/login-checkmark-circle.png')}}" alt="">
                                <p>Educational<br>Institution</p>
                            </div>
                        </label>

                        <label class="radio-img">
                            <input type="radio" name="identifier" value="4" />
                            <div class="image">
                                <img src="{{asset('images/new_design/student.png')}}" alt="">
                                <img class="checkmark" src="{{asset('images/new_design/login-checkmark-circle.png')}}" alt="">
                                <p>Student</p>
                            </div>
                        </label>
                    </div>

                    <div class="form-row mb-4">
                      <div class="col-md-12">


                        <input id="name" type="text" class="form-control border-grey @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Full Name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                    
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="username" type="text" class="form-control border-grey @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="Username" autofocus>

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="email" type="email" class="form-control border-grey @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="phone_number" type="tel" class="form-control border-grey @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="phone_number" placeholder="Phone Ex: 01XXXXXXXXX"  pattern="[0-9]{11}" autofocus required>

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                    <div id="gender-block" class="form-row mt-1">
                        <div class="col-md-12">
                            <div class="form-group">
{{--                                    <label>Gender:</label>--}}
                                <select class="form-control border-grey" name="gender">
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="institution-block" class="form-row mt-1">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control border-grey" name="school_type">
                                    <option value="" disabled selected>School Type</option>
                                    <option value="Bangla medium">Bangla medium</option>
                                    <option value="English medium">English medium</option>
                                    <option value="English version">English version</option>
                                    <option value="Madrasa">Madrasa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="password" type="password" class="form-control border-grey @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" placeholder="Password" autofocus>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>
                    <div class="form-row mt-1">
                      <div class="col-md-12 mb-3">

                        <input id="password_confirmation" type="password" class="form-control border-grey @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="password_confirmation" placeholder="Confirm Password" autofocus>

                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                      </div>

                    </div>

                    <div class="form-row mt-1">
                      <div class="col-md-12">
                        <button type="submit" class="btn background-yellow text-white px-4 py-2 shadow font-weight-bold btn-block" >Signup</button>
                      </div>
                    </div>

                </form>
            </div>

         </div>




    </div>
</div>
@push('js')

    <script type="text/javascript">


        $(document).ready(function () {
            $('#institution-block').hide();
            $('input[type=radio][name=identifier]').change(function() {
                if (this.value == '2') {
                    $('#gender-block').hide();
                    $('#institution-block').show();
                } else {
                    $('#gender-block').show();
                    $('#institution-block').hide();
                }
            });
        });
    </script>
@endpush
@endsection
