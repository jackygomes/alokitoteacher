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
                        <h3 class="font-weight-bold mr-3">Withdrawal Requests</h3>
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
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Payment Details</th>
                                    <th>Status</th>
                                    <th>Approve</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($transactions as $item)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td style="text-transform:capitalize">{{$item->user->name}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->created_at }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong{{$item->id}}">
                                            See payment Details
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalLong{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">{{$item->user->name}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{$item->note}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$item->status }}</td>
                                    @if($item->status == 'Pending')
                                    <td><a onclick="oki_doki('<?php echo $item->id ?>')"><button class="btn btn-success">Approve</button></a></td>
                                    @elseif($item->status == 'paid')
                                    <td><span>Completed</span></td>
                                    @elseif($item->status == 'rejected')
                                    <td><span>Rejected</span></td>
                                    @endif
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
    });

    $('#pro_pic_choose').on('click', function() {
        $("#profile_picture").click();
    });
    $("#profile_picture").change(function() {
        $("#pro_pic_upload_form").submit();
    });

    function oki_doki(url){
        
        url = '/withdrawals/approve/' + url;
        console.log(url);
        Swal.fire({
                icon: 'warning',
                text: 'Are you sure to Approve this withdrawal Request?',
                confirmButtonColor: '#f5b82f',
                confirmButtonText: "Yes",
                showCancelButton: true,
                cancelButtonText:'Cancel',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = url;
                }
            })
    }

</script>

@endpush

@endsection