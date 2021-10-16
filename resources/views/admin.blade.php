@extends('master')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<div class="container-fluid">

    <div class="row">
        @include('includes.dashboard.admin')

        <div class="col-md-9 col-sm-12 mt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('user.list')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            User List
                        </a>
                        <a href="{{route('admin.innovations')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Innovations
                        </a>
                        <a href="{{route('blog.index')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Blogs
                        </a>
                        <a href="{{route('admin.basic.info')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Basic Info
                        </a>
                        <a href="{{route('admin.leader.board')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Leader Board
                        </a>
                        <a href="{{route('admin.job.list')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Job List
                        </a>
                        <a href="{{route('admin.course.activist')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Course Activists
                        </a>
                        @if($user_info->identifier == 101)
                        <a href="{{route('admin.transactions')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Transactions History
                        </a>
                        <a href="{{route('admin.revenue')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Revenue
                        </a>
                        <a href="{{route('withdrawals')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Withdrawal Requests
                        </a>
                        @endif
                        <a href="{{route('workshop.index')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Workshop
                        </a>
                        <a href="{{route('admin.contact.messages.list')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Contact Messages
                        </a>
                        <a href="{{route('admin.email.subscriber.list')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Email Subscribers
                        </a>
                    </div>
                </div>
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
                                <table id="course" class="table ">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">No.</th>
                                            <th style="width:25%">Course name</th>
                                            <th style="width:15%">Price</th>
                                            <th style="width:25%">Creator</th>
                                            <th style="width:5%">Status</th>
                                            <th style="width:30%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n = 1 ?>
                                        @foreach ($courses as $course)
                                        <tr>
                                            <td>{{$n}}</td>
                                            <td>{{$course->title}}</td>
                                            <td>{{($course->price == 0) ? 'Free' : $course->price}}</td>
                                            <td>{{$course->user->name}}</td>
                                            <td>{{$course->status}}</td>
                                            <td>
                                                <form id="courseDeleteForm_{{$course->id}}" action="{{ route('course.delete', ['id' => $course->id]) }}" method="post">
                                                    <a href="{{route('course.edit', $course->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
                                                    <a href="{{route('course.admin.view', $course->id)}}" class="btn btn-success text-white btn-sm">View</a>
                                                    @if(Auth::user()->identifier != 104)
                                                        <input class="btn btn-danger btn-sm" onclick="courseDeleteConfirm({{$course->id}})" type="button" value="Remove" />
                                                        <input class="btn btn-danger btn-sm" style="display: none" type="submit" value="Remove" />
                                                    @endif
                                                    @method('delete')
                                                    @csrf
                                                </form>
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

               <!-- <div class="row">
                    <div class=" mt-5 mb-3 col-sm-12">
                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Toolkits</h3>
                        <a href="toolkit/create"><span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen"></i> <small>Add</small></span></a>
                        <div class="mr=2">
                            <div class="table-responsive-sm">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">No.</th>
                                            <th style="width:20%">Subject</th>
                                            <th style="width:30%">Toolkit Name</th>
                                            <th style="width:10%">Price</th>
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
                                            <td>{{$toolkit->status}}</td>
                                            <td>
                                                <form id="toolkitDeleteForm_{{$toolkit->id}}" action="{{ route('toolkit.delete', ['id' => $toolkit->id]) }}" method="post">
                                                    <a href="{{route('toolkit.edit',$toolkit->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
                                                    <a href="{{route('toolkit.admin.view', $toolkit->id)}}" class="btn btn-success text-white btn-sm">View</a>
                                                    @if(Auth::user()->identifier != 104)
                                                    <input class="btn btn-danger btn-sm" onclick="toolkitDeleteConfirm({{$toolkit->id}})" type="button" value="Remove" />
                                                    <input class="btn btn-danger btn-sm" style="display: none" type="submit" value="Remove" />
                                                    @endif
                                                    @method('delete')
                                                    @csrf
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $n++ ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$toolkits->links()}}
                                {{--@if($toolkits->count() == 0)--}}
                                {{--<h5 class="text-center text-muted">No Toolkit to Show</h5>--}}
                                {{--@endif--}}
                            </div>
                        </div>
                    </div>
                </div> -->

                
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#course').DataTable();
    });
    $('#pro_pic_choose').on('click', function() {
        $("#profile_picture").click();
    });
    $("#profile_picture").change(function() {
        $("#pro_pic_upload_form").submit();
    });

    function courseDeleteConfirm(id) {
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
                $("#courseDeleteForm_" + id).find('[type="submit"]').trigger('click');
            }
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
</script>

@endpush

@endsection
