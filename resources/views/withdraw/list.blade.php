@extends('layouts.master-dashboard')
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
        @include('includes.dashboard.deposit-withdraw')

        <div class="col-md-10 col-sm-12 mt-5">
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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Payment Method</th>
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
                                    <td>
                                        @if($item->user->identifier == 1)
                                        <a href="{{ url('t')}}/{{ $item->user->username }}" class="text-transform:capitalize">{{$item->user->name}}</a>
                                        @elseif($item->user->identifier == 2)
                                        <a href="{{ url('s')}}/{{ $item->user->username }}" class="text-transform:capitalize">{{$item->user->name}}</a>
                                        @endif
                                    </td>
                                    <td>{{$item->user->email}}</td>
                                    <td>{{$item->user->phone_number}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->created_at }}</td>
                                    <td>{{$item->payment_method }}</td>
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
                                    <td><a onclick="approveWR('<?php echo $item->id ?>')"><button class="btn btn-success">Approve</button></a></td>
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

    function approveWR(url){
        
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