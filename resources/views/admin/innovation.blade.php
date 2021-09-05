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
                    <div class=" mt-5 mb-3 col-sm-12">
                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Innovations</h3>
                        <a href="{{route('resource.create')}}"><span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen"></i> <small>Add</small></span></a>
                        <div class="mr=2">
                            <div class="table-responsive-sm">
                                <table id="innovaion" class="table ">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">No.</th>
                                            <th style="width:30%">Innovation Name</th>
                                            <th style="width:10%">Price</th>
                                            <th style="width:10%">Creator</th>
                                            <th style="width:10%">Submission Date</th>
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
                                            <td>{{$resource->user->name}}</td>
                                            <td>{{$resource->created_at}}</td>
                                            <td>{{$resource->status}}</td>
                                            <td>
                                                <form id="resourceDeleteForm_{{$resource->id}}" action="{{ route('resource.delete', ['id' => $resource->id]) }}" method="post">
                                                    <a href="{{route('resource.edit',$resource->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
                                                    <a href="{{route('resource.admin.view', $resource->id)}}" class="btn btn-success text-white btn-sm">View</a>
                                                    @if(Auth::user()->identifier != 104)
                                                    <input class="btn btn-danger btn-sm" onclick="resourceDeleteConfirm({{$resource->id}})" type="button" value="Remove" />
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
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#innovaion').DataTable();
    });

    $('#pro_pic_choose').on('click', function() {
        $("#profile_picture").click();
    });
    $("#profile_picture").change(function() {
        $("#pro_pic_upload_form").submit();
    });

    function resourceDeleteConfirm(id) {
        Swal.fire({
            icon: 'question',
            title: 'Are you sure to delete?',
            confirmButtonColor: '#f5b82f',
            confirmButtonText: "Yes",
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $("#resourceDeleteForm_" + id).find('[type="submit"]').trigger('click');
            }
        })
    }

</script>

@endpush

@endsection
