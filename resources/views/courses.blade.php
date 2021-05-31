
@extends('master')
@section('content')


<section class="container">
    <div class="row">
        <div class="col-lg-12">
           <h2 class="mt-3 text-center font-weight-bold">Courses</h2>
        </div>
    </div>
</section>


<section>


    <div class="container">

        <div class="row">

            @foreach ($course_info as $v_course_info)
                <div class="col-md-4 mt-5">
                    <a href="{{ url('view') }}/c/{{$v_course_info->slug}}">
                        <div class="card">
                            <img src="{{url('images\thumbnail')}}\{{ $v_course_info->thumbnail }}" style="height: 262px;" class="card-img-top">
                            <div class="card-body">

                                <p class="card-title text-dark font-weight-bold" style="font-size: 19px">{{ str_limit(strip_tags($v_course_info->title), 22) }}</p>
                                <hr>
                                <p class="card-text text-light-dark">Posted By <strong class="text-dark">{{ str_limit(strip_tags($v_course_info->name), 20) }}</strong></p>

                                <div class="text-dark">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($v_course_info->rating - $i >= 0)
                                            <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
                                        @else
                                            <i class="far fa-star text-light-dark"></i>
                                        @endif
                                    @endfor
                                    <span class="float-right text-success font-weight-bold">
                                        @if($v_course_info->isBought == 1)
                                            Owned
                                        @else
                                            @if($v_course_info->price == 0)
                                                Free
                                            @else
                                                {{ round($v_course_info->price, 2)}} BDT
                                            @endif
                                        @endif
                                    </span>
                                </div>

                            </div>
                            {{--                            <div class="card-footer" style="background:--}}
                            {{--                            @if($v_course_info->isBought == 1)--}}
                            {{--                                #98b59d;--}}
                            {{--                            @else--}}
                            {{--                                #51b964;--}}
                            {{--                            @endif--}}
                            {{--                                ">--}}
                            {{--                                <h5 class="text-white text-center">--}}
                            {{--                                    @if($v_course_info->isBought == 1)--}}
                            {{--                                        Owned--}}
                            {{--                                    @else--}}
                            {{--                                        @if($v_course_info->price == 0)--}}
                            {{--                                            Free--}}
                            {{--                                        @else--}}
                            {{--                                            {{ round($v_course_info->price, 2)}} BDT--}}
                            {{--                                        @endif--}}
                            {{--                                    @endif--}}
                            {{--                                </h5>--}}
                            {{--                            </div>--}}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-5">
           {{$course_info->links()}}
         </div>
    </div>
</section>







<!-- The Modal -->
<div class="modal fade" id="myModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="row">
					<div class="col-md-9">
						<div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
						</div>

						<h5 class="mt-3 mb-3">Reviews</h5>



						<div class="">
							<i class="fa fa-star checked" aria-hidden="true"></i>
							<i class="fa fa-star checked" aria-hidden="true"></i>
							<i class="fa fa-star " aria-hidden="true"></i>
							<i class="fa fa-star " aria-hidden="true"></i>

						</div>

						<h5 class="mt-3 mb-3">Reviewer-Review1 <br>Date</h5>



						<div class="">
							<i class="fa fa-star checked" aria-hidden="true"></i>
							<i class="fa fa-star checked" aria-hidden="true"></i>
							<i class="fa fa-star " aria-hidden="true"></i>
							<i class="fa fa-star " aria-hidden="true"></i>

						</div>

					</div>

					<div class="col-md-3 mt-5">
						<div class="text-center">
							<button type="button" class="btn btn-success mb-5 " style="background-color:#e3782f;" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Enroll</button>
						</div>
						<h4>Title</h4>
						<h4>Instructor</h4>
						<h4>Price</h4>
						<h4>Overview</h4>
						<p>Among the wisdom writings of the Old Testament (Job, Proverbs, Ecclesiastes) the book of Job stands with Ecclesiastes as an exploration of the limits and proper uses of conventional, proverbial wisdom.</p>
					</div>
				</div>
			</div>
		</div>

						      <!-- Modal footer

						      <div class="modal-footer">
						        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						    </div>

						just link with modal
								<a href="#" data-toggle="modal" data-target="#myModal"><h5 class="text-white text-center"></h5></a>
						-->

						</div>
					</div>



@endsection










