
@extends('master')
@section('content')

<div class="container-fluid">
	<div class="row" style="min-height: 90vh">
		<div class="col-md-2 py-5 text-center" style="background-color: #f5b82f;"><!--left col-->


			<button data-toggle="modal" data-target="#addJobModal" class="btn bg-white form-control mt-3 {{ request()->route('type') == 'all' ? 'job-button-active' : '' }}"><i class="fas fa-plus-circle text-success"></i> Post New Job</button>


		</div>


		<div class="col-md-8 py-3" style="background-color: #f3f2f0;">
	 		<h3>Posted Jobs</h3>
	      	<div class="container-fluid mt-3">

	      		@if(session()->has('success'))
				    <div class="alert alert-success">
				        {{ session()->get('success') }}
				    </div>
				@endif

				@if(session()->has('danger'))
				    <div class="alert alert-danger">
				        {{ session()->get('danger') }}
				    </div>
				@endif


				@if($posted_jobs->count() == 0)
				<h5 class="text-center text-muted">No Posted Job to Show!</h5>
				@endif

				@foreach ($posted_jobs as $job)
				<div class="row mb-2 p-3 btn-light">
					<a href="{{ url('job_applications') }}/{{ $job->id }}/all" class="col-md-8" style="border-right: 1px solid #dfdfdf">
						<p class="h5 text-dark">{{ $job->job_title }}</p>
						<small class="text-danger">Deadline: {{ date("jS F, Y", strtotime($job->deadline)) }}</small>
					</a>
					<div class="col-md-4 text-center text-white my-auto">
						<a class="btn btn-success btn-sm">Edit</a>
						<a href="{{ url('remove_job') }}/{{ $job->id }}" class="btn btn-danger btn-sm">Remove</a>
					</div>
				</div>


				@endforeach

				{{ $posted_jobs->links() }}

			</div>
		</div>

{{--		@include('leaderboard')--}}


    </div><!-- row ends here -->

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


    </script>

@endpush

@endsection
