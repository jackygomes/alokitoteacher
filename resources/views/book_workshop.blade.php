
@extends('master')
@section('content')

<div class="container-fluid">
	<div class="row" style="min-height: 90vh">
		<div class="col-md-2 col-sm-12 pt-5 text-center" style="background-color: #f5b82f;"><!--left col-->


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

				<div class="col-5">
					Location:
				</div>
				<div class="col-7">
					{{ Auth::user()->location }}
				</div>

				<div class="col-5">
					</i> Curriculum:
				</div>
				<div class="col-7">
					{{ Auth::user()->curriculum }}
				</div>

				<div class="col-6">
					Class range:
				</div>
				<div class="col-6">
					{{ Auth::user()->class_range }}
				</div>

				
         	</div>

         	<div class="row text-left p-2 mt-3">
				<div class="col-12 mt-3">
					{{Auth::user()->email}}
				</div>
				<div class="col-8">
					{{Auth::user()->phone_number}}
				</div>
				<div class="col-4 mb-3">
					<span class="fa-clickable"><i class="fas fa-pen" ></i> <small>Edit</small></span>
				</div>
			</div>

			

			<h4>Current Balance </h4>
			<p>${{ round(Auth::user()->balance, 2) }}</p>
			<button type="button" class=" btn btn-success btn-sm"style="display: inline-block" >Deposit</button>
			<button type="button" class="  btn btn-danger btn-sm">Withdraw</button>
			
			
		</div>


	<div class="col-md-8 col-sm-12">
      
		<div class="container-fluid mt-5">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="mt-2 font-weight-bold" style="display: inline-block">Book a Workshop</h4>

				    <form class="mt-3" method="POST" action="{{ route('book_workshop') }}">
						@csrf

						@if(session()->has('success'))
						<div class="alert alert-success">
						    {{ session()->get('success') }}
						</div>
						@endif

						<div class="form-group row">
						  <label for="person" class="col-md-4 col-form-label text-md-right">{{ __('Total Person') }}</label>

						  <div class="col-md-6">
						      <input id="person" type="number" min="10" placeholder="Number of Person" class="form-control border-yellow @error('person') is-invalid @enderror" name="person" required autocomplete="person" autofocus>

						      @error('person')
						          <span class="invalid-feedback" role="alert">
						              <strong>{{ $message }}</strong>
						          </span>
						      @enderror
						  </div>
						</div>

						<div class="form-group row">
						  <label for="workshop" class="col-md-4 col-form-label text-md-right">{{ __('Book a Workshop') }}</label>

						  <div class="col-md-6">
						     <select class="form-control border-yellow" name="workshop" required>
				                <option value="" disabled selected>-- Select Workshop --</option>
				                <option value="Play based workshop (4 days)">Play based workshop (4 days)</option>
				                <option value="Inquiry based workshop (4 days)">Inquiry based workshop (4 days)</option>
				                <option value="Problem based workshop (4 days)">Problem based workshop (4 days)</option> 
				              </select>
						  </div>
						</div>

						<div class="form-group row">
						  <label for="time_slot" class="col-md-4 col-form-label text-md-right">{{ __('Time Slots') }}</label>

						  <div class="col-md-6">
						     <select class="form-control border-yellow" name="time_slot" required>
				                <option value="" disabled selected>-- Select Time Slot --</option>
				                <option value="09:00 - 15:00">9:00 AM - 3:00 PM</option>
				                <option value="10:00 - 16:00">10:00 AM - 4:00 PM</option>
				                <option value="11:00 - 17:00">11:00 AM - 5:00 PM</option>
				              </select>
						  </div>
						</div>

						<div class="form-group row">
						  <label for="from" class="col-md-4 col-form-label text-md-right">{{ __('Form') }}</label>

						  <div class="col-md-6">
						      <input id="from" type="text" class="datepicker form-control border-yellow @error('from') is-invalid @enderror" name="from" required autocomplete="from" autofocus>

						      @error('from')
						          <span class="invalid-feedback" role="alert">
						              <strong>{{ $message }}</strong>
						          </span>
						      @enderror
						  </div>
						</div>

						<div class="form-group row">
						  <label for="to" class="col-md-4 col-form-label text-md-right">{{ __('To') }}</label>

						  <div class="col-md-6">
						      <input id="to" type="text" class="datepicker form-control border-yellow @error('to') is-invalid @enderror" name="to" required autocomplete="to" autofocus>

						      

						      @error('to')
						          <span class="invalid-feedback" role="alert">
						              <strong>{{ $message }}</strong>
						          </span>
						      @enderror
						  </div>
						</div>

						<div class="form-group row">
						  <label for="details" class="col-md-4 col-form-label text-md-right">{{ __('Details') }}</label>

						  <div class="col-md-6">
						      <div class="form-group"><textarea class="form-control" rows="10" name="details" placeholder="Write Cover Letter Here" required></textarea></div>

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
							        {{ __('Book Workshop') }}
							    </button>
							</div>
						</div>
			    	</form>
					

				</div>
			</div>
		</div>	

				
		
			
 	</div> <!-- 2nd col ends here -->

	
	@include('leaderboard')


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