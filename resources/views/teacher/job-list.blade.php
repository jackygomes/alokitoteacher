@extends('layouts.master-dashboard')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <div class="container-fluid dashboard-bg">

        <div class="row">
            @include('includes.dashboard.teacher')

            <div class="col-md-7 col-sm-12 pt-5">
                <div class="container-fluid ">
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12">--}}
{{--                            <a href="{{route('teacher.job.list')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">--}}
{{--                                back--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="row dashboard-content-block">
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

            <div class="col-md-3">
                @include('leaderboard')
                <div class="advertise">

                </div>
            </div>





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
