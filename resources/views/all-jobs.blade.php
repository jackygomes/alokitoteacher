@extends('master')
@section('content')


<div class="container-fluid all-job" style="min-height: 100vh">
	<div class="row">
		<div class="col-md-2 sidebar-job-all px-4" style="background-color: #532436;">

			<a href="{{ url('jobs/all') }}" class="btn background-yellow text-white home-explore-button btn-block mt-5 {{ request()->route('type') == 'all' ? 'job-button-active' : '' }}">View All Jobs</a>
{{--			<a href="{{ url('jobs/saved') }}" class="btn bg-white form-control mt-3 {{ request()->route('type') == 'saved' ? 'job-button-active' : '' }}">Saved Jobs</a>--}}



			<h3 class="font-weight-bold mt-5 text-white">Filter</h3>
			<hr>
			<select class="form-control mt-5" id="location" required>
				<option value="" disabled="" selected="">Select Location</option>
				<option value="">All Location</option>
				@foreach($locations as $location)
				<option value="{{ $location->location }}">{{ $location->location }}</option>
				@endforeach
			</select>
			<br>
			<select class="form-control mb-3" id="school" required>
				<option value="" disabled="" selected="">Select School</option>
				<option value="">All School</option>
				@foreach($schools as $school)
				<option value="{{ $school->id }}">{{ $school->name }}</option>
				@endforeach
			</select>

		</div>

		<div class="col-md-10" style="background-color: #f3f2f0;">

			<div class=" mt-3 mx-5 px-5">
				@if(session()->has('success'))
		            <div class="alert alert-success">
		                {{ session()->get('success') }}
		            </div>
		        @endif
				<div class="row">
					<div class="col-12 col-md-12">
                        <div class="search-wrapper">
                            <input class="form-control" id="search" type="text" placeholder="Search For Job..">
                            <img id="searchButton" class="background-yellow" src="{{asset('images/new_design/job-search-button.png')}}" alt="">
                        </div>
					</div>
				</div>
			  	<br>
				@if($featuredJobs->count() > 0)
				<div class="featured-job">
					<table class="table" >
						<thead>
						<tr>
							<th colspan="2" class="font-weight-bold">
								<span>Featured Jobs:</span>
							</th>

						</tr>
						</thead>
						<tbody>
						@php $count = 0 @endphp
						@foreach ($featuredJobs as $featuredJob)
							@php $count++ @endphp
							@if( $count % 2 != 0 )
							<tr>
							@endif
								<td id="job_{{ $featuredJob->job_id }}" class="">
									<div class="bg-white feature-job-card border-yellow text-light-dark">
										<div class="row">
											<div class="col-md-2 text-center">
												@if($featuredJob->image == null)
													<i class="fas fa-user-circle fa-5x text-yellow"></i>
												@else
													<div class="mx-auto" style="width: 138px; height: 138px;">
														<img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $featuredJob->image }}">
													</div>
												@endif
											</div>


											<div class="col-md-7">
												<span class="font-weight-bold text-dark">{{ $featuredJob->job_title }}</span><br>

                                                <span class="text-yellow">{{ $featuredJob->name }}</span><br>

												<span class="label-image"><img class="img-fluid" src="{{asset('images/new_design/salary.png')}}"></span><span class="text-dark"> {{ $featuredJob->expected_salary_range }}</span><br>

{{--												<span class="font-weight-bold">Type:</span><span>@if($featuredJob->nature == 1) Permanent @elseif($featuredJob->nature == 2) Part-Time  @elseif($featuredJob->nature == 3) Contractual @else - @endif</span><br>--}}

{{--												<span class="font-weight-bold">Vacancy:</span><span> {{ $featuredJob->vacancy }}</span><br>--}}

                                                <p class="ma-0 description">{{ str_limit(strip_tags($featuredJob->description), 150) }}</p>


											</div>

											<div class="col-md-3 text-right">
												<div class="job-card-right">
                                                    <small>
                                                        @php
                                                            $date = \Carbon\Carbon::parse($featuredJob->created_at);

                                                            $now = \Carbon\Carbon::now();

                                                            $diff = $date->diffInDays($now);
                                                        @endphp
                                                        Posted {{$diff}} days ago</small>
                                                    <br>
                                                    <p class="ma-0 text-dark">Deadline: {{ date("jS M, Y", strtotime($featuredJob->deadline)) }}</p>

                                                    @if(Auth::check())
                                                        @if(Auth::user()->identifier != 101 && Auth::user()->identifier != 2 && Auth::user()->identifier != 104)
                                                            @if($featuredJob->isApplied == 0)
                                                                <button type="button" value="{{ $featuredJob->job_id }}" class="btn btn-success applyButton" onclick="passJobIdToForm({{$featuredJob->job_id}})" data-toggle="modal" data-target="#coverLetterModal">Apply</button>
                                                            @else
                                                                <button type="button" value="{{ $featuredJob->job_id }}" class="btn btn-success applyButton" disabled>Applied</button>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    <div class="button-section">
                                                        <a href="{{ url('job_detail') }}/{{ $featuredJob->job_id }}" class="btn background-yellow text-white">View Job</a>
                                                    </div>
                                                </div>
											</div>
										</div>
									</div>
								</td>
							{{--@if( $count % 2 == 0 )--}}
								{{--</tr>--}}
							{{--@endif--}}
						@endforeach
						</tbody>
					</table>
				</div>
				@endif
				<br>

			  	<div id="table">
					<table class="table">
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
							 {{--search results showing--}}
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
