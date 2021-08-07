@extends('master')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<div class="container-fluid">

    <div class="row">
        @include('includes.dashboard.admin')

        <div class="col-md-9 col-sm-12 mt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 mb-5">
                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Blog List</h3>
                        <a href="{{route('blog.create')}}">
                            <span class="fa-clickable text-primary" data-toggle="modal" data-target="#addJobModal"><i class="fas fa-pen"></i> <small>Add</small></span>
                        </a>
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
                                    <th>Created By</th>
                                    <th>Blog Title</th>
                                    <th>status</th>
                                    <th>Upload Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $index => $blog)
                                <tr>
                                    <td>{{$index+1}}.</td>
                                    <td>{{$blog->user->name }}</td>
                                    <td>{{$blog->name }}</td>
                                    <td>{{$blog->status}}</td>
                                    <td>{{$blog->created_at}}</td>
                                    <td>
                                        <a href="#" class="btn btn-info text-white btn-sm">View</a>
                                        <a href="{{route('blog.edit', $blog->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
                                        <a href="{{route('blog.delete', $blog->id)}}" class="btn btn-danger text-white btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
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
</script>
@endpush

@endsection