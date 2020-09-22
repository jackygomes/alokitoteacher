<div class="col-md-2 pt-3" style="border-left: 1px solid #e0e0e0; background-color: #f3f2f0;">

	<h4 class="mb-3 text-center">Leaderboard <small><a class="text-yellow" id="popover" title="How does leaderboard work?" data-content="Leaderboard is based on rating. Rating is calculated based on marks gained in tests of Courses/Toolkits and on rating of teacher's own courses." data-trigger="hover"><i class="fas fa-question-circle"></i></a></small></h4>
	@foreach ($leaderBoard as $key =>$leader)
	<a class="card p-2 mb-2 border-yellow" href="{{ url('t')}}/{{ $leader['user']->username }}">
		<div class="row">
		  	<div class="col-4 my-auto">
		      @if($leader['user']->image == null)
		        <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
		      @else
		        <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/profile_picture') }}/{{ $leader['user']->image }}">
		      @endif
		    </div>
		    <div class="col-6 text-yellow font-weight-bold my-auto" >{{ $leader['user']->name }}</div>

{{--		    <div class="col-2 my-auto" style="padding-right: 0px !important; padding-left: 0px !important;">@if($key <= 2) <i class="fas fa-trophy" style="color: @if($key == 0) #d4af37 @elseif($key == 1) #aaa9ad @elseif($key == 2) #cd7f32 @else #fff @endif"></i>@endif</div>--}}

		</div>
	</a>
	@endforeach

</div>
