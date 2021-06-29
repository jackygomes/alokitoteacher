@extends('layouts.master-dashboard')
@section('content')


<div class="container-fluid dashboard-bg">

    <div class="row">
        @include('includes.dashboard.teacher')
        <div class="col-md-7 col-sm-12 pt-5">

{{--    @if($user_info->id == Auth::id())--}}
{{--    <div class="col-md-7 col-sm-12 mt-5">--}}
{{--    @else--}}
{{--    <div class="col-md-9 col-sm-12 mt-5">--}}
{{--    @endif--}}
      <div class="container-fluid ">

        <div class="row">
          <div class="col-md-12">
              <a href="{{route('teacher.job.list')}}" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">
                  Job Application
              </a>
          </div>
        </div>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @if(session()->has('danger'))
            <div class="alert alert-danger">
                {{ session()->get('danger') }}
            </div>
        @endif


        <div class="row dashboard-content-block">
          <div class="col-sm-12 mt-2">
          <h3 class="font-weight-bold mt-2 mb-5" >Achievements</h3>

            {{--
            {{Auth::id()}}
            <pre>
            @foreach ($progresses as $progress)
            {{print_r($progress)}}
            @endforeach
            </pre>
            --}}



            @php
            $no_achievement = true;
            @endphp

            @foreach ($achievements as $achievement)

            @if($achievement->total_quizzes != 0 && $achievement->completed_quizzes != 0)
            {{--<pre>{{print_r($achievement)}}</pre> --}}
            @php
            $no_achievement = false;
              $percentage = round((($achievement->gained_points/($achievement->total_questions * 2)) * 100), 1);
            @endphp
            <div style="margin: 10px 0;">
	            <i class="fas fa-medal fa-2x mr-2" style=" color:
                @if($percentage >= 85)
	            #d4af37;
	            @elseif($percentage >= 70 && $percentage <= 84)
	            #aaa9ad;
	            @elseif($percentage >= 60 && $percentage <= 69)
	            #cd7f32;
	            @elseif($percentage >= 50 && $percentage <= 59)
	            #00a74a;
	            @else
	            #ff4f4f;
	            @endif
	            ">

	            </i>
	            <h5 style="display: inline-block">{{ $achievement->title }} - Average Score ({{$percentage}}%)
                    @if($user_info->id == Auth::id())
                        @if($percentage >= 50)
                            <a href="{{route('certificate', $achievement->id)}}" class="btn background-yellow text-right ml-2 px-4 py-2 shadow font-weight-bold text-white">
                                Get Certificate
                            </a>
                        @endif
                    @endif
                </h5>
            </div>
            @endif
            @endforeach

            @if($no_achievement == true)
            <h5 class="text-center text-muted">No Achievements to Show</h5>
            @endif

          </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row dashboard-content-block">
          <div class="col-md-12">
          <h3 class="font-weight-bold mr-3 pt-3 pb-2" style="display: inline-block">My Innovations</h3>
          <a href="{{route('resource.create')}}"><span class="fa-clickable"><i class="fas fa-pen"></i> <small>Add</small></span></a>
            <div id="exploreResource" class="owl-carousel card-slider">
                @foreach ($resources as $resource)
                    <div class="item mt-3 mb-5">
                        <a href="{{ url('overview') }}/r/{{$resource->slug}}">
                            <div class="card">
                                <img src="{{url('images\thumbnail')}}\{{ $resource->thumbnail }}" style="height: 262px;" class="card-img-top">
                                <div class="card-body">
                                    @if(strlen($resource->resource_title) < 26)
                                        <p class="card-title text-dark font-weight-bold mb-0" style="font-size: 20px">{{ str_limit(strip_tags($resource->resource_title), 26) }}</p>
                                    @else
                                        <div class="ticker-wrap">
                                            <div class="ticker">
                                                <div class="ticker__item card-title text-dark font-weight-bold mb-0">
                                                    {{$resource->resource_title}}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="text-dark">
{{--                                        @for($i = 1; $i <= 5; $i++)--}}
{{--                                            @if($resources->rating - $i >= 0)--}}
{{--                                                <i class="fa fa-star checked-yellow" aria-hidden="true"></i>--}}
{{--                                            @else--}}
{{--                                                <i class="far fa-star text-light-dark"></i>--}}
{{--                                            @endif--}}
{{--                                        @endfor--}}
                                      <span class="text-success font-weight-bold">
                                      @if($resource->isBought == 1)
                                              Owned
                                          @else
                                              @if($resource->price == 0)
                                                  Free
                                              @else
                                                  {{ round($resource->price, 2)}} BDT
                                              @endif
                                          @endif
                                        </span>
                                      </div>
                                      <div >
                                      <hr>
                                        <form id="resourceDeleteForm_{{$resource->id}}" action="{{ route('resource.delete', ['id' => $resource->id]) }}" method="post">
                                            <a href="{{route('resource.edit',$resource->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
                                            <input class="btn btn-danger btn-sm" onclick="resourceDeleteConfirm({{$resource->id}})" type="button" value="Remove" />
                                            <input class="btn btn-danger btn-sm" style="display: none" type="submit" value="Remove" />
                                            @method('delete')
                                            @csrf
                                        </form>
                                      </div>

                                </div>
                            </div>
                        </a>
                    </div>
                  @endforeach
              </div>
          </div>
          </div>
        </div>



      @if($user_info->id == Auth::id())
      @php
      $no_progress = true;
      @endphp
      <div class="container-fluid mt-5">
        <div class="row dashboard-content-block">
          <div class="col-sm-12">
              <h3 class="font-weight-bold mt-5" >Course Learning Progress</h3>
                <div class="table-responsive-sm">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th style="width:40%">Course</th>
                        <th style="width:40%">Progress</th>
                        <!-- <th style="width:10%">Current Grade</th> -->
                        <th style="width:20%">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($progresses as $progress)

                        @if($progress->completed_quizzes != 0 && $progress->total_quizzes != 0)

                        @php
                        $no_progress = false;
                        @endphp
                        <tr>
                          <td>{{ $progress->title }}</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar background-yellow" style="width: {{ round((($progress->completed_quizzes/$progress->total_quizzes)*100), 1) }}%;">{{ round((($progress->completed_quizzes/$progress->total_quizzes)*100), 1) }}%
                              </div>
                            </div>

                          </td>
                         <!--  <td>{{ ($progress->completed_quizzes/$progress->total_quizzes)*100 }}%</td> -->
                          <td>{{ date("jS F, Y", strtotime($progress->updated_at)) }}</td>
                        </tr>
                        @endif
                        @endforeach



                    </tbody>
                  </table>

                  @if($no_progress == true)
                  <h5 class="text-center text-muted">No Progress to Show</h5>
                  @endif

                </div>
            </div>
          </div>
      </div>
      @endif




          <div class="container-fluid">
            <div class="row dashboard-content-block">
                <div class=" mt-5 col-sm-12">
                   <h3 class="font-weight-bold mr-3" style="display: inline-block">Work Expereince</h3>
                   @if($user_info->id == Auth::id())
                   <span class="fa-clickable" data-toggle="modal" data-target="#workExperience"><i class="fas fa-pen" ></i> <small>Add</small></span>
                   @endif
                    <div class="mr=2">
                      <div class="table-responsive-sm">
                        <table class="table ">
                          <thead>
                            <tr>
                              <th style="width:20%">Institute</th>
                              <th style="width:10%">Position</th>
                              <th style="width:20%">From</th>
                              <th style="width:20%">To</th>
                              @if($user_info->id == Auth::id())
                               <th style="width:10%">Action</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach ($work_info as $work)
                            <tr>
                              <td>{{$work->institute}}</td>
                              <td>{{$work->position}}</td>
                              <td>{{ date("jS F, Y", strtotime($work->from_date)) }}</td>
                              <td>{{ $work->to_date == '0000-00-00'? 'Currently Working' : date("jS F, Y", strtotime($work->to_date)) }}</td>
                              @if($user_info->id == Auth::id())
                              <td><a href="{{ url('remove') }}/work_experience/{{ $work->id }}" class="btn btn-danger btn-sm">Remove</a></td>
                              @endif
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        @if($work_info->count() == 0)
                          <h5 class="text-center text-muted">No Work Experience to Show</h5>
                        @endif
                       </div>
                    </div>
              </div>
            </div>
          </div>



        <div class="container-fluid">
          <div class="row dashboard-content-block">

            <div class="col-sm-12">

                <h3 class="font-weight-bold mt-5 mr-3" style="display: inline-block">Academics</h3>

                @if($user_info->id == Auth::id())
                <span class="fa-clickable" data-toggle="modal" data-target="#academics"><i class="fas fa-pen" ></i> <small>Add</small></span>
                @endif

                <div class="mr=2">
                    <div class="table-responsive-sm">
                    <table class="table ">
                      <thead>
                        <tr>
                          <th style="width:15%">Academic</th>
                          {{--<th style="width:15%">Result</th>--}}
                          <th style="width:20%">Institute</th>
                          <th style="width:10%">Passing Year</th>
                          <th style="width:10%">CGPA/GPA</th>
{{--                          <th style="width:20%">Date</th>--}}
                          @if($user_info->id == Auth::id())
                           <th style="width:10%">Action</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                         @foreach ($academic_info as $academic_info)
                        <tr>

                          <td>
                            <p>{{$academic_info->academic}}</p>
                            @if($academic_info->academic_details != null) <p><b>Details: </b>{{ $academic_info->academic_details }}</p> @else - @endif

                          </td>
                          {{--<td>
                            <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{$academic_info->result}}%; background-color:#FE980F" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$academic_info->result}}%</div>
                                </div>

                                    </td>--}}
                                    <td>{{$academic_info->institute}}</td>
                                    <td>
                                        @if(strlen($academic_info->passing_year) > 4)
                                            {{ date("Y", strtotime($academic_info->passing_year)) }}
                                        @else
                                            {{$academic_info->passing_year}}
                                        @endif
                                    </td>
                                    <td>{{$academic_info->cgpa}}</td>
{{--                                    <td>{{ date("jS F, Y", strtotime($academic_info->date)) }}</td>--}}

                                    @if($user_info->id == Auth::id())
                                    <td><a href="{{ url('remove') }}/academic/{{ $academic_info->id }}" class="btn btn-danger btn-sm">Remove</a></td>
                                    @endif

                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              @if($academic_info->count() == 0)
                                <h5 class="text-center text-muted">No Academic Info to Show</h5>
                              @endif
                      </div>
              </div>
            </div>
          </div>
        </div>


{{--      <div class="container-fluid">--}}
{{--        <div class="row dashboard-content-block">--}}
{{--          <div class="col-sm-12">--}}
{{--            <h3 class="font-weight-bold mt-5" style="display: inline-block">Subject Based Knowledge</h3>--}}
{{--            <div class="mr=2">--}}
{{--              <div class="table-responsive-sm">--}}
{{--                <table class="table score-table">--}}
{{--                  <thead>--}}
{{--                    <tr>--}}
{{--                      <th style="width:20%">Subject</th>--}}
{{--                      <th style="width:40%">Toolkit</th>--}}
{{--                      <th style="width:10%">Score</th>--}}
{{--                      <th style="width:10%">Average Score</th>--}}
{{--                      <!-- <th style="width:20%">Date</th> -->--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @php $i = 0; $subject = '' ; @endphp--}}
{{--                      @foreach ($course_knowledges as $course_knowledge)--}}
{{--                    @php--}}
{{--                        if($subject !== $course_knowledge->subject_name){--}}
{{--                            $i++;--}}
{{--                        }--}}
{{--                     $class = "same_subject". $i ;--}}
{{--                    @endphp--}}
{{--                      <tr class="subject {{$class}}" >--}}
{{--                        <td>{{ $course_knowledge->subject_name }}</td>--}}
{{--                        <td>--}}
{{--                         {{$course_knowledge->toolkit_title}}--}}
{{--                        </td>--}}
{{--                        <td>{{$course_knowledge->totalPoints}}</td>--}}
{{--                        <td> </td>--}}


{{--                      </tr>--}}
{{--                      @php $subject = $course_knowledge->subject_name ; @endphp--}}
{{--                      @endforeach--}}

{{--                    </tbody>--}}
{{--                </table>--}}
{{--                @if($course_knowledges == null)--}}

{{--                  <h5 class="text-center text-muted">No Subject Based Knowledge to Show</h5>--}}
{{--                @endif--}}
{{--              </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}



{{--        <div class="container-fluid mb-5">--}}
{{--          <div class="row dashboard-content-block">--}}

{{--            <div class="col-sm-12">--}}
{{--              <h3 class="font-weight-bold mt-5 mr-3" style="display: inline-block">Skills</h3>--}}
{{--              @if($user_info->id == Auth::id())--}}
{{--              <span class="fa-clickable" data-toggle="modal" data-target="#skills"><i class="fas fa-pen" ></i> <small>Add</small></span>--}}
{{--              @endif--}}
{{--                <div class="mr=2">--}}
{{--                    <div class="table-responsive-sm">--}}
{{--                        <table class="table ">--}}
{{--                          <thead>--}}
{{--                            <tr>--}}
{{--                              <th style="width:15%">Training Title</th>--}}
{{--                              <th style="width:15%">Topic</th>--}}
{{--                              <th style="width:15%">Institute</th>--}}
{{--                              <th style="width:15%">Country</th>--}}
{{--                              <th style="width:15%">Location</th>--}}
{{--                              <th style="width:5%">Year</th>--}}
{{--                              <th style="width:10%">Duration (days)</th>--}}
{{--                              @if($user_info->id == Auth::id())--}}
{{--                              <th style="width:10%">Action</th>--}}
{{--                              @endif--}}

{{--                            </tr>--}}
{{--                          </thead>--}}
{{--                          <tbody>--}}
{{--                            @foreach ($skill_info as $v_skill_info)--}}
{{--                            <tr>--}}
{{--                              <td>{{$v_skill_info->training_title}}</td>--}}
{{--                              <td>{{$v_skill_info->institute}}</td>--}}
{{--                              <td>{{$v_skill_info->country}}</td>--}}
{{--                              <td>{{$v_skill_info->location}}</td>--}}
{{--                              <td>--}}
{{--                                  @if(strlen($v_skill_info->year) > 4)--}}
{{--                                      {{ date("Y", strtotime($v_skill_info->year)) }}--}}
{{--                                  @else--}}
{{--                                      {{$v_skill_info->year}}--}}
{{--                                  @endif--}}
{{--                              </td>--}}
{{--                              <td>{{$v_skill_info->duration}}</td>--}}

{{--                              @if($user_info->id == Auth::id())--}}
{{--                              <td><a href="{{ url('remove') }}/skill/{{ $v_skill_info->id }}" class="btn btn-danger btn-sm">Remove</a></td>--}}
{{--                              @endif--}}

{{--                            </tr>--}}
{{--                             @endforeach--}}
{{--                          </tbody>--}}
{{--                          </table>--}}

{{--                          @if($skill_info->count() == 0)--}}
{{--                            <h5 class="text-center text-muted">No Skill to Show</h5>--}}
{{--                          @endif--}}

{{--                      </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}


      </div> <!-- 2nd col ends here -->

        @if($user_info->id == Auth::id())
            <div class="col-md-3">
                @include('leaderboard')
                <div class="advertise">
                  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                  <!-- Square Ad -->
                  <ins class="adsbygoogle"
                      style="display:block"
                      data-ad-client="ca-pub-1285809732280483"
                      data-ad-slot="7288328197"
                      data-ad-format="auto"
                      data-full-width-responsive="true"></ins>
                  <script>
                      (adsbygoogle = window.adsbygoogle || []).push({});
                  </script>
                </div>
            </div>
        @endif





   </div><!-- row ends here -->




</div>



<!-- Add work experience Modal -->
<div class="modal fade" id="workExperience" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title">Add Work Experience</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >

        <form method="POST" action="{{ url('add_work_experience') }}">
           {{csrf_field()}}
          <div class="form-group">
            <input type="text" class="form-control border-yellow" name="institute" placeholder="Name of the institute" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control border-yellow" name="position" placeholder="Your position there" required>
          </div>
          <div class="form-group row">
            <div class="col-6">
              <label>From</label>
              <input type="text" class="datepicker form-control border-yellow" name="from" placeholder="Starting Date" required>
            </div>
            <div class="col-6">
              <label>To</label>
              <input type="text" class="datepicker form-control border-yellow" id="work_end" name="to" placeholder="Ending Date" required>
              <small>
                  <div class="form-check">
                  <input type="checkbox" class="form-check-input" name="current_check" id="currently_working">
                  <label class="form-check-label" for="currently_working">Currently working here</label>
                </div>
              </small>
            </div>

          </div>

          <div class="form-group">
            <textarea class="form-control border-yellow" rows="10"  name="description" placeholder="Write description about your job responsibilities"></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn background-yellow">Add</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- Add Academics Modal -->
<div class="modal fade" id="academics" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title">Add Academics</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >

        <form method="POST" action="{{ url('add_academics') }}">
           {{csrf_field()}}
          <div class="form-group">
            <label>Institute:</label>
            <input type="text" class="form-control border-yellow" name="institute" placeholder="Name of the institute" required>
          </div>
          <div class="form-group">
            <label>Passing Year:</label>
            <input type="text" class="yearDatepicker form-control border-yellow" name="passing_year" placeholder="Passing Year" required/>
          </div>
          <div class="form-group row">
            <!-- <div class="col-6">
              <label>Exam Type:</label>
              <select class="form-control border-yellow" name="exam_type" required>
                <option value="" disabled selected>-- Select Exam Type --</option>
                <option value="O Level">O Level</option>
                <option value="A Level">A Level</option>
              </select>
            </div> -->
            <div class="col-12">
              <label>Result:</label>
              <input type="text" class="form-control border-yellow" step="0.01" min="0" max="5" name="cgpa" placeholder="CGPA/GPA" required>

            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12">
              <label>Academic Area:</label>
            </div>
            <div class="col-12">
              <select class="form-control border-yellow" name="academic" required>
                <option value="" disabled selected>-- Select Academic Area --</option>
                <option value="Ordinary Level">Ordinary Level</option>
                <option value="Secondary School Certificate">Secondary School Certificate</option>
                <option value="Dakhil">Dakhil</option>
                <option value="Advanced Level">Advanced Level</option>
                <option value="Higher Secondary School Certificate">Higher Secondary School Certificate</option>
                <option value="Alim">Alim</option>
                <option value="Bachelor">Bachelor</option>
                <option value="Master">Master</option>
                <option value="PHD">PHD</option>
                <option value="Others">Others</option>
              </select>
            </div>
            </div>
            <div class="form-group row">
            <div class="col-12">
              <textarea style="width: 100%;border-color: #f5b82f!important;" name="academic_details" placeholder="Academic Details" required></textarea>
            </div>
            </div>
          <div class="text-center">
            <button type="submit" class="btn background-yellow">Add</button>
          </div>


        </form>



      </div>

    </div>
  </div>
</div>

<!-- Add skills Modal -->
<div class="modal fade" id="skills" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title">Add Skills</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >

        <form method="POST" action="{{ url('add_skills') }}">
           {{csrf_field()}}

           <div class="form-group">
            <label>Training Title:</label>
            <input type="text" class="form-control border-yellow" name="training_title" placeholder="Write Trainig Title" required>
          </div>
          <div class="form-group">
            <label>Topic:</label>
            <input type="text" class="form-control border-yellow" name="topic" placeholder="Write Topic" required>
          </div>
          <div class="form-group">
            <label>Institute:</label>
            <input type="text" class="form-control border-yellow" name="institute" placeholder="Write the name of institute" required>
          </div>
          <div class="form-group">
            <label>Country:</label>
            <input type="text" class="form-control border-yellow" name="country" placeholder="Country" required>
          </div>
          <div class="form-group">
            <label>Location:</label>
            <input type="text" class="form-control border-yellow" name="location" placeholder="Located of the office" required>
          </div>
          <div class="form-group row">
            <div class="col-6">
              <label>Year:</label>
            <input type="text" class="yearDatepicker form-control border-yellow" name="year" placeholder="Passing Year" required/>
            </div>
            <div class="col-6">
              <label>Duration (Days):</label>
              <input type="text" class="form-control border-yellow" name="duration" placeholder="Duration" required>
            </div>
          </div>


          <div class="text-center">
            <button type="submit" class="btn background-yellow">Add</button>
          </div>


        </form>



      </div>

    </div>
  </div>
</div>


 @push('js')

    <script type="text/javascript">
        $('#exploreResource').owlCarousel({
            loop:false,
            margin:30,
            nav:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:3
                }
            }
        });
        $(".yearDatepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
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


    let totalRow =   $(".score-table>tbody>tr").length ;

    for(let i = 1 ; totalRow >= i ; i++){

        let subject =  $(".score-table>tbody>tr.same_subject"+i) ;

        let totalPoint = 0 ;
        let totalSubject =  subject.length;

        subject.each(function(){
            let point = $(this).find('td:nth-child(3)').text() ;
            totalPoint += parseFloat(point) ;
        });

        let score = totalPoint/totalSubject ;

        $(subject).find('td:nth-child(4)').remove() ;
        $(subject[0]).append(`<td style="vertical-align: middle; text-align: center" rowspan="${totalSubject}">${score} </td>`) ;

    }
    function resourceDeleteConfirm(id) {
        Swal.fire({
            icon: 'question',
            title: 'Are you sure to delete?',
            confirmButtonColor: '#f5b82f',
            confirmButtonText: "Yes",
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#resourceDeleteForm_" + id).find('[type="submit"]').trigger('click');
            }
        })
    }

    </script>

@endpush


@endsection
