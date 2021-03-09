@extends('master')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<style>
    .custom-control-input:checked~.custom-control-label::before {
        color: #f5b82f !important;
        background-color: #f5b82f !important;
        border-color: #f5b82f !important;
    }
</style>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-3 col-sm-12 pt-5 pb-3 text-center" style="background-color: #f5b82f;">
            <!--left col-->

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

            {{-- <a href="{{ url('settings') }}" class="text-dark float-right mt-3"><i class="fas fa-pen"></i> <small>Edit Details</small></a>--}}

            @endif


            <h3 class="mt-5 font-weight-bold text-white"> {{$user_info->name}}</h3>

            @for($i = 1; $i <= 5; $i++) @if($user_info->rating - $i >= 0)
                <i class="fa fa-star" aria-hidden="true"></i>
                @else
                <i class="far fa-star text-white"></i>
                @endif
                @endfor



                @if($user_info->id == Auth::id())

                <div class="row text-left p-2 mt-3">
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

                @endif
                <h4 class="mt-3">Revenue Balance </h4>
                <p>{{ $revenue }} BDT</p>


        </div>

        <div class="col-md-9 col-sm-12 mt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 mb-5">
                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Job List</h3>
                        <span class="fa-clickable text-primary" data-toggle="modal" data-target="#addJobModal"><i class="fas fa-pen"></i> <small>Add</small></span>
                        @if($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{$message}}
                        </div>
                        @elseif($message = Session::get('danger'))
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                        @endif
                        <table id="userList" class="table table-striped table-bordered " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Job Title</th>
                                    <th>Job Creator</th>
                                    <th>Job Location</th>
                                    <th>Job Nature</th>
                                    <th>Vacancy</th>
                                    <th>Dead Line</th>
                                    <th>Remove</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($jobs as $job)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$job->job_title }}</td>
                                    <td>{{$job->user->name }}</td>
                                    <td>{{$job->location}}</td>
                                    <td>
                                        @if($job->nature == 1)
                                        Permanent
                                        @elseif($job->nature == 2)
                                        Part-time
                                        @elseif($job->nature == 3)
                                        Contractual
                                        @endif
                                    </td>
                                    <td>{{$job->vacancy}}</td>
                                    <td>{{$job->deadline}}</td>
                                    <td>
                                        @if($job->removed == 1) Yes
                                        @else No
                                        @endif
                                    </td>
                                    <td>{{$job->admin_status}}</td>
                                    <td>
                                        <a href="{{route('admin.job.edit', $job->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{--Modal--}}
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
                                        <input type="text" class="form-control border-yellow" name="age_limit" required placeholder="Age Limit (25-35)years">

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
                                <div class="form-row mb-4">
                                    <div class="col-md-12">
                                        <label>On Behalf Of:</label>
                                        <select class="form-control border-yellow" name="obf" required>
                                            <option value="0" selected>-- Select Institution --</option>
                                            @foreach($schools as $school)
                                            <option value="{{$school->id}}">{{$school->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <button id="submitButton" type="button" Onclick="formSubmitPopupMessage();" class="btn background-yellow float-right">Add Job</button>
                                <button id="noSubmitButton" type="button" style="display: none" Onclick="maxFeatureJobMessage();" class="btn background-yellow float-right">Add Job</button>
                                <button type="submit" style="display: none" class="btn background-yellow float-right">Add Job</button>

                            </form>




                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#userList').DataTable();
    });

    $('#pro_pic_choose').on('click', function() {
        $("#profile_picture").click();
    });
    $("#profile_picture").change(function() {
        $("#pro_pic_upload_form").submit();
    });

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

    function formSubmitPopupMessage() {
        Swal.fire({
            icon: 'warning',
            title: 'Job posting is free for admin.',
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

    function maxFeatureJobMessage() {
        Swal.fire({
            icon: 'error',
            title: 'Sorry!',
            text: 'Maximum featured job limit reached',
            confirmButtonColor: '#f5b82f',
            confirmButtonText: "Ok",
        })
    }
</script>

@endpush

@endsection