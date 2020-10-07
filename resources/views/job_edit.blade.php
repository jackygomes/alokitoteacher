@extends('master')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <div class="container-fluid">

        <div class="row">
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

            <div class="col-md-9 col-sm-12 mt-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 mb-5">
                            <h3 class="font-weight-bold mr-3" style="display: inline-block">Job</h3>
                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <p>{{$error}}</p>
                                    @endforeach
                                </div>
                            @endif
                            <form action="{{ route('job.update', $job->id) }}" method="post" enctype="multipart/form-data" style="width: 100%;">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Title:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="job_title" class="form-control" value="{{$job->job_title}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Location:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="job_location" class="form-control" value="{{$job->location}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Description:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="description" rows="3" required>{{$job->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Responsibilities:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="job_responsibilities" rows="3" required>{{$job->job_responsibilities}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Educational Requirements:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="educational_requirements" rows="3" required>{{$job->educational_requirements}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Experience Requirements:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="experience_requirements" rows="3" required>{{$job->experience_requirements}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Additional Requirements:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="additional_requirements" rows="3">{{$job->additional_requirements}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label bold">Salary:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="salary" class="form-control" value="{{$job->expected_salary_range}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Compensation & Other Benefits:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="compensation_other_benefits" rows="3">{{$job->compensation_other_benefits}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Age Limit:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="age_limit" class="form-control" value="{{$job->age_limit}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Gender:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="gender" class="form-control" value="{{$job->gender}}" placeholder="Gender Preference" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Nature:</label>
                                    <div class="col-sm-10">
                                        <select class="custom-select mr-sm-2" name="nature" required>
                                            <option selected>Choose Type...</option>
                                            <option value="1" {{$job->nature == 1 ? 'selected' : ''}}>Parmanent</option>
                                            <option value="2" {{$job->nature == 2 ? 'selected' : ''}}>Part-time</option>
                                            <option value="3" {{$job->nature == 3 ? 'selected' : ''}}>Contractual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Vacancy:</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="vacancy" class="form-control" value="{{$job->vacancy}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label bold">Job DeadLine:</label>
                                    <div class="col-sm-10">
                                        <input  type="date" class="form-control border-yellow" value="{{$job->deadline}}" name="deadline" required placeholder="Deadline of job">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label bold"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Update</button>
                                    </div>
                                </div>

                            </form>
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
            } );

            $('#pro_pic_choose').on('click', function () {
                $("#profile_picture").click();
            });
            $("#profile_picture").change(function () {
                $("#pro_pic_upload_form").submit();
            });

        </script>

    @endpush

@endsection
