@extends('master')
@section('content')


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12 col-sm-12 mt-5">
                <div class="container-fluid ">
                    <div class="row">
                        <div class=" mt-5 mb-3 col-sm-12 mb-5 text-center">
                            @if($status == "success")
                                <h3 class="font-weight-bold mr-3 text-center text-success"><i class="fa fa-check-circle" aria-hidden="true"></i>
                                     Deposit Successful</h3>
                                <p class="text-center">Your deposit successfully complete. You can check your balance from your account.</p>
                            @elseif($status == "failed")
                                <h3 class="font-weight-bold mr-3 text-center text-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> Deposit Failed</h3>
                                <p class="text-center">There is something wrong with your deposit.</p>
                            @endif
                            <a href="/" class=" btn background-yellow"style="display: inline-block" ><i class="fa fa-reply" aria-hidden="true"></i> Back To Home</a>

                        </div>
                    </div>
                </div>
            </div>

        </div><!-- row ends here -->
    </div>


@endsection
