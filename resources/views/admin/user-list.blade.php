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
                            <h3 class="font-weight-bold mr-3" style="display: inline-block">Users</h3>
                            <table id="userList" class="table table-striped table-bordered " style="width:100%">
                                <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Name</th>
                                    <th>Phone No.</th>
                                    <th>Role</th>
                                    <th>Joined At</th>
                                    <th>Balance</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                @foreach($allUser as $user)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->phone_number}}</td>
                                        <td>
                                            @if($user->identifier == 101)
                                                Admin
                                            @elseif($user->identifier == 1)
                                                Teacher
                                            @elseif($user->identifier == 2)
                                                School
                                            @elseif($user->identifier == 3)
                                                Parent
                                            @elseif($user->identifier == 4)
                                                Student
                                            @endif
                                        </td>
                                        <td>{{date("d-m-Y   ", strtotime($user->created_at))}}</td>
                                        <td>{{round($user->balance, 2)}}</td>
                                        <td>
                                            @if($user->identifier == 1)
                                                <a href="{{ url('t')}}/{{ $user->username }}" class="btn btn-info text-white btn-sm">View</a>
                                            @elseif($user->identifier == 4)
                                                <a href="{{ url('stu')}}/{{ $user->username }}" class="btn btn-info text-white btn-sm">View</a>
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
