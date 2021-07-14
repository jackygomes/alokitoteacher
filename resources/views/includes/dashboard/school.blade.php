<div class="col-md-2 col-sm-12 pt-5 text-center dashboard-left-panel">
            <!--left col-->
    @if($user_info->id == Auth::id())
        <a href="{{ url('settings') }}" class="text-white text-right mb-5" style="display: block"><i class="fas fa-pen"></i> Edit Details</a>
    @endif

    <div style="width: 150px; height: 150px;" class="mx-auto">
        @if($user_info->image == null)
        <i class="fas fa-user-circle fa-10x text-white"></i>
        @else
        <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $user_info->image }}">
        @endif
    </div>

    <h3 class="mt-3 font-weight-bold text-white">{{$user_info->name}}</h3>
    @for($i = 1; $i <= 5; $i++) @if($user_info->rating - $i >= 0)
        <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
        @else
        <i class="far fa-star text-white"></i>
        @endif
    @endfor

    <div class="row text-left p-2 mt-3 user-info">
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/school-location.png')}}" alt="">
                <p class="info-text">{{ $user_info->location == null ? '-' :  $user_info->location }}</p>
            </div>
        </div>
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/school-type.png')}}" alt="">
                <p class="info-text">{{ $user_info->curriculum == null ? '-' :  $user_info->curriculum }}</p>
            </div>
        </div>
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/class-range.png')}}" alt="">
                <p class="info-text">{{ $user_info->classes_from == null ? '-' :  $user_info->classes_from }} - {{ $user_info->classes_to == null ? '-' :  $user_info->classes_to }}</p>
            </div>
        </div>
        @if($user_info->id == Auth::id())
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/school-mail.png')}}" alt="">
                <p class="info-text">{{$user_info->email}}</p>
            </div>
        </div>
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/school-phone.png')}}" alt="">
                <p class="info-text"> {{$user_info->phone_number}}</p>
            </div>
        </div>
        @endif
    </div>
    <div class="stat mt-4">
        <div class="stat-block">
            <p><span class="float-left">Teachers</span><span class="float-right text-yellow">
                    @if(isset($user_info->no_of_teacher))
                        {{$user_info->no_of_teacher}}
                    @else
                        0
                    @endif
                </span></p>
        </div>
        <div class="stat-block">
            <p><span class="float-left">Students</span><span class="float-right text-yellow">
                    @if(isset($user_info->no_of_student))
                        {{$user_info->no_of_student}}
                    @else
                        0
                    @endif
                </span></p>
        </div>
        <div class="stat-block">
            <p><span class="float-left">Job Opens</span><span class="float-right text-yellow">
                    @if(isset($openJobs))
                        {{count($openJobs)}}
                    @else
                        0
                    @endif</span></p>
        </div>
    </div>

    @if($user_info->id == Auth::id())
        <hr class="my-5">

        <p class="my-3 balance"><span class="float-left">Current Balance</span> <span class="float-right text-white">{{ round($user_info->balance, 2) }} Tk.</span></p>
        <p class="my-3 balance"><span class="float-left">Total Earnings</span> <span class="float-right text-white">{{ $earnings }} Tk.</span></p>
        <div class="deposit-withdraw-buttons">
            <a href="{{route('deposit.form')}}" class=" btn btn-success float-left">Deposit</a>
            <a href="{{route('withdraw.form')}}" class=" btn btn-danger float-right">Withdraw</a>
        </div>
    @endif

</div>