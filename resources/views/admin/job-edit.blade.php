@extends('master')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3 col-sm-12 pt-5 pb-3 text-center" style="background-color: #f5b82f;"><!--left col-->

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

                    {{--                <a href="{{ url('settings') }}" class="text-dark float-right mt-3"><i class="fas fa-pen" ></i> <small>Edit Details</small></a>--}}

                @endif


                <h3 class="mt-5 font-weight-bold text-white"> {{$user_info->name}}</h3>

                @for($i = 1; $i <= 5; $i++)
                    @if($user_info->rating - $i >= 0)
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
                            <form action="{{ route('admin.job.update', $job->id) }}" method="post" enctype="multipart/form-data" style="width: 100%;">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Title:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->job_title}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Creator:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->user->name}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Location:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->location}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Description:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->description}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Responsibilities:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->job_responsibilities}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Educational Requirements:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->educational_requirements}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Experience Requirements:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->experience_requirements }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Additional Requirements:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->additional_requirements}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Compensation & Other Benefits:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->compensation_other_benefits}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Age Limit:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->age_limit}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Nature:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->nature}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Vacancy:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->vacancy}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label bold">Salary:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->expected_salary_range}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label bold">Job Creator Status:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->poster_status}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label bold">Job Creator Status:</label>
                                    <div class="col-sm-10">
                                        <select class="custom-select mr-sm-2" name="admin_status">
                                            <option value="Approved" {{$job->admin_status == 'Approved' ? 'selected' : ''}}>Approved</option>
                                            <option value="Pending" {{$job->admin_status == 'Pending' ? 'selected' : ''}}>Pending</option>
                                            <option value="Disapprove" {{$job->admin_status == 'Disapprove' ? 'selected' : ''}}>Disapprove</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label bold">Job DeadLine:</label>
                                    <div class="col-sm-10">
                                        <p style="margin: 6px 0 0">{{$job->deadline}}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Comment:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="comment" placeholder="Reason for disapproval" rows="3">{{$job->admin_comment}}</textarea>
                                        <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Write Reason if disapprove the job.</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label bold"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Submit</button>
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
