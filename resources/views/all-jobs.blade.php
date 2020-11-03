@extends('master')
@section('content')


<div class="container-fluid" style="min-height: 100vh">
	<div class="row">
		<div class="col-md-2 sidebar-job-all" style="background-color: #f5b82f;">

			<a href="{{ url('jobs/all') }}" class="btn bg-white form-control mt-5 {{ request()->route('type') == 'all' ? 'job-button-active' : '' }}">All Jobs</a>
{{--			<a href="{{ url('jobs/saved') }}" class="btn bg-white form-control mt-3 {{ request()->route('type') == 'saved' ? 'job-button-active' : '' }}">Saved Jobs</a>--}}



			<h3 class="font-weight-bold mt-5 text-white">Filter</h3>
			<hr>
			<select class="form-control border-yellow" id="location" required>
				<option value="" disabled="" selected="">-- Location --</option>
				@foreach($locations as $location)
				<option value="{{ $location->location }}">{{ $location->location }}</option>
				@endforeach
			</select>
			<br>
			<select class="form-control border-yellow mb-3" id="school" required>
				<option value="" disabled="" selected="">-- School --</option>
				@foreach($schools as $school)
				<option value="{{ $school->id }}">{{ $school->name }}</option>
				@endforeach
			</select>

		</div>

		<div class="col-md-8" style="background-color: #f3f2f0;">

			<div class="container mt-3">
				@if(session()->has('success'))
		            <div class="alert alert-success">
		                {{ session()->get('success') }}
		            </div>
		        @endif
				<div class="row">
					<div class="col-8 col-md-10">
					  <input class="form-control" id="search" type="text" placeholder="Search For Job..">
					</div>

					<div class="col-4 col-md-2">
					  <button id="searchButton" class="btn background-yellow mb-2 float-right w-100">Search</button>
					</div>
				</div>
			  	<br>

			  	<div id="table">
					<table class="table table-bordered">
					    <thead>
					      <tr>
					        <th class="font-weight-bold">
					        	<span>Search Result:</span>
{{--					        	<a class="ml-5 text-yellow" href=" ">Recent</a>--}}
{{--					        	<a class="ml-5" href="#">Popular</a>--}}
{{--					        	<a href="#" class="text-dark ml-5">Salary</a>--}}
					        </th>

					      </tr>
					    </thead>
					    	<tbody id="myTable">
					    		@foreach ($job_info as $v_job_info)
							      	<tr id="job_{{ $v_job_info->job_id }}">
							        	<td class="bg-white">
							        		<div class="container-fluid">
							        			<div class="row">
							        				<div class="col-md-2 text-center">
							        					@if($v_job_info->image == null)
											          		<i class="fas fa-user-circle fa-5x text-yellow"></i>
												        @else
												        <div class="mx-auto" style="width: 70px; height: 70px;">
												          <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $v_job_info->image }}">
												        </div>
												        @endif

												        <h4 class="font-weight-bold mt-3"><a class="text-yellow" href="{{ url('s') }}/{{ $v_job_info->username }}"> {{ $v_job_info->name }}</a></h4>
									        		</div>


								        			<div class="col-md-7">
								        				<span class="font-weight-bold">Job Positon: {{ $v_job_info->job_title }}</span><br>

										        		<span class="font-weight-bold">Salary Range:</span><span> {{ $v_job_info->expected_salary_range }}</span><br>

										        		<span class="font-weight-bold">Type:</span><span>@if($v_job_info->nature == 1) Permanent @elseif($v_job_info->nature == 2) Part-Time  @elseif($v_job_info->nature == 3) Contractual @else - @endif</span><br>

										        		<span class="font-weight-bold">Vacancy:</span><span> {{ $v_job_info->vacancy }}</span><br>

										        		<span class="font-weight-bold" >Description:</span>

										        		{{ str_limit(strip_tags($v_job_info->description), 150) }}

{{--											              <a href="{{ url('job_detail') }}/{{ $v_job_info->job_id }}" class="text-yellow">Read More</a>--}}


								        			</div>

								        			<div class="col-md-3">
								        				<small>
								        				Published: {{ date("jS F, Y", strtotime($v_job_info->created_at)) }}</small>
								        				<br>
								        				<small class="text-danger">
								        				Deadline: {{ date("jS F, Y", strtotime($v_job_info->deadline)) }}</small>
								        				<br>

								        				<button type="button" value="{{ $v_job_info->job_id }}" class="btn btn-success applyButton" data-toggle="modal" data-target="#coverLetterModal">Apply</button>
{{--								        				@if(request()->route('type') == 'all')--}}
{{--								        				<button type="button" value="{{ $v_job_info->job_id }}" class="btn border-yellow saveButton">Save</button>--}}
{{--								        				@else--}}
{{--								        				<button type="button" value="{{ $v_job_info->job_id }}" class="btn btn-danger removeButton">Remove</button>--}}
                                                        <a href="{{ url('job_detail') }}/{{ $v_job_info->job_id }}" class="btn background-yellow  text-white">View</a>
{{--								        				@endif--}}
								        			</div>
							        			</div>
							        		</div>
							        	 </td>
							      	</tr>
						    	@endforeach
						    </tbody>
				    </table>

			  		<div class="mt-5">
			           {{ $job_info->links() }}
			        </div>
			    </div>
			</div>
		</div>

{{--		@include('leaderboard')--}}
	</div>
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

      	<form method="POST" id="coverLetterForm" action="{{ url('submit_cover_letter') }}">
      		 {{csrf_field()}}
      		<div class="form-group">
			  <textarea class="form-control" rows="10" id="coverLetterText" name="cover_letter" placeholder="Write Cover Letter Here"></textarea>
			</div>
			<input type="hidden" name="job_id" id="form_job_id">
			<button type="submit" id="coverLetterSubmitButton" class="btn background-yellow float-right">Submit</button>

      	</form>



      </div>

    </div>
  </div>
</div>

<div class="toast toast-success" role="alert" id="toastSuccess" data-autohide="true" data-animation="true" data-delay="3000">

    <div class="toast-body">
        Job is saved.
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toastSuccess" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
</div>

<div class="toast toast-danger" role="alert" id="toastDanger" data-autohide="true" data-animation="true" data-delay="3000">

    <div class="toast-body">
        Job is removed.
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toastDanger" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
</div>



 @push('js')

    <script type="text/javascript">

		$(document).ready(function(){
			$('.applyButton').on('click', function () {
	    		verify_applied_job($(this).val());
			});

			$('.saveButton').on('click', function () {
	    		save_job($(this).val());
			});

			$('.removeButton').on('click', function () {
	    		remove_saved_job($(this).val());
			});


		});

        function passJobIdToForm(id){
            $('#form_job_id').val(id);
        }

		$('#searchButton').on('click', function () {
			search_filter($('#search').val(), $('#location').val(), $('#school').val());
		});
		$('#location').on('change', function (e) {
			search_filter($('#searchButton').val(), this.value, $('#school').val());
		});
		$('#school').on('change', function (e) {
			search_filter($('#searchButton').val(), $('#location').val(), this.value);
		});

		$(document).on('click','#ajaxPagination a',function(e){
            e.preventDefault();
            pagination($(this).attr('href'));
            return false;
        });

        function pagination(url){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              jQuery.ajax({
                url: url,
                success: function(result){
                    jQuery('#table').html(result);
                }
            });
        }

        let x='',y='',z='';
        search_filter(x, y, z);
        function search_filter(search, location, school){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              jQuery.ajax({
                url: "{{ url('/search_filter_jobs') }}",
                method: 'get',
                data: {
                   search: search,
                   location : location,
                   school : school,
                },
                success: function(result){
                    jQuery('#table').empty().html(result);
                }
            });
        }

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
                		jQuery('#modalBody').html('<form method="POST" action="{{ url('submit_cover_letter') }}">{{csrf_field()}}<div class="form-group"><textarea class="form-control" rows="10" id="coverLetterText" name="cover_letter" placeholder="Write Cover Letter Here"></textarea></div><input type="hidden" name="job_id" value="'+job_id+'"><button type="submit" id="coverLetterSubmitButton" class="btn background-yellow float-right">Submit</button></form>');
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
                		$('#toastSuccess').toast('show');
                	}

                }
            });
          }

          function remove_saved_job(job_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              jQuery.ajax({
                url: "{{ url('/remove_saved_job') }}",
                method: 'POST',
                data: {
                   job_id: job_id,
                },
                success: function(result){
                	if(result == 'success'){
                		$('#job_'+job_id).remove();
                		$('#toastDanger').toast('show');
                	}

                }
            });
          }


    </script>

@endpush


@endsection
