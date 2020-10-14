
@extends('master')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

<div class="container-fluid">
	<div class="row" style="min-height: 90vh">
		<div class="col-md-2 pt-5 text-center" style="background-color: #f5b82f;"><!--left col-->


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
					{{ $user_info->class_range == null ? '-' :  $user_info->class_range }}
				</div>

         	</div>

			@if($user_info->id == Auth::id())
			<div class="row text-left p-2 my-3">
				<div class="col-12 mt-3">
					{{$user_info->email}}
				</div>
				<div class="col-8">
					{{$user_info->phone_number}}
				</div>

			</div>

			<h4>Current Balance </h4>
			<p>${{ round($user_info->balance, 2) }}</p>
			<button type="button" class=" btn btn-success btn-sm"style="display: inline-block" >Deposit</button>
			<button type="button" class="  btn btn-danger btn-sm">Withdraw</button>
			@endif


			<!-- <h3 class="mt-3 font-weight-bold text-white">{{$user_info->name}}</h3>

			@if($user_info->id == Auth::id())
			<p class="mt-2">{{$user_info->email}}</p>

			<p class="mt-2" style="display: inline-block">{{$user_info->phone_number}}</p>
			<i class="ml-2 fas fa-pen fa-clickable" ></i>

			<h4>Current Balance </h4>
			<p>${{$user_info->balance}}</p>
			<button type="button" class=" btn btn-success btn-sm"style="display: inline-block" >Deposit</button>
			<button type="button" class="  btn btn-danger btn-sm">Withdraw</button>
			@endif  -->

		</div>


	<div class="col-md-8" style="background-color: #f3f2f0;">

		<div class="container-fluid mt-2">
			<h3>Job Details</h3>
			<div class="row mt-3">
				<div class="col-md-9 card p-3">
                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Job Position:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{{$job_info->job_title}}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Vacancy:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{{$job_info->vacancy}}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Age Limit:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{{$job_info->age_limit}}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Gender Preference:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{{$job_info->gender}}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Salary Range:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{{$job_info->expected_salary_range}}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Type:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">@if($job_info->nature == 1) Permanent @elseif($job_info->nature == 2) Part-Time  @elseif($job_info->nature == 3) Contractual @else - @endif</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Location:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{{$job_info->location}}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Description:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{!! nl2br(e($job_info->description)) !!}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Job Responsibilities:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{!! nl2br(e($job_info->job_responsibilities)) !!}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Educational Requirement:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{!! nl2br(e($job_info->educational_requirement)) !!}</p>
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Experience Requirements:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{!! nl2br(e($job_info->experience_requirements)) !!}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Additional Requirements:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{!! nl2br(e($job_info->additional_requirements)) !!}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label font-weight-bold">Compensation & Other Benefits:</label>
                        <div class="col-sm-9">
                            <p style="margin: 6px 0 0">{!! nl2br(e($job_info->compensation_other_benefits)) !!}</p>
                        </div>
                    </div>

                    @if(isset($job_info->admin_comment))
                        <div class="form-group row mb-0">
                            <label class="col-sm-3 col-form-label font-weight-bold" style="color: #f40c0c;">Admin Comment:</label>
                            <div class="col-sm-9">
                                <p style="margin: 6px 0 0">{!! nl2br(e($job_info->admin_comment)) !!}</p>
                            </div>
                        </div>
                    @endif
				</div>

				<div class="col-md-3 card pt-3">

					<span>
    				Published: {{ date("jS F, Y", strtotime($job_info->created_at)) }}</span>

    				<span class="text-danger">
    				Deadline: {{ date("jS F, Y", strtotime($job_info->deadline)) }}</span>
    				<br>

    				@if($user_info->id == Auth::id())

                        @if($job_info->admin_status != 'Approved')
					    <a href="{{route('job.edit',$job_info->id)}}" class="btn btn-success text-white btn-sm mb-3">Edit</a>
                        @endif
                        @if($job_info->removed == 0)
					    <a href="{{ url('remove_job') }}/{{ $job_info->id }}" class="btn btn-danger btn-sm">Remove</a>
                        @endif
					@endif

				</div>


			</div>
			@if(Auth::user()->identifier == 1)

			<div class="row justify-content-center mt-3">

				<button type="button" value="{{ $job_info->id }}" class="btn btn-success mr-3 applyButton" data-toggle="modal" data-target="#coverLetterModal">Apply</button>
				<button type="button" value="{{ $job_info->id }}" class="btn border-yellow saveButton">Save</button>
			</div>


			@endif



        </div>
        <div class="row">
            <div class=" mt-5 mb-3 col-sm-12">
                <h3 class="font-weight-bold mr-3" style="display: inline-block">Applicants List</h3>
                @if(session()->has('job-status-success'))
                    <div class="alert alert-success">
                        {{ session()->get('job-status-success') }}
                    </div>
                @endif
                <div class="mr=2">
                    <table id="jobTable" class="table table-bordered " style="width:100%">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Applicant Name</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicants as $applicant)
                            <tr>
                                <td>{{$applicant->no}}</td>
                                <td>
                                    <a class="" href="{{ url('t')}}/{{ $applicant->user->username }}">
                                        {{$applicant->user->name}}
                                    </a>
                                </td>
                                <td>
                                    <form class="statusForm" action="{{ route('school.job.status.update', $applicant->id) }}" method="post" style="width: 100%;">
                                        @csrf
                                        <select class="applicantStatus custom-select mr-sm-2" name="admin_status">
                                            <option value="Accepted" {{$applicant->status == 'Accepted' ? 'selected' : ''}}>Accepted</option>
                                            <option value="Rejected" {{$applicant->status == 'Rejected' ? 'selected' : ''}}>Rejected</option>
                                            <option value="Shortlisted" {{$applicant->status == 'Shortlisted' ? 'selected' : ''}}>Shortlisted</option>
                                            <option value="New" {{$applicant->status == 'New' ? 'selected' : ''}}>New</option>
                                        </select>
                                        <button type="submit" style="display: none" class="btn background-yellow float-right">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>





    </div> <!-- 2nd col ends here -->

		@include('leaderboard')


    </div><!-- row ends here -->

</div>


<!-- Modal -->
<div class="modal fade" id="coverLetterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLongTitle">Your Profile will be shared with the school as your CV. Would you like to add a cover letter to increase your chances of being selected ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBody">

  		<div class="form-group">
		  <textarea class="form-control" rows="10" id="coverLetterText" placeholder="Write Cover Letter Here"></textarea>
		</div>
		<button type="button" id="coverLetterSubmitButton" class="btn background-yellow float-right">Submit</button>

      </div>

    </div>
  </div>
</div>

<div class="toast toast-mod" role="alert" id="toast" data-autohide="true" data-animation="true" data-delay="3000">

    <div class="toast-body">
        Job is saved.
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
</div>






@push('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $( ".applicantStatus" ).change(function() {
            Swal.fire({
                icon: 'warning',
                text: 'Are you sure to change status?',
                confirmButtonColor: '#f5b82f',
                confirmButtonText: "Yes",
                showCancelButton: true,
                cancelButtonText:'Cancel',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parents('form:first').find('[type="submit"]').trigger('click');
                }
            })
        });
        $('#jobTable').DataTable();

		$('#pro_pic_choose').on('click', function () {
		  $("#profile_picture").click();
		});
		$("#profile_picture").change(function () {
			$("#pro_pic_upload_form").submit();
		});


      	$(document).ready(function(){
			$('.applyButton').on('click', function () {
	    		verify_applied_job($(this).val());
	    		$('#modalBody').attr('job_id', $(this).val());
			});

			$('.saveButton').on('click', function () {
	    		save_job($(this).val());
			});

			$('#modalBody').on('click', '#coverLetterSubmitButton', function () {
	    		submit_cover_letter($('#modalBody').attr('job_id'), $('#coverLetterText').val());
			});

		});

		function verify_applied_job(job_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              jQuery.ajax({
                url: "{{ url('/verify_applied_job') }}",
                method: 'POST',
                data: {
                   job_id: job_id,
                },
                success: function(result){
                	if(result == 'success'){
                		jQuery('#modalLongTitle').text('Error');
                		jQuery('#modalBody').html('<h3 class="text-center text-danger">Already Applied for this Job</h3>');
                	}else{
                		jQuery('#modalLongTitle').text('Your Profile will be shared with the school as your CV. Would you like to add a cover letter to increase your chances of being selected ?');
                		jQuery('#modalBody').html('<div class="form-group"><textarea class="form-control" rows="10" id="comment" placeholder="Write Cover Letter Here"></textarea></div><button type="button" id="coverLetterSubmitButton" class="btn background-yellow float-right">Submit</button>');
                	}

                }
            });
        }

        function submit_cover_letter(job_id, cover_letter){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
          	jQuery.ajax({
                url: "{{ url('/submit_cover_letter') }}",
                method: 'POST',
                data: {
                   job_id: job_id,
                   cover_letter: cover_letter,
            	},
	            success: function(result){
	            	if(result == 'success'){
	            		jQuery('#modalLongTitle').text('Done!');
	            		jQuery('#modalBody').html('<h3 class="text-center text-success">Job Application Submitted Successfully</h3>');
	            		setTimeout(function(){
						 	$('#coverLetterModal').modal('hide');
						}, 3000);

						setTimeout(function(){
						  	jQuery('#modalLongTitle').text('Cover Letter');
	            			jQuery('#modalBody').html('<div class="form-group"><textarea class="form-control" rows="5" id="comment"></textarea></div><button type="button" id="coverLetterSubmitButton" class="btn background-yellow float-right">Submit</button>');
						}, 3500);
	            	}

	            }

        	});
          }

          function save_job(job_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              jQuery.ajax({
                url: "{{ url('/save_job') }}",
                method: 'POST',
                data: {
                   job_id: job_id,
                },
                success: function(result){
                	if(result == 'success'){
                		$('.toast').toast('show');
                	}

                }
            });
          }
    </script>

@endpush

@endsection
