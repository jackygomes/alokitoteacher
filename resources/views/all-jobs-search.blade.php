<table class="table">
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
		        	<td class="">
		        		<div class="bg-white job-card text-light-dark">
		        			<div class="row">
		        				<div class="col-md-2 text-center">
		        					@if($v_job_info->image == null)
						          		<i class="fas fa-user-circle fa-5x text-yellow"></i>
							        @else
							        <div class="mx-auto" style="width: 138px; height: 138px;">
							          <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $v_job_info->image }}">
							        </div>
							        @endif
				        		</div>


			        			<div class="col-md-7">
                                    <span class="font-weight-bold text-dark">{{ $v_job_info->job_title }}</span><br>

                                    <span class="text-yellow">{{ $v_job_info->name }}</span><br>

                                    <span class="label-image"><img class="img-fluid" src="{{asset('images/new_design/salary.png')}}"></span><span class="text-dark"> {{ $v_job_info->expected_salary_range }}</span><br>

                                    {{--												<span class="font-weight-bold">Type:</span><span></span><br>--}}

                                    {{--												<span class="font-weight-bold">Vacancy:</span><span> </span><br>--}}

                                    <p class="ma-0 description">{{ str_limit(strip_tags($v_job_info->description), 150) }}</p>



			        			</div>

                                <div class="col-md-3 text-right">
                                    <div class="job-card-right">
                                        <small>
                                            @php
                                                $date = \Carbon\Carbon::parse($v_job_info->created_at);

                                                $now = \Carbon\Carbon::now();

                                                $diff = $date->diffInDays($now);
                                            @endphp
                                            Posted {{$diff}} days ago</small>
                                        <br>
                                        <p class="ma-0 text-dark">Deadline: {{ date("jS M, Y", strtotime($v_job_info->deadline)) }}</p>


                                        <div class="button-section">
                                            <div class="share-button">
                                                <div><img src="{{asset('images/new_design/main-share.png')}}"> Share</div>
                                                <div class="share-options">
                                                    <div class="fb-share-button" 
                                                    data-href="{{ url('job_detail') }}/{{ $v_job_info->job_id }}" 
                                                    data-layout="button">
                                                    </div>
                                                    <script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
                                                    <script type="IN/Share" data-url="{{ url('job_detail') }}/{{ $v_job_info->job_id }}"></script>
                                                </div>
                                            </div>
                                        @if(Auth::check())
                                            @if(Auth::user()->identifier != 101 && Auth::user()->identifier != 2 && Auth::user()->identifier != 104)
                                                @if($v_job_info->isApplied == 0)
                                                    <button type="button" value="{{ $v_job_info->job_id }}" class="btn btn-success applyButton" onclick="passJobIdToForm({{$v_job_info->job_id}})" data-toggle="modal" data-target="#coverLetterModal">Apply</button>
                                                @else
                                                    <button type="button" value="{{ $v_job_info->job_id }}" class="btn btn-success applyButton" disabled>Applied</button>
                                                @endif
                                            @endif
                                        @endif
                                        
                                            <a href="{{ url('job_detail') }}/{{ $v_job_info->job_id }}" class="btn background-yellow text-white">View Job</a>
                                        </div>
                                    </div>
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
                            <div class="col-md-12 text-center py-4">
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
