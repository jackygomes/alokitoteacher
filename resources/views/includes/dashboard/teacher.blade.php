<div class="col-md-2 col-sm-12 pt-3 pb-5 text-center dashboard-left-panel">
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

    <h3 class="mt-5 font-weight-bold text-white"> {{$user_info->name}}</h3>

    @for($i = 1; $i <= 5; $i++) @if($user_info->rating - $i >= 0)
        <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
        @else
        <i class="far fa-star text-white"></i>
        @endif
    @endfor

    <div class="row text-left p-2 mt-3 user-info">
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/bday.png')}}" alt="">
                <p class="info-text">@if($user_info->date_of_birth != null) {{ date("jS F, Y", strtotime($user_info->date_of_birth)) }} @else - @endif</p>
            </div>
        </div>
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/briefcase.png')}}" alt="">
                <p class="info-text">@if($recent_work != null) {{ $recent_work->institute }} @else - @endif</p>
            </div>
        </div>
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/user-2-line.png')}}" alt="">
                <p class="info-text">@if($recent_work != null) {{ $recent_work->position }} @else - @endif</p>
            </div>
        </div>
        
        @if($user_info->id == Auth::id() || Auth::user()->identifier == 101 || Auth::user()->identifier == 104)
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/call.png')}}" alt="">
                <p class="info-text">@if($user_info->phone_number != null) {{ $user_info->phone_number }} @else - @endif</p>
            </div>
        </div>
        <div class="col-12">
            <div class="info-wrap">
                <img class="info-image" src="{{asset('images/new_design/mail.png')}}" alt="">
                <p style="cursor: pointer" class="info-text" data-toggle="tooltip" data-placement="right" title="{{$user_info->email}}">@if($user_info->email != null) {{ str_limit($user_info->email, 18) }} @else - @endif</p>
            </div>
        </div>
        @endif
    </div>
    <div class="stat mt-4">
        <div class="stat-block">
            <p><span class="float-left">Course in progress</span><span class="float-right text-yellow">
                    @if(isset($progresses))
                        {{count($progresses)}}
                    @else
                        0
                    @endif
                    
                </span></p>
        </div>
        <div class="stat-block">
            <p><span class="float-left">Course completed</span><span class="float-right text-yellow">
                    @if(isset($achievements))
                        {{count($achievements)}}
                    @else
                        0
                    @endif
                </span></p>
        </div>
        <div class="stat-block">
            <p><span class="float-left">Certificates earned</span><span class="float-right text-yellow">
                    @if(isset($certificateCount))
                        {{count($certificateCount)}}
                    @else
                        0
                    @endif</span></p>
        </div>
    </div>
    @if($user_info->id == Auth::id())
    <hr class="my-5">

    <p class="my-3 balance"><span class="float-left">Current Balance</span> <span class="float-right text-white">{{ round($user_info->balance, 2) }} Tk.</span></p>
    <p class="my-3 balance"><span class="float-left">Total Earnings</span> <span class="float-right text-white">{{ $earnings }} Tk.</span></p>
    <div class="desposit-withdraw-buttons">
        <a href="{{route('deposit.form')}}" class=" btn btn-success float-left">Deposit</a>
        <a href="{{route('withdraw.form')}}" class=" btn btn-danger float-right">Withdraw</a>
    </div>
    @endif

</div>
