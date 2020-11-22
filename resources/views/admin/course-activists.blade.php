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
                <h4 class="mt-3">Revenue Balance </h4>
                <p>{{ $revenue }} BDT</p>


            </div>

            <div class="col-md-9 col-sm-12 mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{route('dashboard')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                                Back
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
                            <h3 class="font-weight-bold mr-3" style="display: inline-block">Course Activists</h3>
                            <a href="{{route('admin.course.activist.create')}}"><span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen" ></i> <small>Add</small></span></a>
                            <div class="mr=2">
                                <div class="table-responsive-sm">
                                    <table class="table ">
                                        <thead>
                                        <tr>
                                            <th style="width:10%">No.</th>
                                            <th style="width:10%">Image</th>
                                            <th style="width:30%">Name</th>
                                            <th style="width:30%">Description</th>
                                            <th style="width:20%">Type</th>
                                            <th style="width:20%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n = 1?>
                                        @foreach ($activists as $activist)
                                            <tr>
                                                <td>{{$n}}</td>
                                                <td><img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/course_activist_image') }}/{{ $activist->image }}"></td>
                                                <td>{{$activist->name}}</td>
                                                <td>{{ Str::limit($activist->description, 20) }}</td>
                                                <td>{{$activist->type}}</td>
                                                <td>
                                                    <form id="deleteForm_{{$activist->id}}" action="{{ route('admin.course.activist.delete', ['id' => $activist->id]) }}" method="post">
                                                        <input class="btn btn-danger btn-sm" onclick="deleteConfirm({{$activist->id}})" type="button" value="Remove" />
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
                                    @if($activists->count() == 0)
                                        <h5 class="text-center text-muted">No Activist to Show</h5>
                                    @endif
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

            function deleteConfirm(id) {
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure to delete?',
                    confirmButtonColor: '#f5b82f',
                    confirmButtonText: "Yes",
                    showCancelButton: true,
                    cancelButtonText:'Cancel',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#deleteForm_"+id).find('[type="submit"]').trigger('click');
                    }
                })
            }

        </script>

    @endpush

@endsection
