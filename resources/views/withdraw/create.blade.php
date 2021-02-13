@extends('master')
@section('content')


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

            <a href="{{ url('settings') }}" class="text-dark float-right mt-3"><i class="fas fa-pen"></i> <small>Edit Details</small></a>

            @endif


            <h3 class="mt-5 font-weight-bold text-white"> {{$user_info->name}}</h3>

            @for($i = 1; $i <= 5; $i++) @if($user_info->rating - $i >= 0)
                <i class="fa fa-star" aria-hidden="true"></i>
                @else
                <i class="far fa-star text-white"></i>
                @endif
                @endfor

                <div class="row text-left p-2 mt-3">


                    <div class="col-2 mt-3">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <div class="col-10 mt-3">
                        @if($user_info->date_of_birth != null) {{ date("jS F, Y", strtotime($user_info->date_of_birth)) }} @else - @endif
                    </div>
                </div>

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


                <h4 class="mt-3">Current Balance </h4>
                <p>{{ round($user_info->balance, 2) }}</p>
                <div class="">
                    <button type="button" class=" btn btn-success btn-sm" style="display: inline-block">Deposit</button>
                    <button type="button" class="  btn btn-danger btn-sm">Withdraw</button>
                </div>
                @endif


        </div>

        <div class="col-md-9 col-sm-12 mt-5">
            <div class="container-fluid ">
                <div class="row">
                    <div class=" mt-5 mb-3 col-sm-12">

                        <h3 class="font-weight-bold mr-3" style="display: inline-block">Withdrawal Information</h3>
                        <form class="mt-3" method="POST" action="{{route('withdraw')}}">
                            @csrf

                            @if(session()->has('successInfo'))
                            <div class="alert alert-success">
                                {{ session()->get('successInfo') }}
                            </div>
                            @endif
                            @if(session()->has('successFailed'))
                            <div class="alert alert-danger">
                                {{ session()->get('successFailed') }}
                            </div>
                            @endif

                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control border-yellow" name="name" value="{{Auth::user()->name}}" readonly required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control border-yellow" name="email" value="{{Auth::user()->email}}" readonly required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-md-2 col-form-label text-md-right">Phone No.</label>
                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control border-yellow" name="phone" value="{{Auth::user()->phone_number}}" required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="amount" class="col-md-2 col-form-label text-md-right">Amount</label>
                                <div class="col-md-6">
                                    <input id="amount" type="number" class="form-control border-yellow" name="amount" required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="payment_details" class="col-md-2 col-form-label text-md-right">Payment Details</label>
                                <div class="col-md-6">
                                    <textarea class="form-control border-yellow" placeholder="I.E - Bank Account No., bKash/Rocket, other payment details" name="payment_details" id="payment_details" cols="30" rows="10" required></textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-2">
                                    <button type="submit" class="btn background-yellow">
                                        Deposit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 border-top mt-2 mb-2 text-center d-flex justify-content-center" style="background-color: #343a40;">
                        <div class="col-md-8">
                            <img class="img-fluid ssl-banner" src="/images/ssl.png">
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- 2nd col ends here -->

        {{-- @include('leaderboard')--}}





    </div><!-- row ends here -->




</div>








@push('js')

<script type="text/javascript">
    $('#pro_pic_choose').on('click', function() {
        $("#profile_picture").click();
    });
    $("#profile_picture").change(function() {
        $("#pro_pic_upload_form").submit();
    });

    $('#currently_working').change(function() {
        if (this.checked) {
            $('#work_end').attr("disabled", "disabled");
            $('#work_end').removeAttr("required");
        } else {
            $('#work_end').removeAttr("disabled");
            $('#work_end').attr("required", "required");
        }
    });
</script>

@endpush


@endsection