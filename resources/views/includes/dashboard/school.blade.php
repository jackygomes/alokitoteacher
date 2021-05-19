<div class="col-md-3 col-sm-12 pt-5 text-center" style="background-color: #f5b82f;">
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
            @endif

            <h3 class="mt-3 font-weight-bold text-white">{{$user_info->name}}</h3>

            <div class="row text-left p-2 mt-3">

                <div class="col-2">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="col-10">
                    {{ $user_info->location == null ? '-' :  $user_info->location }}
                </div>

                <div class="col-2">
                    <i class="fas fa-book"></i>
                </div>
                <div class="col-10">
                    {{ $user_info->curriculum == null ? '-' :  $user_info->curriculum }}
                </div>

                <div class="col-5 mt-3">
                    Class range:
                </div>
                <div class="col-7  mt-3">
                    {{ $user_info->classes_from == null ? '-' :  $user_info->classes_from }} - {{ $user_info->classes_to == null ? '-' :  $user_info->classes_to }}
                </div>

            </div>

            @if($user_info->id == Auth::id())
            <div class="row text-left p-2 my-3">
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

            <h4>Current Balance </h4>
            <p>৳{{ round($user_info->balance, 2) }}</p>
            <a href="{{route('deposit.form')}}" class=" btn btn-success btn-sm" style="display: inline-block">Deposit</a>
            <a href="{{route('withdraw.form')}}" class=" btn btn-danger btn-sm" style="display: inline-block">Withdraw</a>
            @endif

        </div>