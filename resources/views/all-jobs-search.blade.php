<table class="table table-bordered">
    <thead>
      <tr>
        <th class="font-weight-bold">
        	<span>Search Result:</span>
{{--        	<a class="ml-5" href="#">Recent</a>--}}
{{--        	<a class="ml-5" href="#">Popular</a>--}}
        	<!-- <a href="#" class="text-dark ml-5">Salary</a>  -->
        </th>

      </tr>
    </thead>
    	<tbody id="myTable">
    		@foreach ($job_info as $v_job_info)
		      	<tr>
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



			        			</div>

			        			<div class="col-md-3 text-right">
			        				<small>
			        				Published: {{ date("jS F, Y", strtotime($v_job_info->created_at)) }}</small>
			        				<br>
			        				<small class="text-danger">
			        				Deadline: {{ date("jS F, Y", strtotime($v_job_info->deadline)) }}</small>
			        				<br>

									@if(Auth::check())
										@if(Auth::user()->identifier != 101 & Auth::user()->identifier != 2)
											@if($v_job_info->isApplied == 0)
											<button type="button" value="{{ $v_job_info->job_id }}" class="btn btn-success applyButton" onclick="passJobIdToForm({{$v_job_info->job_id}})" data-toggle="modal" data-target="#coverLetterModal">Apply</button>
											@else
											<button type="button" value="{{ $v_job_info->job_id }}" class="btn btn-success applyButton" disabled>Applied</button>
											@endif
										@endif
									@endif
{{--			        				<button type="button" value="{{ $v_job_info->job_id }}" class="btn border-yellow saveButton">Save</button>--}}
{{--                                    <a href="{{ url('job_detail') }}/{{ $v_job_info->job_id }}" class="btn btn-success text-white btn-sm">View</a>--}}
                                    <a href="{{ url('job_detail') }}/{{ $v_job_info->job_id }}" class="btn background-yellow  text-white">View</a>
			        			</div>
		        			</div>
		        		</div>
		        	 </td>
		      	</tr>
	    	@endforeach
            @if($job_info->count() < 1)
            <tr>
                <td class="bg-white">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                No Job To Show
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endif
	    </tbody>
</table>

<div id="ajaxPagination" style="padding: 10px;">
   {{ $job_info->links() }}
</div>
