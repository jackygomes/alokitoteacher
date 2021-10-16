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
                        <h3 class="font-weight-bold mr-3">Email Subscriber List</h3>
                        <table id="subscriberList" class="table table-striped table-bordered " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($subscriberList as $item)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->created_at}}</td>
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
        $('#subscriberList').DataTable();
    });
</script>

@endpush
@endsection