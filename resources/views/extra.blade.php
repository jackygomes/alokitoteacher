 @extends('master')
@section('content')
    <style>
        #sidebar {
            padding: 10px;
            background-color: #fff !important;
        }
        #sidebar .list-group-flush .ItemButton img {
            width: 14%;
        }
        #sidebar .list-group-flush .ItemButton span {
            width: 84%;
            float: right;
        }
        #sidebar .list-group-flush .active-course-tab {
            box-shadow: none;
            background-color: #532436 !important;
            color: #fff !important;
            border-radius: 10px;
        }
        #sidebar .list-group-flush .active-video-icon{
            display: none;
        }
        #sidebar .list-group-flush .active-course-tab .active-video-icon{
            display: initial;
        }
        #sidebar .list-group-flush .active-course-tab .inactive-video-icon{
            display: none;
        }
        #sidebar .list-group-flush .list-group-item {
            border:none;
        }
        .video-content-text {
            padding: 30px 0;
        }
    </style>
<div class="container-fluid" style="min-height: 90vh">
    <div class="row">

        <div id="sidebarCol" class="col-md-3" style="padding-left: 0 !important; min-height: 90vh;overflow-y: auto;">
            <div id="sidebar" class="background-yellow" style="min-height: 100%">

                <div class="list-group list-group-flush">
                    @foreach($contents as $content)
                    @if($content->type == 1)
                    <button  content="{{ $content->type }}" sequence="{{ $content->sequence }}" value="{{ $content->id }}" class="list-group-item list-group-item-action bg-light disable-click ItemButton"><img class="active-video-icon" src="{{asset('images/new_design/video-play-active.png')}}"><img class="inactive-video-icon" src="{{asset('images/new_design/video-play-inactive.png')}}"><span>{{ $content->title }}</span></button>

                    @elseif($content->type == 2)
                    <button content="{{ $content->type }}" sequence="{{ $content->sequence }}" value="{{ $content->id }}" class="list-group-item list-group-item-action bg-light disable-click ItemButton"> <i class="float-left fas fa-book " style="font-size:30px;"></i><span>{{ $content->title }}</span></button>

                    @else
                    <button content="{{ $content->type }}" sequence="{{ $content->sequence }}" value="{{ $content->id }}" class="list-group-item list-group-item-action bg-light disable-click ItemButton"><img src="{{asset('images/new_design/quiz.png')}}"><span>{{ $content->title }}</span></button>

                    @endif


                    @endforeach

                </div>
            </div>
       </div>

        <div id="contentCol" class="col-md-7">
            <div>
                <a href="#" class="p-2 btn"><i class="fas fa-long-arrow-alt-left"></i> Back to Courses</a>
            </div>
            <div id="content">


            </div>
        </div>
        <div class="col-md-2">
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
            <div>
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Vertical Ad -->
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="ca-pub-1285809732280483"
                    data-ad-slot="5919406206"
                    data-ad-format="auto"
                    data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>

    </div>
</div>
<hr>


<!-- Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Enrollment</h5>

      </div>
      <div class="modal-body">
        You will have to enroll first to take this course and you can retake after 30 days of finishing the course. Are you sure that you want to enroll?
      </div>
      <div class="modal-footer">
        <button type="button" id="enrollConfirm" data-dismiss="modal" class="btn btn-success float-left">Yes</button>
        <a class="btn btn-danger float-right" href="{{ url('all') }}">No</a>
      </div>
    </div>
  </div>
</div>


<!-- rating -->
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rate This Course</h5>

      </div>
      <div class="modal-body text-center">
        <form method="POST" action="{{ url('rate_a_course') }}">
            {{csrf_field()}}
            <input type="hidden" name="course_toolkit" value="{{ Request::segment(2) }}">
            <input type="hidden" name="slug" value="{{ Request::segment(3) }}">

            <label for="">Comprehensibility</label>
            <div class="rating comprehensibility mb-3">
              <label>
                <input type="radio" name="comprehensibilityRating" class="d-none" value="5" title="5 stars" required>
              </label>
              <label>
                <input type="radio" name="comprehensibilityRating" class="d-none" value="4" title="4 stars">
              </label>
              <label>
                <input type="radio" name="comprehensibilityRating" class="d-none" value="3" title="3 stars">
              </label>
              <label>
                <input type="radio" name="comprehensibilityRating" class="d-none" value="2" title="2 stars">
              </label>
              <label>
                <input type="radio" name="comprehensibilityRating" class="d-none" value="1" title="1 star">
              </label>
            </div>

            <label for="">Creativity</label>
            <div class="rating creativity mb-3">
                <label>
                    <input type="radio" name="creativityRating" class="d-none" value="5" title="5 stars" required>
                </label>
                <label>
                    <input type="radio" name="creativityRating" class="d-none" value="4" title="4 stars">
                </label>
                <label>
                    <input type="radio" name="creativityRating" class="d-none" value="3" title="3 stars">
                </label>
                <label>
                    <input type="radio" name="creativityRating" class="d-none" value="2" title="2 stars">
                </label>
                <label>
                    <input type="radio" name="creativityRating" class="d-none" value="1" title="1 star">
                </label>
            </div>

            <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white">Submit</button>
        </form>

      </div>

    </div>
  </div>
</div>


<!-- retake -->
<div class="modal fade" id="retakeModal" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLongTitle">Want to retake this course?</h5>

      </div>
      <div class="modal-body text-center">
        All of your previous scores of this course will be replaced with new scores.

      </div>
      <div class="modal-footer">
        <button type="button" id="retakeConfirm" data-dismiss="modal" class="btn btn-success float-left">Yes</button>
        <a class="btn btn-danger float-right" href="{{ url('all') }}">No</a>
      </div>
    </div>
  </div>
</div>

<!-- retake -->
<div class="modal fade" id="cannotRetakeModal" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLongTitle">Sorry!</h5>

      </div>
      <div class="modal-body text-center">
        You can not retake this Course.

      </div>
      <div class="modal-footer">
        <a class="btn background-yellow float-right" href="{{ url('all') }}">See All Courses</a>
      </div>
    </div>
  </div>
</div>







    @push('js')

    <script src="https://player.vimeo.com/api/player.js"></script>
    <script src="http://www.youtube.com/player_api"></script>

    <script type="text/javascript">


        $(document).ready(function () {

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');

                if($('#sidebarCol').hasClass('col-md-3')){
                    $('#sidebarCol').removeClass('col-md-3');
                }else{
                    $('#sidebarCol').addClass('col-md-3');
                }

                if($('#contentCol').hasClass('col-md-9')){
                    $('#contentCol').addClass('col-md-12').removeClass('col-md-9');

                }else{
                    $('#contentCol').addClass('col-md-9').removeClass('col-md-12');
                }

            });


            var setTimer;

            if($('#content').text().trim().length == 0){
                verifyTrackHistory();
            }



            function loadContent(id, type){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  jQuery.ajax({
                    url: "{{ url('/load_content') }}",
                    method: 'POST',
                    data: {
                       id: id,
                       type: type,
                       course_toolkit: '{{ Request::segment(2) }}',
                    },
                    success: function(result){

                        if(type == 1){
                            if(result.url.includes("youtube")){
                                $('#content').html('<div class="embed-responsive  embed-responsive-16by9 "><div id="videoPlayer" data-url="'+result.url+'"></div></div><div class="video-content-text"><h3 class="text-center font-weight-bold mt-2">'+result.video_title+'</h3><p class="mt-3 text-center mb-3">'+result.short_description+'</p></div>');
                            }else {
                                $('#content').html('<div class="embed-responsive  embed-responsive-16by9 "><iframe src="'+result.url+'" width="1150" height="650" frameborder="0" allow="autoplay;   fullscreen" allowfullscreen></iframe></div><div class="video-content-text"><h3 class="text-center font-weight-bold mt-2">'+result.video_title+'</h3><p class="mt-3 text-center mb-3">'+result.short_description+'</p></div>');
                            }
                            videoControl();
                        }else if(type == 2){
                            $('#content').html('<object style="height: 80vh" width="100%" data="'+result.doc_url+'"><p>Document</p></object><button class="btn background-yellow px-4 py-2 mt-5 shadow font-weight-bold text-white" id="nextSequence">Go to Next</button>');
                        }else{
                            $('#content').html(result.html);
                            loadQuestion(id, parseInt($('#serial-question').text())-1);
                        }
                    }
                });
            }


            function loadQuestion(quiz_id, serial){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  jQuery.ajax({
                    url: "{{ url('/load_question') }}",
                    method: 'POST',
                    data: {
                       quiz_id: quiz_id,
                       serial: serial,
                       course_toolkit: '{{ Request::segment(2) }}',
                    },
                    success: function(result){


                        $('#question-query').text(result.question.query);
                        $('#question-query').attr('question_id', result.question.id);
console.log(result.options);
                        if(result.options.length == 0){
                            $('#option-section').html('<div class="form-row mt-1"><div class="col-md-12 mb-5"><input type="text" class="form-control border-yellow"  required  placeholder="Your Answer" autofocus></div></div>');
                        }else{
                            $('#option-section').empty();
                            $.each(result.options, function(key,value){
                                $('#option-section').append('<div class="custom-control custom-radio"><input type="radio" value='+(key+1)+' id="radio'+value.id+'" name="radio" class="custom-control-input"><label class="custom-control-label" for="radio'+value.id+'">'+value.question_option+'</label></div><hr>');

                            });

                        }

                        startTimer(120, $('#timer'));
                    }
                });
            }


            function loadResult(quiz_id){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  jQuery.ajax({
                    url: "{{ url('/load_result') }}",
                    method: 'POST',
                    data: {
                       quiz_id: quiz_id,
                       course_toolkit: '{{ Request::segment(2) }}',
                    },
                    success: function(result){

                        $('#content').empty();
                        $('#content').html(result.html);
                        updateTrackHistory(0);
                    }
                });
            }


            function verifyQuestion(question_id, correct_option, time){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  jQuery.ajax({
                    url: "{{ url('/verify_question') }}",
                    method: 'POST',
                    data: {
                       question_id: question_id,
                       course_toolkit: '{{ Request::segment(2) }}',
                       correct_option: correct_option,
                       time: time,
                    },

                });
            }


            $(document).on("click", '#quizButton', function(event) {
               pressNextButton();
            });

            function pressNextButton(){
                clearInterval(setTimer);
                verifyQuestion($('#question-query').attr('question_id'), $('input[name=radio]:checked').val(), $('#timer').text());

                if($('#quizButton').text() == "Finish"){
                    setTimeout(loadResult, 2000, $('#quiz_id').attr('content'));

                }else{
                    loadQuestion($('#quiz_id').attr('content'), parseInt($('#serial-question').text()));
                    if($('#serial-question').text() < $('#serial-limit').text()){
                        $('#serial-question').text(parseInt($('#serial-question').text())+1);
                    }

                    if($('#serial-question').text() == $('#serial-limit').text()){
                        $('#quizButton').text('Finish');
                    }
                }

            }

            function finishTimeUpdate(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/course_toolkit_complete_update') }}",
                    method: 'POST',
                    data: {
                        slug: '{{ Request::segment(3) }}',
                        course_toolkit: '{{ Request::segment(2) }}',
                    },
                    success: function(result) {
//                        console.log(result);
                    }
                })
            }


            function startTimer(duration, display) {
                var timer = duration, minutes, seconds;
                setTimer = setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    if(minutes == 0 && seconds == 0){
                        pressNextButton();
                    }

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.text(minutes + ":" + seconds);

                    if (--timer < 0) {
                        timer = duration;
                    }

                }, 1000);
            }

            // when video ends
            function onPlayerStateChange(event) {
                if(event.data === 0) {
                    updateTrackHistory(1);
                }
            }
            function videoControl(){
                if($('#videoPlayer').data('url')){
                    var videoId = $('#videoPlayer').data('url').split('/');
                    var player = new YT.Player('videoPlayer', {
                        videoId: videoId[4],
                        events: {
                            onStateChange: onPlayerStateChange
                        }
                    });
                }
                if($('iframe').length > 0) {
                    var iframe = document.querySelector('iframe');
                    var player = new Vimeo.Player(iframe);

                    player.on('ended', function(data) {
                        updateTrackHistory(1);
                    });
                }
            }

            function verifyTrackHistory(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  jQuery.ajax({
                    url: "{{ url('/verify_track_history') }}",
                    method: 'POST',
                    data: {
                       slug: '{{ Request::segment(3) }}',
                       course_toolkit: '{{ Request::segment(2) }}',
                    },
                    success: function(result){

                        if(result.status == 'success'){
                            var button = $('button[sequence="'+(parseInt(result.sequence)+1)+'"]');
                            if(button.length == 0){

                                // course or toolkit end point
                                finishTimeUpdate();

                              if(result.retake <= 0){
                                if('{{ Request::segment(2) }}' == 'c'){
                                  $('#retakeModal').modal('show');
                                }else{
                                  $('#cannotRetakeModal').modal('show');
                                }
                              }else{
                                  if(result.existRating < 1){
                                      $('#ratingModal').modal('show');
                                  } else {
                                      $('#cannotRetakeModal').modal('show');
                                  }
                              }

                            }else{
                                $('.ItemButton').removeClass('active-course-tab');
                                button.addClass('active-course-tab');
                                loadContent(button.val(), button.attr('content'));
                            }
                        }else if(result.status == 'enroll'){
                            //$('#enrollModal').modal('show')
                        }
                    }

                });

            }

            function updateTrackHistory(loadNext){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  jQuery.ajax({
                    url: "{{ url('/update_track_history') }}",
                    method: 'POST',
                    data: {
                       slug: '{{ Request::segment(3) }}',
                       course_toolkit: '{{ Request::segment(2) }}',
                    },
                    success: function(result){

                        if(result == 'success' && loadNext == 1){
                            verifyTrackHistory();
                        }
                    }

                });

            }

            $(document).on("click", '#nextSequence', function(event) {
               verifyTrackHistory();
            });

            // $(document).on("click", '#enrollConfirm', function(event) {
            //    enrollIntoCourse();
            // });

            // function enrollIntoCourse(){
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //       });
            //       jQuery.ajax({
            //         url: "{{ url('/enroll_into_course') }}",
            //         method: 'POST',
            //         data: {
            //            slug: '{{ Request::segment(3) }}',
            //            course_toolkit: '{{ Request::segment(2) }}',
            //         },
            //         success: function(result){

            //             if(result == 'success'){
            //                 verifyTrackHistory();
            //             }
            //         }

            //     });

            // }

            $('.rating.comprehensibility input').change(function () {
              var $radio = $(this);
              $('.rating.comprehensibility .selected').removeClass('selected');
              $radio.closest('label').addClass('selected');
            });
            $('.rating.creativity input').change(function () {
                var $radio = $(this);
                $('.rating.creativity .selected').removeClass('selected');
                $radio.closest('label').addClass('selected');
            });

            $(document).on("click", '#retakeConfirm', function(event) {
               retakeCourse();
            });

            function retakeCourse(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  jQuery.ajax({
                    url: "{{ url('/retake_course') }}",
                    method: 'POST',
                    data: {
                       slug: '{{ Request::segment(3) }}',
                       course_toolkit: '{{ Request::segment(2) }}',
                    },
                    success: function(result){

                        if(result == 'success'){
                            verifyTrackHistory();
                        }
                    }

                });

            }


        });

    </script>

    @endpush

  @endsection
