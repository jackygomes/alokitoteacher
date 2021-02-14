
@extends('master')
@section('content')

<div class="container-fluid">
	<div class="row" style="min-height: 90vh">
		<div class="col-md-3 col-sm-12 pt-5 text-center" style="background-color: #f5b82f;"><!--left col-->


			<div style="width: 150px; height: 150px;" class="mx-auto">
	        @if($user_info->image == null)
	          <i class="fas fa-user-circle fa-10x text-white"></i>
	        @else
	          <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $user_info->image }}">
	        @endif
	        </div>

		    @if($user_info->id == Auth::id())
	        <form method="post" id="pro_pic_upload_form" action="{{ url('upload_picture') }}" enctype="multipart/form-data">
	          {{csrf_field()}}
	          <!-- <div class="form-group mt-3">
	            <input type="file" class="text-center center-block mx-auto" name="image">
	            <input type="submit" class="btn background-yellow text-white mt-2" value="Upload">
	          </div> -->
	          <input type="file" name="image" id="profile_picture" class="d-none">
	          <button type="button" id="pro_pic_choose" class="btn bg-white mt-2 mb-3">Upload</button>
	        </form>
	        @endif

			<h3 class="mt-3 font-weight-bold text-white">{{$user_info->name}}</h3>

			<div class="row text-left p-2 mt-3">

				<div class="col-2">
					<i class="fas fa-map-marked-alt"></i>
				</div>
				<div class="col-10">
					{{ $user_info->location == null ? '-' :  $user_info->location }}
				</div>

				<div class="col-2">
					<i class="fas fa-book"></i>
				</div>
				<div class="col-10">
					{{ $user_info->curriculum == null ? '-' :  $user_info->curriculum }}
				</div>

				<div class="col-5 mt-3">
					Class range:
				</div>
				<div class="col-7  mt-3">
					{{ $user_info->classes_from == null ? '-' :  $user_info->classes_from }} - {{ $user_info->classes_to == null ? '-' :  $user_info->classes_to }}
				</div>

         	</div>

			@if($user_info->id == Auth::id())
			<div class="row text-left p-2 my-3">
				<div class="col-2">
	              <i class="fas fa-envelope"></i>
	            </div>
				<div class="col-10">
					{{$user_info->email}}
				</div>
				<div class="col-2">
	              <i class="fas fa-phone"></i>
	            </div>
				<div class="col-10">
					{{$user_info->phone_number}}
				</div>

			</div>

			<h4>Current Balance </h4>
			<p>৳{{ round($user_info->balance, 2) }}</p>
                <a href="{{route('deposit.form')}}" class=" btn btn-success btn-sm"style="display: inline-block" >Deposit</a>
				<a href="{{route('withdraw.form')}}" class=" btn btn-danger btn-sm" style="display: inline-block">Withdraw</a>
			@endif

		</div>


	<div class="col-md-8 col-sm-12">
      <div class="container-fluid">
      	<div class="row">
      		<div class="col-sm-12 pt-3">
      			<h3 class="" style="display: inline-block">Overview</h3>
      			@if($user_info->id == Auth::id())
					<a href="{{ url('settings') }}"><i class="ml-2 fas fa-pen"></i> Edit</a>
				@endif


      		</div>
      	</div>
      </div>


      <div class="container-fluid">
      	<div class="row">
      		<div class="card p-3 col-sm-12">

      			<p><span class="font-weight-bold">Location:</span> {{$user_info->location}}</p>
				<p><span class="font-weight-bold">Curriculum:</span> {{$user_info->curriculum}}</p>
				<p><span class="font-weight-bold">Classes From:</span> {{$user_info->classes_from}}</p>
				<p><span class="font-weight-bold">Classes To:</span> {{$user_info->classes_to}}</p>
				<p><span class="font-weight-bold">Number Of Students:</span> {{$user_info->no_of_student}}</p>
				<p><span class="font-weight-bold">Number Of Teachers:</span> {{$user_info->no_of_teacher}}</p>
				<p><span class="font-weight-bold">Number of Teachers with Alokito Certification:</span> {{$user_info->no_of_teacher_alo_cert}}</p>
				<p><span class="font-weight-bold">Number of Alokito Master Trainer:</span> {{$user_info->no_of_alokito_master}}</p>
				<p><span class="font-weight-bold">Founded:</span> {{ date("jS F, Y", strtotime($user_info->founded)) }}</p>
				<p><span class="font-weight-bold">Playing area:</span> @if(Auth::user()->playing_area == '1')Yes @elseif (Auth::user()->playing_area == '0') No @endif</p>
				<p><span class="font-weight-bold">Students per classroom:</span> {{ $user_info->students_per_classroom }}</p>
				<p><span class="font-weight-bold">Teacher student ratio(Teacher to Student):</span> {{ $user_info->no_of_teacher }} : {{ $user_info->no_of_student }}</p>
				<p><span class="font-weight-bold">Minimum qualification of teacher:</span> {{ $user_info->min_qualification_teacher }}</p>
				<p><span class="font-weight-bold">Subject periods:</span> {{ $user_info->subject_periods }}</p>
      		</div>
      	</div>
      </div>


{{--		<div class="container-fluid mt-5">--}}
{{--			<div class="row">--}}
{{--				<div class="col-sm-12">--}}
{{--					<h4 class="mt-2 font-weight-bold" style="display: inline-block">Jobs</h4>--}}
{{--					@if($user_info->id == Auth::id())--}}
{{--					<span class="ml-4 fa-clickable" data-toggle="modal" data-target="#addJobModal"><i class="fas fa-plus-circle text-success"></i> Post New Job</span>--}}
{{--					@endif--}}

{{--					@if(session()->has('success'))--}}
{{--					    <div class="alert alert-success">--}}
{{--					        {{ session()->get('success') }}--}}
{{--					    </div>--}}
{{--					@endif--}}

{{--					@if(session()->has('danger'))--}}
{{--					    <div class="alert alert-danger">--}}
{{--					        {{ session()->get('danger') }}--}}
{{--					    </div>--}}
{{--					@endif--}}



{{--					<table class="table">--}}
{{--						<tbody>--}}


{{--							@foreach ($job_info as $job)--}}

{{--							<tr>--}}
{{--					        	<td class="bg-white">--}}
{{--					        		<div class="container-fluid">--}}
{{--					        			<div class="row">--}}
{{--					        				<div class="col-md-2  my-auto text-center">--}}
{{--					        					@if($user_info->image == null)--}}
{{--									          		<i class="fas fa-user-circle fa-5x text-yellow"></i>--}}
{{--										        @else--}}
{{--										        <div class="mx-auto" style="width: 70px; height: 70px;">--}}
{{--										          <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $user_info->image }}">--}}
{{--										        </div>--}}
{{--										        @endif--}}

{{--							        		</div>--}}


{{--						        			<div class="col-md-7">--}}
{{--						        				<span class="font-weight-bold">Job Positon: {{ $job->job_title }}</span><br>--}}

{{--								        		<span class="font-weight-bold">Salary Range: {{ $job->expected_salary_range }}</span><br>--}}

{{--								        		<span class="font-weight-bold">Type:</span><span>@if($job->nature == 1) Permanent @elseif($job->nature == 2) Part-Time  @elseif($job->nature == 3) Contractual @else - @endif</span><br>--}}

{{--								        		<span class="font-weight-bold">Vacancy:</span><span> {{ $job->vacancy }}</span><br>--}}

{{--								        		<span class="font-weight-bold" >Description:</span>--}}

{{--								        		{{ str_limit(strip_tags($job->description), 150) }}--}}

{{--									              <a href="{{ url('job_detail') }}/{{ $job->id }}" class="text-yellow">Read More</a>--}}


{{--						        			</div>--}}

{{--						        			<div class="col-md-3">--}}
{{--						        				<small>--}}
{{--						        				Published: {{ date("jS F, Y", strtotime($job->created_at)) }}</small>--}}
{{--						        				<br>--}}
{{--						        				<small class="text-danger">--}}
{{--						        				Deadline: {{ date("jS F, Y", strtotime($job->deadline)) }}</small>--}}
{{--						        				<br>--}}

{{--						        				@if($user_info->id == Auth::id())--}}
{{--						        				<a class="btn btn-success text-white btn-sm">Edit</a>--}}
{{--						        				<a href="{{ url('remove_job') }}/{{ $job->id }}" class="btn btn-danger btn-sm">Remove</a>--}}
{{--						        				@else--}}
{{--						        				<button type="button" value="{{ $job->job_id }}" class="btn btn-success applyButton" data-toggle="modal" data-target="#coverLetterModal">Apply</button>--}}
{{--						        				<button type="button" value="{{ $job->job_id }}" class="btn border-yellow saveButton">Save</button>--}}
{{--						        				@endif--}}
{{--						        			</div>--}}
{{--					        			</div>--}}
{{--					        		</div>--}}
{{--					        	 </td>--}}
{{--					      	</tr>--}}


{{--						<!-- 	<tr>--}}

{{--								<td class="w-25 text-center">--}}
{{--									@if($user_info->image == null)--}}
{{--							          <i class="fas fa-user-circle fa-7x text-yellow"></i>--}}
{{--							        @else--}}
{{--							          <img class="img-fluid rounded-circle" style="height: 150px; width: 150px" src="{{ url('images/profile_picture') }}/{{ $user_info->image }}">--}}
{{--							        @endif--}}
{{--									<p class="mt-3">{{$user_info->name}}</p>--}}
{{--								</td>--}}

{{--								<td class="w-55">--}}
{{--									<p><span class="font-weight-bold">Job Position:</span> {{$job->job_title}}</p>--}}
{{--									<p><span class="font-weight-bold">Salary Range:</span> {{$job->expected_salary_range}}</p>--}}
{{--									<p><span class="font-weight-bold">Job Description:</span> {{ str_limit(strip_tags($job->description), 150) }}--}}

{{--										              <a href="{{ url('job_detail') }}/{{ $job->id }}" class="text-yellow">Read More</a>--}}

{{--										        </p>--}}
{{--								</td>--}}

{{--								@if($user_info->id == Auth::id())--}}
{{--								<td>--}}
{{--									<div class="">--}}
{{--										<i class="fas fa-pen fa-clickable"></i>--}}
{{--										<br>--}}
{{--										<i class="far fa-circle fa-clickable"></i>--}}
{{--										<br>--}}
{{--										<i class="fas fa-times-circle fa-clickable text-danger"></i>--}}
{{--									</div>--}}

{{--								</td>--}}
{{--								@endif--}}


{{--							</tr> -->--}}
{{--							@endforeach--}}


{{--						</tbody>--}}
{{--					</table>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}


{{--		<!-- this section is for card which is the current teacher at the school , not needed now , according to Niaz bhaiya--}}
{{--		<div class="container-fluid">--}}
{{--		   <div class="row">--}}
{{--			<div class="col-sm-2">--}}

{{--						<div class="card-deck mb-5" style="width: 700px;">--}}
{{--					<div class="card">--}}
{{--						<img src="{{asset('images\logo\dummy.jpg')}}" class="card-img-top" alt="...">--}}
{{--						<div class="card-body">--}}
{{--							<h5 class="card-title">Name</h5>--}}
{{--							<h5 class="card-title">Qualification</h5>--}}
{{--							<h5 class="card-title">Acheivements</h5>--}}
{{--							<p class="card-text"></p>--}}
{{--						</div>--}}
{{--						<div class="card-footer">--}}
{{--							<h5 class="card-title text-center">View</h5>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="card">--}}
{{--						<img src="{{asset('images\logo\dummy.jpg')}}" class="card-img-top" alt="...">--}}
{{--						<div class="card-body">--}}
{{--							<h5 class="card-title">Name</h5>--}}
{{--							<h5 class="card-title">Qualification</h5>--}}
{{--							<h5 class="card-title">Acheivements</h5>--}}
{{--							<p class="card-text"></p>--}}
{{--						</div>--}}

{{--						<div class="card-footer">--}}
{{--							<h5 class="card-title text-center">View</h5>--}}
{{--						</div>--}}
{{--					</div>--}}


{{--					<div class="card">--}}
{{--						<img src="{{asset('images\logo\dummy.jpg')}}" class="card-img-top" alt="...">--}}
{{--						<div class="card-body">--}}
{{--							<h5 class="card-title">Name</h5>--}}
{{--							<h5 class="card-title">Qualification</h5>--}}
{{--							<h5 class="card-title">Acheivements</h5>--}}
{{--							<p class="card-text"></p>--}}
{{--						</div>--}}
{{--						<div class="card-footer">--}}
{{--							<h5 class="card-title text-center">View</h5>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}

{{--				</div>--}}
{{--			</div>--}}
{{--		</div> -->--}}




{{-- </div> <!-- 2nd col ends here -->--}}

{{--		@include('leaderboard')--}}


{{--    </div><!-- row ends here -->--}}

{{--</div>--}}


{{--<!-- Modal -->--}}
{{--<div class="modal fade" id="addJobModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
{{--  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">--}}
{{--    <div class="modal-content">--}}
{{--		<div class="modal-header">--}}
{{--			<h5 class="modal-title" id="modalLongTitle">Add New Job</h5>--}}
{{--			<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--			  <span aria-hidden="true">&times;</span>--}}
{{--			</button>--}}
{{--		</div>--}}

{{--      	<div class="modal-body" id="modalBody">--}}

{{--      		<form action="{{ route('add_job') }}" method="POST" class="mb-5">--}}


{{--                <div class="form-row mb-4">--}}
{{--                  <div class="col-md-12">--}}
{{--                  	<label>Job Title <span class="text-danger font-weight-bold"> *</span>:</label>--}}
{{--                     <input id="title" type="text" class="form-control border-yellow" name="job_title" required placeholder="Job Title">--}}
{{--                  </div>--}}

{{--                </div>--}}


{{--            	<div class="form-row mt-1">--}}
{{--					<div class="col-md-12 mb-5">--}}
{{--						<label>Location <span class="text-danger font-weight-bold"> *</span>:</label>--}}
{{--						<input id="location" type="text" class="form-control border-yellow" name="location" required placeholder="Job Location">--}}

{{--					</div>--}}

{{--            	</div>--}}

{{--            	<div class="form-row mt-1">--}}
{{--					<div class="col-md-12 mb-5">--}}
{{--						<label>Salary Range:</label>--}}
{{--						<input id="salary" type="text" class="form-control border-yellow" name="expected_salary_range" required placeholder="Salary Range (10,000 - 15,000/ Negotiable)">--}}

{{--					</div>--}}

{{--            	</div>--}}

{{--            	<div class="form-row mt-1">--}}
{{--					<div class="col-md-12 mb-5">--}}
{{--						<label>Minimum Requirements <span class="text-danger font-weight-bold"> *</span>:</label>--}}
{{--						<textarea class="form-control border-yellow" rows="5" name="minimum_requirement" placeholder="Minimum Requirements"></textarea>--}}

{{--					</div>--}}

{{--            	</div>--}}

{{--            	<div class="form-row mt-1">--}}
{{--					<div class="col-md-12 mb-5">--}}
{{--						<label>Educational Requirement <span class="text-danger font-weight-bold"> *</span>:</label>--}}
{{--						<textarea class="form-control border-yellow" rows="5" name="educational_requirement" placeholder="Additional Requirements"></textarea>--}}

{{--					</div>--}}

{{--            	</div>--}}

{{--            	<div class="form-row mt-1">--}}
{{--					<div class="col-md-12 mb-5">--}}
{{--						<label>Job Description <span class="text-danger font-weight-bold"> *</span>:</label>--}}
{{--						<textarea class="form-control border-yellow" rows="5" name="description" placeholder="Job Description"></textarea>--}}

{{--					</div>--}}

{{--            	</div>--}}

{{--            	<div class="form-row mt-1">--}}
{{--					<div class="col-md-6 mb-5">--}}
{{--						<label>Vacancy <span class="text-danger font-weight-bold"> *</span>:</label>--}}
{{--						<input type="number"  min="1" class="form-control border-yellow" name="vacancy" required placeholder="Number of vacancies">--}}
{{--					</div>--}}

{{--					<div class="col-md-6 mb-5">--}}
{{--						<label>Age Limit:</label>--}}
{{--						<input type="text" class="form-control border-yellow" name="age_limit" required placeholder="Age Limit (25-35)years">--}}

{{--					</div>--}}

{{--            	</div>--}}

{{--            	<div class="form-row mt-1">--}}
{{--					<div class="col-md-6 mb-5">--}}
{{--						<label>Deadline <span class="text-danger font-weight-bold"> *</span>:</label>--}}
{{--						<input  type="date" class="form-control border-yellow" name="deadline" required placeholder="Deadline of job">--}}
{{--					</div>--}}

{{--					<div class="col-md-6 mb-5">--}}
{{--						<label>Job Type <span class="text-danger font-weight-bold"> *</span>:</label>--}}
{{--						<select class="form-control border-yellow" name="nature" required>--}}
{{--			                <option value="" disabled selected>-- Select Job Type --</option>--}}
{{--			                <option value="1">Parmanent</option>--}}
{{--			                <option value="2">Part-time</option>--}}
{{--			                <option value="3">Contractual</option>--}}
{{--			            </select>--}}

{{--					</div>--}}

{{--            	</div>--}}





{{--              	<button type="button" class="btn background-yellow float-right">Add Job</button>--}}

{{--            </form>--}}




{{--      </div>--}}
{{--        // job container ends here--}}

    </div>
  </div>
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
