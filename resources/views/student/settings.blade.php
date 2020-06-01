@extends('master')
@section('content')


    <div class="container-fluid">

        <div class="row" style="min-height: 100vh">
            <div class="col-md-2 pt-5 pb-3 text-center" style="background-color: #f5b82f;"><!--left col-->

                <div style="width: 150px; height: 150px;" class="mx-auto">
                    @if(Auth::user()->image == null)
                        <i class="fas fa-user-circle fa-10x text-white"></i>
                    @else
                        <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ Auth::user()->image }}">
                    @endif
                </div>



                <form method="post" id="pro_pic_upload_form" action="{{ url('upload_picture') }}" enctype="multipart/form-data">
                {{csrf_field()}}
                <!-- <div class="form-group mt-3">
            <input type="file" class="text-center center-block mx-auto" name="image">
            <input type="submit" class="btn background-yellow text-white mt-2" value="Upload">
          </div> -->
                    <input type="file" name="image" id="profile_picture" class="d-none">
                    <button type="button" id="pro_pic_choose" class="btn bg-white mt-2 mb-3">Upload</button>
                </form>


                <h3 class="mt-5 font-weight-bold text-white"> {{ Auth::user()->name }}</h3>

                @for($i = 1; $i <= 5; $i++)
                    @if(Auth::user()->rating - $i >= 0)
                        <i class="fa fa-star" aria-hidden="true"></i>
                    @else
                        <i class="far fa-star text-white"></i>
                    @endif
                @endfor

                <div class="row text-left p-2 mt-3">
{{--                    <div class="col-12">--}}
{{--                        Recent Status:--}}
{{--                    </div>--}}
{{--                    <div class="col-2">--}}
{{--                        <i class="fas fa-graduation-cap"></i>--}}
{{--                    </div>--}}
{{--                    <div class="col-10">--}}
{{--                        @if($recent_institute != null) {{ $recent_institute->institute }} @else - @endif--}}
{{--                    </div>--}}

{{--                    <div class="col-2">--}}
{{--                        <i class="fas fa-briefcase"></i>--}}
{{--                    </div>--}}
{{--                    <div class="col-10">--}}
{{--                        @if($recent_work != null) {{ $recent_work->institute }} @else - @endif--}}
{{--                    </div>--}}

{{--                    <div class="col-2">--}}
{{--                        <i class="fas fa-user-tie"></i>--}}
{{--                    </div>--}}
{{--                    <div class="col-10">--}}
{{--                        @if($recent_work != null) {{ $recent_work->position }} @else - @endif--}}
{{--                    </div>--}}

                    <div class="col-2 mt-3">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <div class="col-10 mt-3">
                        @if(Auth::user()->date_of_birth != null) {{ date("jS F, Y", strtotime(Auth::user()->date_of_birth)) }} @else - @endif
                    </div>
                </div>



                <div class="row text-left p-2 mt-3">
                    <div class="col-2">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="col-10">
                        {{ Auth::user()->email }}
                    </div>
                    <div class="col-2">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="col-10">
                        {{ Auth::user()->phone_number }}
                    </div>

                </div>




                <h4 class="mt-3">Current Balance </h4>
                <p>{{ round(Auth::user()->balance, 2) }}</p>
                <div class="">
                    <button type="button" class=" btn btn-success btn-sm"style="display: inline-block" >Deposit</button>
                    <button type="button" class="  btn btn-danger btn-sm">Withdraw</button>
                </div>



            </div>

            <div class="col-md-8 pt-5"  style="background-color: #f3f2f0;">
                <div class="container-fluid ">
                    <h3 class="font-weight-bold" >Basic Info</h3>
                    <hr>

                    <form class="mt-3" method="POST" action="{{ route('updateInfo') }}">
                        @csrf

                        @if(session()->has('successInfo'))
                            <div class="alert alert-success">
                                {{ session()->get('successInfo') }}
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control border-yellow @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="tel" class="form-control border-yellow @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ Auth::user()->phone_number }}" placeholder="Phone Ex: 01XXXXXXXXX" pattern="[0-9]{11}" required autocomplete="phone_number" autofocus>



                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>
                            <div class="col-md-6">
                                <input id="date_of_birth" type="text" class="datepicker form-control border-yellow @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ Auth::user()->date_of_birth }}" required autocomplete="date_of_birth" autofocus>

                                @error('date_of_birth')
                                <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                                @enderror
                            </div>
                        </div>






                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn background-yellow">
                                    {{ __('Update Info') }}
                                </button>
                            </div>
                        </div>
                    </form>



                    <h3 class="font-weight-bold mt-5" >Change Password</h3>
                    <hr>

                    <form class="mt-3" method="POST" action="{{ route('updatePassword') }}">
                        @csrf

                        @if(session()->has('successPassword'))
                            <div class="alert alert-success">
                                {{ session()->get('successPassword') }}
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password" class="form-control border-yellow @error('current_password') is-invalid @enderror" name="current_password" placeholder="Enter your current password" required autocomplete="current-password">

                                @error('current_password')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control border-yellow @error('password') is-invalid @enderror" name="password" required placeholder="Enter new password" autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control border-yellow" name="password_confirmation" required placeholder="Confirm new password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn background-yellow">
                                    {{ __('Change Password') }}
                                </button>
                            </div>
                        </div>


                    </form>





                </div>






            </div> <!-- 2nd col ends here -->

            <div class="col-md-2 pt-3" style="border-left: 1px solid #e0e0e0; background-color: #f3f2f0;">
            </div>





        </div><!-- row ends here -->




    </div>

    @push('js')

        <script type="text/javascript">
            $('#pro_pic_choose').on('click', function () {
                $("#profile_picture").click();
            });
            $("#profile_picture").change(function () {
                $("#pro_pic_upload_form").submit();
            });
        </script>

    @endpush


@endsection
