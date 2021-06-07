@extends('layouts.master-dashboard')
@section('content')


<div class="container-fluid dashboard-bg">

    <div class="row">
        @include('includes.dashboard.teacher')

        <div class="col-md-7 col-sm-12 pt-5">
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('teacher.job.list')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Job Application
                        </a>
                    </div>
                </div>
                <div class="row dashboard-content-block">
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

                <div class="row dashboard-content-block">
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
                @if($canCreateCourse)
                <div class="row">
                    @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{$message}}
                    </div>
                    @endif
                    <div class="col-sm-12">
                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Courses</h3>
                        <a href="{{route('course.create')}}"><span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen"></i> <small>Add</small></span></a>
                        <div class="mr=2">
                            <div class="table-responsive-sm">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">No.</th>
                                            <th style="width:30%">Course name</th>
                                            <th style="width:20%">Price</th>
                                            <th style="width:20%">Status</th>
                                            <th style="width:20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n = 1 ?>
                                        @foreach ($courses as $course)
                                        <tr>
                                            <td>{{$n}}</td>
                                            <td>{{$course->title}}</td>
                                            <td>{{($course->price == 0) ? 'Free' : $course->price}}</td>
                                            <td>{{$course->status}}</td>
                                            <td>
                                                <a href="{{route('course.edit', $course->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
                                                <a href="{{route('course.admin.view', $course->id)}}" class="btn btn-success text-white btn-sm">View</a>
                                            </td>
                                        </tr>
                                        <?php $n++ ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($courses->count() == 0)
                                <h5 class="text-center text-muted">No Course to Show</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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
