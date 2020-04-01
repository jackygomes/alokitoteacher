
@extends('master')
@section('content')

<div class="container-fluid">
	<div class="row" style="min-height: 90vh">
		<div class="col-md-2 py-5 text-center" style="background-color: #f5b82f;"><!--left col-->

			<a href="{{ url('job_applications') }}/{{ request()->route('id') }}/all" class="btn bg-white form-control mt-3 {{ request()->route('type') == 'all' ? 'job-button-active' : '' }}">All Applications</a>
			<a href="{{ url('job_applications') }}/{{ request()->route('id') }}/shortlisted" class="btn bg-white form-control mt-3 {{ request()->route('type') == 'shortlisted' ? 'job-button-active' : '' }}">Shortlisted</a>


		</div>


		<div class="col-md-8 py-3">
	 		<h3 class="my-3">Job Applications 
 			@if($job_applications->count() != 0)
				<small class="text-muted">({{$job_applications[0]->job_title}})</small>
			@endif
	 		</h3>
	      	<div class="container-fluid mt-5">

	      		@if(session()->has('success'))
				    <div class="alert alert-success">
				        {{ session()->get('success') }}
				    </div>
				@endif

	      		@if($job_applications->count() == 0)
	      		<h5 class="text-center text-muted">No Job Applications to Show!</h5>
				@endif
				
				@foreach ($job_applications as $job_application)
				<div class="card text-center p-3">
					<div class="row">
						
						<div class="col-md-3 my-auto">
							@if($job_application->image == null)
					          <i class="fas fa-user-circle fa-7x text-yellow"></i>
					        @else
					          <img class="img-fluid rounded-circle" style="height: 100px; width: 100px" src="{{ url('images/profile_picture') }}/{{ $job_application->image }}">
					        @endif
						</div>
						<div class="col-md-6">
							<h3>Name: {{ $job_application->name }}</h3>
							<button type="button" value="{{ $job_application->id }}" class="btn btn-success coverLetterButton" data-toggle="modal" data-target="#coverLetterModal">View Cover Letter</button>

							<a target="_blank" href="{{ url('t') }}/{{ $job_application->username }}" class="btn text-white background-yellow">View Profile</a>
							<a target="_blank" href="{{ url('job_detail') }}/{{ $job_application->job_id }}" class="btn btn-primary">View Job Details</a>
							
						</div>
						<div class="col-md-3">
							@if(request()->route('type') != 'shortlisted')
							<a href="{{ url('shortlisted') }}/{{ $job_application->id }}" class="btn btn-success btn-sm {{ $job_application->shortlisted == 1 ? 'disabled' : '' }}"><i class="fas fa-check-circle"></i> Shortlisted</a>
							@endif

							@if(request()->route('type') == 'shortlisted')
							<a href="{{ url('confirm_interview') }}/{{ $job_application->id }}" class="btn btn-success btn-sm"><i class="fas fa-envelope"></i> Send Confirmation Email</a>
							@endif
							
						</div>
						
					</div>
				</div>
				
				@endforeach

				{{ $job_applications->links() }}
					
			</div>
		</div>	


		@include('leaderboard')


    </div><!-- row ends here -->

</div>

<!-- Modal -->
<div class="modal fade" id="coverLetterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLongTitle">Cover Letter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBody">

		  	

      </div>
    
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addJobModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="modalLongTitle">Add New Job</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		</div>

      	<div class="modal-body" id="modalBody">

      		<form action="{{ route('add_job') }}" method="POST" class="mb-5">
                
              
                <div class="form-row mb-4">
                  <div class="col-md-12">
                  	<label>Job Title <span class="text-danger font-weight-bold"> *</span>:</label>
                     <input id="title" type="text" class="form-control border-yellow" name="job_title" required placeholder="Job Title">
                  </div>
                  
                </div>
            
          	
            	<div class="form-row mt-1">
					<div class="col-md-12 mb-5">
						<label>Location <span class="text-danger font-weight-bold"> *</span>:</label>
						<input id="location" type="text" class="form-control border-yellow" name="location" required placeholder="Job Location">

					</div>
              
            	</div>

            	<div class="form-row mt-1">
					<div class="col-md-12 mb-5">
						<label>Salary Range:</label>
						<input id="salary" type="text" class="form-control border-yellow" name="expected_salary_range" required placeholder="Salary Range (10,000 - 15,000/ Negotiable)">

					</div>
              
            	</div>

            	<div class="form-row mt-1">
					<div class="col-md-12 mb-5">
						<label>Minimum Requirements <span class="text-danger font-weight-bold"> *</span>:</label>
						<textarea class="form-control border-yellow" rows="5" name="minimum_requirement" placeholder="Minimum Requirements"></textarea>

					</div>
              
            	</div>

            	<div class="form-row mt-1">
					<div class="col-md-12 mb-5">
						<label>Educational Requirement <span class="text-danger font-weight-bold"> *</span>:</label>
						<textarea class="form-control border-yellow" rows="5" name="educational_requirement" placeholder="Additional Requirements"></textarea>

					</div>
              
            	</div>

            	<div class="form-row mt-1">
					<div class="col-md-12 mb-5">
						<label>Job Description <span class="text-danger font-weight-bold"> *</span>:</label>
						<textarea class="form-control border-yellow" rows="5" name="description" placeholder="Job Description"></textarea>

					</div>
              
            	</div>

            	<div class="form-row mt-1">
					<div class="col-md-6 mb-5">
						<label>Vacancy <span class="text-danger font-weight-bold"> *</span>:</label>
						<input type="number"  min="1" class="form-control border-yellow" name="vacancy" required placeholder="Number of vacancies">
					</div>

					<div class="col-md-6 mb-5">
						<label>Age Limit:</label>
						<input type="text" class="form-control border-yellow" name="age_limit" required placeholder="Age Limit (25-35)years">

					</div>
              
            	</div>
            	
            	<div class="form-row mt-1">
					<div class="col-md-6 mb-5">
						<label>Deadline <span class="text-danger font-weight-bold"> *</span>:</label>
						<input  type="date" class="form-control border-yellow" name="deadline" required placeholder="Deadline of job">
					</div>

					<div class="col-md-6 mb-5">
						<label>Job Type <span class="text-danger font-weight-bold"> *</span>:</label>
						<select class="form-control border-yellow" name="nature" required>
			                <option value="" disabled selected>-- Select Job Type --</option>
			                <option value="1">Parmanent</option>
			                <option value="2">Part-time</option>
			                <option value="3">Contractual</option>
			            </select>

					</div>
              
            	</div>


              
				

              	<button type="button" class="btn background-yellow float-right">Add Job</button>  	

            </form>

  		
		

      </div>
    
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

		$(document).ready(function(){
			$('.coverLetterButton').on('click', function () {
	    		show_offer_letter($(this).val());
			});
		});

		function show_offer_letter(application_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              jQuery.ajax({
                url: "{{ url('/show_offer_letter') }}",
                method: 'POST',
                data: {
                   application_id: application_id,
                },
                success: function(result){
                	
                		
                	jQuery('#modalBody').html(result);	
                	
                    
                }
            });
        }


      	
    </script>

@endpush
  
@endsection