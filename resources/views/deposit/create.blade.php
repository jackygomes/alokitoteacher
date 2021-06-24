@extends('layouts.master-dashboard')
@section('content')


    <div class="container-fluid">

        <div class="row">
        @include('includes.dashboard.deposit-withdraw')

            <div class="col-md-10 col-sm-12 mt-5">
                <div class="container-fluid ">
                    <div class="row">
                        <div class=" mt-5 mb-3 col-sm-12">
                            <h3 class="font-weight-bold mr-3" style="display: inline-block">Deposit Information</h3>
                            <form class="mt-3" method="POST" action="{{route('deposit.money')}}">
                                @csrf

                                @if(session()->has('successInfo'))
                                    <div class="alert alert-success">
                                        {{ session()->get('successInfo') }}
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

{{--            @include('leaderboard')--}}





        </div><!-- row ends here -->




    </div>








    @push('js')

        <script type="text/javascript">
            $('#pro_pic_choose').on('click', function () {
                $("#profile_picture").click();
            });
            $("#profile_picture").change(function () {
                $("#pro_pic_upload_form").submit();
            });

            $('#currently_working').change(function() {
                if(this.checked) {
                    $('#work_end').attr("disabled", "disabled");
                    $('#work_end').removeAttr("required");
                }else{
                    $('#work_end').removeAttr("disabled");
                    $('#work_end').attr("required", "required");
                }
            });

        </script>

    @endpush


@endsection
