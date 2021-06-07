@extends('master')
@section('content')
<style>
    .custom-control-input:checked~.custom-control-label::before {
        color: #f5b82f !important;
        background-color: #f5b82f !important;
        border-color: #f5b82f !important;
    }
</style>

<div class="container-fluid">

    <div class="row">
        @include('includes.dashboard.school')

        <div class="col-md-9 col-sm-12 mt-2">
            <div class="container-fluid ">
                <div class="row">
                    @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{$message}}
                    </div>
                    @endif
                    <div class=" mt-5 mb-3 col-sm-12">
                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Toolkits</h3>
                        <a href="{{route('toolkit.create')}}"><span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen"></i> <small>Add</small></span></a>
                        <div class="mr=2">
                            <div class="table-responsive-sm">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">No.</th>
                                            <th style="width:10%">Subject</th>
                                            <th style="width:20%">Toolkit Name</th>
                                            <th style="width:10%">Price</th>
                                            <th style="width:20%">Educators Enrolled</th>
                                            <th style="width:10%">Status</th>
                                            <th style="width:20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n = 1 ?>
                                        @foreach ($toolkits as $toolkit)
                                        <tr>
                                            <td>{{$n}}</td>
                                            <td>{{$toolkit->subject->subject_name}}</td>
                                            <td>{{$toolkit->toolkit_title}}</td>
                                            <td>{{($toolkit->price == 0) ? 'Free' : $toolkit->price}}</td>
                                            <td>{{$toolkit->people_taken}}</td>
                                            <td>{{$toolkit->status}}</td>
                                            <td>
                                                <form id="toolkitDeleteForm_{{$toolkit->id}}" action="{{ route('toolkit.delete', ['id' => $toolkit->id]) }}" method="post">
                                                    <a href="{{route('toolkit.edit',$toolkit->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
                                                    <input class="btn btn-danger btn-sm" onclick="toolkitDeleteConfirm({{$toolkit->id}})" type="button" value="Remove" />
                                                    <input class="btn btn-danger btn-sm" style="display: none" type="submit" value="Remove" />
                                                    @method('delete')
                                                    @csrf
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $n++ ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($toolkits->count() > 5)
                                {{$toolkits->links()}}
                                @endif

                                @if($toolkits->count() == 0)
                                <h5 class="text-center text-muted">No Toolkit to Show</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class=" mt-5 mb-3 col-sm-12">
                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Resource</h3>
                        <a href="{{route('resource.create')}}"><span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen"></i> <small>Add</small></span></a>
                        <div class="mr=2">
                            <div class="table-responsive-sm">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">No.</th>
                                            <th style="width:30%">Toolkit Name</th>
                                            <th style="width:10%">Price</th>
                                            <th style="width:10%">Status</th>
                                            <th style="width:20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n = 1 ?>
                                        @foreach ($resources as $resource)
                                        <tr>
                                            <td>{{$n}}</td>
                                            <td>{{$resource->resource_title}}</td>
                                            <td>{{($resource->price == 0) ? 'Free' : $resource->price}}</td>
                                            <td>{{$resource->status}}</td>
                                            <td>
                                                <form id="resourceDeleteForm_{{$resource->id}}" action="{{ route('resource.delete', ['id' => $resource->id]) }}" method="post">
                                                    <a href="{{route('resource.edit',$resource->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
                                                    <input class="btn btn-danger btn-sm" onclick="resourceDeleteConfirm({{$resource->id}})" type="button" value="Remove" />
                                                    <input class="btn btn-danger btn-sm" style="display: none" type="submit" value="Remove" />
                                                    @method('delete')
                                                    @csrf
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $n++ ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$resources->links()}}
                                @if($resources->count() == 0)
                                <h5 class="text-center text-muted">No Resource to Show</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container-fluid mt-5">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="mt-2 font-weight-bold" style="display: inline-block">Jobs</h4>
                        @if($user_info->id == Auth::id())
                        <span class="ml-4 fa-clickable" data-toggle="modal" data-target="#addJobModal"><i class="fas fa-plus-circle text-success"></i> Post New Job</span>
                        @endif

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



                        <table class="table">
                            <tbody>


                                @foreach ($job_info as $job)

                                <tr>
                                    <td class="bg-white">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-2  my-auto text-center">
                                                    @if($user_info->image == null)
                                                    <i class="fas fa-user-circle fa-5x text-yellow"></i>
                                                    @else
                                                    <div class="mx-auto" style="width: 70px; height: 70px;">
                                                        <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $user_info->image }}">
                                                    </div>
                                                    @endif

                                                </div>


                                                <div class="col-md-7">
                                                    <span class="font-weight-bold">Job Positon: {{ $job->job_title }}</span><br>

                                                    <span class="font-weight-bold">Status: {{ $job->admin_status }}</span><br>

                                                    <span class="font-weight-bold">Type:</span><span>@if($job->nature == 1) Permanent @elseif($job->nature == 2) Part-Time @elseif($job->nature == 3) Contractual @else - @endif</span><br>

                                                    <span class="font-weight-bold">Vacancy:</span><span> {{ $job->vacancy }}</span><br>

                                                    <span class="font-weight-bold">Description:</span>

                                                    {{ str_limit(strip_tags($job->description), 150) }}

                                                    {{-- <a href="{{ url('job_detail') }}/{{ $job->id }}" style="display:block" class="text-yellow">Read More</a>--}}


                                                </div>

                                                <div class="col-md-3">
                                                    <small>
                                                        Published: {{ date("jS F, Y", strtotime($job->created_at)) }}</small>
                                                    <br>
                                                    <small class="text-danger">
                                                        Deadline: {{ date("jS F, Y", strtotime($job->deadline)) }}</small>
                                                    <br>

                                                    @if($user_info->id == Auth::id())
                                                    <a href="{{ url('job_detail') }}/{{ $job->id }}" class="btn btn-success text-white btn-sm">View</a>
                                                    @if($job->removed == 0)
                                                    <a href="{{ url('remove_job') }}/{{ $job->id }}" class="btn btn-danger btn-sm">Remove</a>
                                                    @endif
                                                    @else
                                                    <button type="button" value="{{ $job->job_id }}" class="btn btn-success applyButton" data-toggle="modal" data-target="#coverLetterModal">Apply</button>
                                                    <button type="button" value="{{ $job->job_id }}" class="btn border-yellow saveButton">Save</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>


                                <!-- 	<tr>

								<td class="w-25 text-center">
									@if($user_info->image == null)
                                    <i class="fas fa-user-circle fa-7x text-yellow"></i>
@else
                                    <img class="img-fluid rounded-circle" style="height: 150px; width: 150px" src="{{ url('images/profile_picture') }}/{{ $user_info->image }}">
							        @endif
                                    <p class="mt-3">{{$user_info->name}}</p>
								</td>

								<td class="w-55">
									<p><span class="font-weight-bold">Job Position:</span> {{$job->job_title}}</p>
									<p><span class="font-weight-bold">Salary Range:</span> {{$job->expected_salary_range}}</p>
									<p><span class="font-weight-bold">Job Description:</span> {{ str_limit(strip_tags($job->description), 150) }}

                                    <a href="{{ url('job_detail') }}/{{ $job->id }}" class="text-yellow">Read More</a>

										        </p>
								</td>

								@if($user_info->id == Auth::id())
                                    <td>
                                        <div class="">
                                            <i class="fas fa-pen fa-clickable"></i>
                                            <br>
                                            <i class="far fa-circle fa-clickable"></i>
                                            <br>
                                            <i class="fas fa-times-circle fa-clickable text-danger"></i>
                                        </div>

                                    </td>
@endif


                                    </tr> -->
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!-- this section is for card which is the current teacher at the school , not needed now , according to Niaz bhaiya
		<div class="container-fluid">
		   <div class="row">
			<div class="col-sm-2">

						<div class="card-deck mb-5" style="width: 700px;">
					<div class="card">
						<img src="{{asset('images\logo\dummy.jpg')}}" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title">Name</h5>
							<h5 class="card-title">Qualification</h5>
							<h5 class="card-title">Acheivements</h5>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<h5 class="card-title text-center">View</h5>
						</div>
					</div>
					<div class="card">
						<img src="{{asset('images\logo\dummy.jpg')}}" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title">Name</h5>
							<h5 class="card-title">Qualification</h5>
							<h5 class="card-title">Acheivements</h5>
							<p class="card-text"></p>
						</div>

						<div class="card-footer">
							<h5 class="card-title text-center">View</h5>
						</div>
					</div>


					<div class="card">
						<img src="{{asset('images\logo\dummy.jpg')}}" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title">Name</h5>
							<h5 class="card-title">Qualification</h5>
							<h5 class="card-title">Acheivements</h5>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<h5 class="card-title text-center">View</h5>
						</div>
					</div>
				</div>

				</div>
			</div>
		</div> -->




        </div> <!-- 2nd col ends here -->


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

                <form id="jobPost" action="{{ route('add_job') }}" method="POST" class="mb-5">

                    @csrf
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
                            <label>Job Description <span class="text-danger font-weight-bold"> *</span>:</label>
                            <textarea class="form-control border-yellow" rows="5" name="description" placeholder="Job Description" required></textarea>

                        </div>

                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Job Responsibilities <span class="text-danger font-weight-bold"> *</span>:</label>
                            <textarea class="form-control border-yellow" rows="5" name="job_responsibilities" placeholder="Job Responsibilities" required></textarea>

                        </div>

                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Educational Requirement <span class="text-danger font-weight-bold"> *</span>:</label>
                            <textarea class="form-control border-yellow" rows="5" name="educational_requirement" placeholder="Educational Requirements" required></textarea>

                        </div>

                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Experience Requirements<span class="text-danger font-weight-bold"> *</span>:</label>
                            <textarea class="form-control border-yellow" rows="5" name="experience_requirements" placeholder="Experience Requirements" required></textarea>

                        </div>

                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Additional Requirements:</label>
                            <textarea class="form-control border-yellow" rows="5" name="additional_requirements" placeholder="Additional Requirements"></textarea>

                        </div>

                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Salary Range <span class="text-danger font-weight-bold"> *</span>:</label>
                            <input id="salary" type="text" class="form-control border-yellow" name="expected_salary_range" required placeholder="Salary Range (10,000 - 15,000/ Negotiable)">

                        </div>

                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-12 mb-5">
                            <label>Compensation & Other Benefits:</label>
                            <textarea class="form-control border-yellow" rows="5" name="compensation_other_benefits" placeholder="Compensation & Other Benefits"></textarea>

                        </div>

                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-6 mb-5">
                            <label>Gender Preference <span class="text-danger font-weight-bold"> *</span>:</label>
                            <select class="form-control border-yellow" name="gender" required>
                                <option value="" disabled selected>-- Select Prefered Gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Not Specified">Not Specified</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-6 mb-5">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="featureJob" class="custom-control-input" id="featureJobCheckbox">
                                <label class="custom-control-label" for="featureJobCheckbox">Feature your job</label>
                            </div>

                        </div>

                    </div>


                    <div class="form-row mt-1">
                        <div class="col-md-6 mb-5">
                            <label>Vacancy <span class="text-danger font-weight-bold"> *</span>:</label>
                            <input type="number" min="1" class="form-control border-yellow" name="vacancy" required placeholder="Number of vacancies">
                        </div>

                        <div class="col-md-6 mb-5">
                            <label>Age Limit:</label>
                            <input type="text" class="form-control border-yellow" name="age_limit" placeholder="Age Limit (25-35)years">

                        </div>

                    </div>

                    <div class="form-row mt-1">
                        <div class="col-md-6 mb-5">
                            <label>Deadline <span class="text-danger font-weight-bold"> *</span>:</label>
                            <input min="{{$deadLineMin}}" max="{{$deadLineMax}}" type="date" class="form-control border-yellow" name="deadline" required placeholder="Deadline of job">
                        </div>

                        <div class="col-md-6 mb-5">
                            <label>Job Type <span class="text-danger font-weight-bold"> *</span>:</label>
                            <select class="form-control border-yellow" name="nature" required>
                                <option value="" disabled selected>-- Select Job Type --</option>
                                <option value="1">Permanent</option>
                                <option value="2">Part-time</option>
                                <option value="3">Contractual</option>
                            </select>

                        </div>

                    </div>

                    @if($user_info->balance >= $jobPrice->price)
                    <button id="submitButton" type="button" Onclick="formSubmitPopupMessage({{$jobPrice->price}});" class="btn background-yellow float-right">Add Job</button>
                    <button id="noSubmitButton" type="button" Onclick="maxFeatureJobMessage();" style="display: none" class="btn background-yellow float-right">Add Job</button>
                    <button type="submit" style="display: none" class="btn background-yellow float-right">Add Job</button>
                    @else
                    <button type="button" Onclick="popupAlertInsufficientBalance({{$jobPrice->price}});" class="btn background-yellow float-right">Add Job</button>
                    @endif

                </form>




            </div>
        </div> <!-- 2nd col ends here -->

        {{-- @include('leaderboard')--}}

    </div><!-- row ends here -->


</div>








@push('js')

<script type="text/javascript">
    $('#pro_pic_choose').on('click', function() {
        $("#profile_picture").click();
    });
    $("#profile_picture").change(function() {
        $("#pro_pic_upload_form").submit();
    });

    $('#currently_working').change(function() {
        if (this.checked) {
            $('#work_end').attr("disabled", "disabled");
            $('#work_end').removeAttr("required");
        } else {
            $('#work_end').removeAttr("disabled");
            $('#work_end').attr("required", "required");
        }
    });

    function formSubmitPopupMessage(price) {

        if(document.getElementById("featureJobCheckbox").checked) price+=500;

        Swal.fire({
            icon: 'warning',
            title: 'Job price is ' + price + ' BDT',
            text: 'Are you sure to spend for posting a job?',
            confirmButtonColor: '#f5b82f',
            confirmButtonText: "Yes",
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#jobPost").find('[type="submit"]').trigger('click');
            }
        })
    }

    $('#featureJobCheckbox').change(function() {
        let featuredJobCount = '{{$featuredJobCount}}';
        if (featuredJobCount >= 4) {
            if (this.checked) {
                $('#submitButton').hide();
                $('#noSubmitButton').show();
            } else {
                $('#submitButton').show();
                $('#noSubmitButton').hide();
            }
        }
    });

    function maxFeatureJobMessage() {
        Swal.fire({
            icon: 'error',
            title: 'Sorry!',
            text: 'Maximum featured job limit reached',
            confirmButtonColor: '#f5b82f',
            confirmButtonText: "Ok",
        })
    }

    function popupAlertInsufficientBalance(price) {
        Swal.fire({
            icon: 'error',
            title: 'Oops! Insufficient Balance.',
            text: 'Job price is ' + price + ' BDT',
            confirmButtonColor: '#f5b82f',
        })
    }

    function toolkitDeleteConfirm(id) {
        Swal.fire({
            icon: 'question',
            title: 'Are you sure to delete?',
            confirmButtonColor: '#f5b82f',
            confirmButtonText: "Yes",
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#toolkitDeleteForm_" + id).find('[type="submit"]').trigger('click');
            }
        })
    }

    function resourceDeleteConfirm(id) {
        Swal.fire({
            icon: 'question',
            title: 'Are you sure to delete?',
            confirmButtonColor: '#f5b82f',
            confirmButtonText: "Yes",
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#resourceDeleteForm_" + id).find('[type="submit"]').trigger('click');
            }
        })
    }
</script>

@endpush


@endsection
