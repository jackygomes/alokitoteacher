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
        @include('includes.dashboard.admin')

        <div class="col-md-9 col-sm-12 mt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 mb-5">
                        <h3 class="font-weight-bold mr-3">Contact Form Messages</h3>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($contact_messages as $message)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$message->name}}</td>
                                    <td>{{$message->email}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong{{$message->id}}">
                                            See Details
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalLong{{$message->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                                        Name: {{$message->name}}<br>
                                                        <p class="mb-0">Email: {{$message->email}}</p>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{$message->message}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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