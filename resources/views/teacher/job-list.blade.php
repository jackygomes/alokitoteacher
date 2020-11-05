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

                    <a href="{{ url('settings') }}" class="text-dark float-right mt-3"><i class="fas fa-pen" ></i> <small>Edit Details</small></a>

                @endif


                <h3 class="mt-5 font-weight-bold text-white"> {{$user_info->name}}</h3>

                @for($i = 1; $i <= 5; $i++)
                    @if($user_info->rating - $i >= 0)
                        <i class="fa fa-star" aria-hidden="true"></i>
                    @else
                        <i class="far fa-star text-white"></i>
                    @endif
                @endfor

                <div class="row text-left p-2 mt-3">
                    <div class="col-12">
                        Recent Status:
                    </div>
                    <div class="col-2">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="col-10">
                        @if($recent_institute != null) {{ $recent_institute->institute }} @else - @endif
                    </div>

                    <div class="col-2">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="col-10">
                        @if($recent_work != null) {{ $recent_work->institute }} @else - @endif
                    </div>

                    <div class="col-2">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="col-10">
                        @if($recent_work != null) {{ $recent_work->position }} @else - @endif
                    </div>

                    <div class="col-2 mt-3">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <div class="col-10 mt-3">
                        @if($user_info->date_of_birth != null) {{ date("jS F, Y", strtotime($user_info->date_of_birth)) }} @else - @endif
                    </div>
                </div>

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


                    <h4 class="mt-3">Current Balance </h4>
                    <p>{{ round($user_info->balance, 2) }}</p>
                    <div class="">
                        <a href="{{route('deposit.form')}}" class=" btn btn-success btn-sm"style="display: inline-block" >Deposit</a>
                        <button type="button" class="  btn btn-danger btn-sm">Withdraw</button>
                    </div>
                @endif


            </div>

            <div class="col-md-7 col-sm-12 mt-5">
                <div class="container-fluid ">
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12">--}}
{{--                            <a href="{{route('teacher.job.list')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">--}}
{{--                                back--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="row">
                        <div class=" mt-5 mb-3 col-sm-12">
                            <h3 class="font-weight-bold mr-3" style="display: inline-block">Job Application List</h3>
                            <div class="mr=2">
                                <table id="jobTable" class="table table-bordered " style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Job Name</th>
                                        <th>School Name</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jobApplications as $jobApplication)
                                        <tr>
                                            <td>{{$jobApplication->no}}</td>
                                            <td>
                                                <a class="" href="{{ url('job_detail') }}/{{ $jobApplication->job_id }}">
                                                    {{$jobApplication->job->job_title}}
                                                </a>
                                            </td>
                                            <td>{{$jobApplication->job->user->name}}</td>
                                            <td>
                                                @if($jobApplication->status == "New")
                                                    In Review
                                                @else
                                                    {{$jobApplication->status}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div> <!-- 2nd col ends here -->

            @include('leaderboard')





        </div><!-- row ends here -->




    </div>








    @push('js')
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

        <script type="text/javascript">
            $('#jobTable').DataTable();
            $('#pro_pic_choose').on('click', function () {
                $("#profile_picture").click();
            });
            $("#profile_picture").change(function () {
                $("#pro_pic_upload_form").submit();
            });

            $('#currently_working').change(function() {
                if(this.checked) {
                    $('#work_end').attr("disabled", "disabled");
                    $('#work_end').removeAttr("required");
                }else{
                    $('#work_end').removeAttr("disabled");
                    $('#work_end').attr("required", "required");
                }
            });

        </script>

    @endpush


@endsection