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



        <h3 class="mt-3 font-weight-bold text-white">{{Auth::user()->name}}</h3>

          <div class="row text-left p-2 mt-3">

            <div class="col-2">
              <i class="fas fa-map-marked-alt"></i>
            </div>
            <div class="col-10">
               @if(Auth::user()->location != null) {{ Auth::user()->location }} @else - @endif
            </div>

            <div class="col-2">
              <i class="fas fa-book"></i>
            </div>
            <div class="col-10">
              @if(Auth::user()->curriculum != null) {{ Auth::user()->curriculum }} @else - @endif
            </div>

            <div class="col-5 mt-3">
              Class range:
            </div>
            <div class="col-7 mt-3">
              @if(Auth::user()->class_range != null) {{ Auth::user()->class_range }} @else - @endif
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
         <p>৳{{ round(Auth::user()->balance, 2) }}</p>
         <div class="">
             <a href="{{route('deposit.form')}}" class=" btn btn-success btn-sm"style="display: inline-block" >Deposit</a>
             <a href="{{route('withdraw.form')}}" class=" btn btn-danger btn-sm" style="display: inline-block">Withdraw</a>
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
              <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label>

              <div class="col-md-6">
                  <input id="location" type="text" class="form-control border-yellow @error('location') is-invalid @enderror" name="location" value="{{ Auth::user()->location }}" required autocomplete="location" autofocus>

                  @error('location')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>


          @if(Auth::user()->identifier == 2)

          <div class="form-group row">
            <label for="curriculum" class="col-md-4 col-form-label text-md-right">{{ __('Curriculumn') }}</label>
            <div class="col-md-6">
                  <select id="curriculum" class="form-control border-yellow @error('curriculum') is-invalid @enderror" name="curriculum" required autocomplete="curriculum" autofocus>
                    <option disable>{{ Auth::user()->curriculum }}</option>
                    <option value="Primary Bangla medium">Primary Bangla medium</option>
                    <option value="Primary English version">Primary English version</option>
                    <option value="Secondary Bangla medium">Secondary Bangla medium</option>
                    <option value="Secondary English version">Secondary English version</option>
                    <option value="Madrasa">Madrasa</option>
                    <option value="International Baccalaureate (IB)">International Baccalaureate (IB)</option>
                    <option value="Cambridge">Cambridge</option>
                    <option value="Edexcel">Edexcel</option>
                    <option value="General Certificate of Secondary Education (GCSE)">General Certificate of Secondary Education (GCSE)</option>
                    <option value="International General Certificate of Secondary Education (IGCSE)">International General Certificate of Secondary Education (IGCSE)</option>
                    <option value="General Certificate of Education (GCE)">General Certificate of Education (GCE)</option>
                    <option value="Other">Other</option>
                  </select>

                  @error('curriculum')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="classes_from" class="col-md-4 col-form-label text-md-right">{{ __('Class From') }}</label>

              <div class="col-md-6">
                  <input id="classes_from" type="text" class="form-control border-yellow @error('classes_from') is-invalid @enderror" name="classes_from" value="{{ Auth::user()->classes_from }}" required autocomplete="classes_from" autofocus>

                  @error('classes_from')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="classes_to" class="col-md-4 col-form-label text-md-right">{{ __('Class To') }}</label>

              <div class="col-md-6">
                  <input id="classes_to" type="text" class="form-control border-yellow @error('classes_to') is-invalid @enderror" name="classes_to" value="{{ Auth::user()->classes_to }}" required autocomplete="classes_to" autofocus>

                  @error('classes_to')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>



          <div class="form-group row">
              <label for="no_of_student" class="col-md-4 col-form-label text-md-right">{{ __('Number of Students') }}</label>

              <div class="col-md-6">
                  <input id="students" type="text" class="form-control border-yellow @error('no_of_student') is-invalid @enderror" name="no_of_student" value="{{ Auth::user()->no_of_student }}" required autocomplete="no_of_student" autofocus>

                  @error('no_of_student')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="no_of_teacher" class="col-md-4 col-form-label text-md-right">{{ __('Number of Teachers') }}</label>

              <div class="col-md-6">
                  <input id="no_of_teacher" type="text" class="form-control border-yellow @error('no_of_teacher') is-invalid @enderror" name="no_of_teacher" value="{{ Auth::user()->no_of_teacher }}" required autocomplete="no_of_teacher" autofocus>

                  @error('no_of_teacher')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

           <div class="form-group row">
              <label for="no_of_teacher_alo_cert" class="col-md-4 col-form-label text-md-right">{{ __('No of teacher with Alokito Certificate') }}</label>

              <div class="col-md-6">
                  <input id="no_of_teacher_alo_cert" type="text" class="form-control border-yellow @error('no_of_teacher_alo_cert') is-invalid @enderror" name="no_of_teacher_alo_cert" value="{{ Auth::user()->no_of_teacher_alo_cert }}" required autocomplete="no_of_teacher_alo_cert" autofocus>

                  @error('no_of_teacher_alo_cert')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="no_of_alokito_master" class="col-md-4 col-form-label text-md-right">{{ __('No of Alokito Master') }}</label>

              <div class="col-md-6">
                  <input id="no_of_alokito_master" type="text" class="form-control border-yellow @error('no_of_alokito_master') is-invalid @enderror" name="no_of_alokito_master" value="{{ Auth::user()->no_of_alokito_master }}" required autocomplete="no_of_alokito_master" autofocus>

                  @error('no_of_alokito_master')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="founded" class="col-md-4 col-form-label text-md-right">{{ __('Founded') }}</label>

              <div class="col-md-6">
                  <input id="founded" type="text" class="datepicker form-control border-yellow @error('founded') is-invalid @enderror" name="founded" value="{{ Auth::user()->founded }}" required autocomplete="founded" autofocus>

                  @error('no_of_teachers')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="founded" class="col-md-4 col-form-label text-md-right">{{ __('Does the school have a playing area?') }}</label>

              <div class="col-md-6">
                  <select id="playing_area" class="form-control border-yellow @error('playing_area') is-invalid @enderror" name="playing_area" required autocomplete="playing_area" autofocus>
                    <option value="{{ Auth::user()->playing_area }}">@if(Auth::user()->playing_area == '1')Yes @elseif (Auth::user()->playing_area == '0') No @endif</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>

                  @error('playing_area')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="founded" class="col-md-4 col-form-label text-md-right">{{ __('How many students are there per classroom?') }}</label>

              <div class="col-md-6">
                  <input id="students_per_classroom" type="text" class="form-control border-yellow @error('students_per_classroom') is-invalid @enderror" name="students_per_classroom" value="{{ Auth::user()->students_per_classroom }}" required autocomplete="students_per_classroom" autofocus>

                  @error('students_per_classroom')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>


          <div class="form-group row">
              <label for="founded" class="col-md-4 col-form-label text-md-right">{{ __('Minimum qualifications needed to be a teacher') }}</label>

              <div class="col-md-6">

                <select id="min_qualification_teacher" class="form-control border-yellow @error('min_qualification_teacher') is-invalid @enderror" name="min_qualification_teacher" required autocomplete="min_qualification_teacher" autofocus>
                    <option disable>{{ Auth::user()->min_qualification_teacher }}</option>
                    <option value="Higher Secondary School Certificate">Higher Secondary School Certificate</option>
                    <option value="Advanced Level">Advanced Level</option>
                    <option value="Alim">Alim</option>
                  </select>

                  @error('min_qualification_teacher')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="founded" class="col-md-4 col-form-label text-md-right">{{ __('How long are the subject periods (minutes)?') }}</label>

              <div class="col-md-6">
                  <input id="subject_periods" type="text" class="form-control border-yellow @error('subject_periods') is-invalid @enderror" name="subject_periods" value="{{ Auth::user()->subject_periods }}" required autocomplete="subject_periods" autofocus>

                  @error('students_per_classroom')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          @endif






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
