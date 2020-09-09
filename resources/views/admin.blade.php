@extends('master')
@section('content')


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

        <div class="col-md-9 col-sm-12 mt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('user.list')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            User List
                        </a>
                        <a href="{{route('admin.basic.info')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Basic Info
                        </a>
                        <a href="{{route('admin.leader.board')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                            Leader Board
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
                        <a href="{{route('course.create')}}"><span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen" ></i> <small>Add</small></span></a>
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
                                    <?php $n = 1?>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>{{$n}}</td>
                                            <td>{{$course->title}}</td>
                                            <td>{{($course->price == 0) ? 'Free' : $course->price}}</td>
                                            <td>{{$course->status}}</td>
                                            <td><a href="{{route('course.edit', $course->id)}}" class="btn btn-info text-white btn-sm">Edit</a> <a href="#" class="btn btn-danger btn-sm">Remove</a></td>
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

                <div class="row">
                    <div class=" mt-5 mb-3 col-sm-12">
                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Toolkits</h3>
                        <a href="toolkit/create"><span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen" ></i> <small>Add</small></span></a>
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
                                    <?php $n = 1?>
                                    @foreach ($toolkits as $toolkit)
                                        <tr>
                                            <td>{{$n}}</td>
                                            <td>{{$toolkit->subject->subject_name}}</td>
                                            <td>{{$toolkit->toolkit_title}}</td>
                                            <td>{{($toolkit->price == 0) ? 'Free' : $toolkit->price}}</td>
                                            <td>{{$toolkit->status}}</td>
                                            <td><a href="{{route('toolkit.edit',$toolkit->id)}}" class="btn btn-info text-white btn-sm">Edit</a> <a href="#" class="btn btn-danger btn-sm">Remove</a></td>
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
                </div>

                <div class="row">
                    <div class=" mt-5 mb-3 col-sm-12">
                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Resource</h3>
                        <a href="{{route('resource.create')}}"><span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen" ></i> <small>Add</small></span></a>
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
                                    <?php $n = 1?>
                                    @foreach ($resources as $resource)
                                        <tr>
                                            <td>{{$n}}</td>
                                            <td>{{$resource->resource_title}}</td>
                                            <td>{{($resource->price == 0) ? 'Free' : $resource->price}}</td>
                                            <td>{{$resource->status}}</td>
                                            <td><a href="{{route('resource.edit',$resource->id)}}" class="btn btn-info text-white btn-sm">Edit</a> <a href="#" class="btn btn-danger btn-sm">Remove</a></td>
                                        </tr>
                                        <?php $n++ ?>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$resources->links()}}
                                {{--@if($toolkits->count() == 0)--}}
                                {{--<h5 class="text-center text-muted">No Toolkit to Show</h5>--}}
                                {{--@endif--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')

<script type="text/javascript">
    $('#pro_pic_choose').on('click', function () {
        $("#profile_picture").click();
    });
    $("#profile_picture").change(function () {
        $("#pro_pic_upload_form").submit();
    });

</script>

@endpush

@endsection
