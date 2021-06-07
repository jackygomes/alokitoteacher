@extends('layouts.master-dashboard')
@section('content')


<div class="container-fluid">

    <div class="row" style="min-height: 100vh">
        @include('includes.dashboard.teacher')

    <div class="col-md-10 pt-5"  style="background-color: #f3f2f0;">
      <div class="container-fluid ">
          <h3>Change Profile Picture</h3>
          <hr>
          <form method="post" id="pro_pic_upload_form" class="mb-5" action="{{ url('upload_picture') }}" enctype="multipart/form-data">
          {{csrf_field()}}
          <!-- <div class="form-group mt-3">
                <input type="file" class="text-center center-block mx-auto" name="image">
                <input type="submit" class="btn background-yellow text-white mt-2" value="Upload">
              </div> -->
              <input type="file" name="image" id="profile_picture" data-min-width="200" data-min-height="200" data-max-width="200" data-max-height="200">
              <button type="button" id="pro_pic_choose" class="btn background-yellow text-white mt-2 mb-3 ml-5">Upload</button>
          </form>
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
            <div class="form-group row">
                <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Gender</label>
                <div class="col-md-6">
                    <select class="form-control border-yellow" name="gender" required>
                        <option value="" disabled>-- Select Your Gender --</option>
                        <option value="Male" {{Auth::user()->gender == 'Male' ? "selected" : ""}} >Male</option>
                        <option value="Female" {{Auth::user()->gender == 'Female' ? "selected" : ""}}>Female</option>
                    </select>

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
                <input id="password-confirm" type="password" class="form-control border-yellow" name="password_confirmation" required placeholder="Confirm new password" autocomplete="new-password"/>
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
   </div><!-- row ends here -->




</div>

@push('js')

    <script type="text/javascript">
        {{--      $('#pro_pic_choose').on('click', function () {--}}
        {{--          $("#profile_picture").click();--}}
        {{--      });--}}
        {{--      $("#profile_picture").change(function () {--}}
        {{--        $("#pro_pic_upload_form").submit();--}}
        {{--      });--}}
        $("#profile_picture").checkImageSize({
            minWidth: 200,
            minHeight: 200,
            maxWidth: 200,
            maxHeight: 200,
            showError:true,
            ignoreError:false
        });
    </script>

@endpush


@endsection
