
<div class="home-leaderboard-wrap">
    <div class="home-leaderboard">
        <div class="teachers-toolkits included-leaderboard">
            <h2 class="font-weight-bold mb-5 text-dark pt-5">Leaderboard <small><a class="text-yellow" id="popover" title="How does leaderboard work?" data-content="Leaderboard is based on rating. Rating is calculated based on marks gained in tests of Courses/Toolkits and on rating of teacher's own courses." data-trigger="hover"><i class="fas fa-question-circle"></i></a></small></h2>
            <div class="">
                <div class="">
                    <ul>
                        <li class="topper">
                            <a href="{{ url('t')}}/{{ $leaderBoard[1]['user']->username }}">
                                <div class="serial">1.</div>
                                <div class="image">
                                    @if($leaderBoard[0]['user']->image == null)
                                        <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                                    @else
                                        <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/profile_picture') }}/{{ $leaderBoard[0]['user']->image }}">
                                    @endif
                                    <img class="crown" src="{{asset('images/new_design/crown.png')}}" alt="">
                                </div>
                                <div class="name">{{ $leaderBoard[0]['user']->name }}</div>
                            </a>
                        </li>
                        @foreach ($leaderBoard as $key =>$leader)
                            @if($key > 0)
                                <li>
                                    <a href="{{ url('t')}}/{{ $leader['user']->username }}">
                                        <div class="serial">{{$key + 1}}.</div>
                                        <div class="image">
                                            @if($leader['user']->image == null)
                                                <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/profile_picture') }}/default-profile-picture.png">
                                            @else
                                                <img class="img-fluid rounded-circle" style="max-height: 50px;" src="{{ url('images/profile_picture') }}/{{ $leader['user']->image }}">
                                            @endif
                                        </div>
                                        <div class="name">{{ $leader['user']->name }}</div>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
