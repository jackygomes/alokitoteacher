@extends('master')
@section('content')

    <div class="container-fluid" style="min-height: 90vh">
        <div class="row">

            <div id="sidebarCol" class="col-md-3 order-2 order-md-1" style="padding-left: 0 !important; min-height: 90vh;overflow-y: auto;">
                <div id="sidebar" class="background-yellow" style="min-height: 100%">

                    <div class="list-group list-group-flush">
                        @foreach($contents as $content)
                            @if($content->type == 1)
                                <button  type="{{ $content->type }}" id="{{ $content->id }}" class="list-group-item list-group-item-action bg-light disable-click ItemButton">{{ $content->title }} <i class=" float-right fas fa-play-circle text-yellow" style="font-size:30px;"></i></button>

                            @elseif($content->type == 2)
                                <button type="{{ $content->type }}" id="{{ $content->id }}" class="list-group-item list-group-item-action bg-light disable-click ItemButton">{{ $content->title }} <i class="float-right fas fa-book text-yellow " style="font-size:30px;"></i></button>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>

            <div id="contentCol" class="col-md-9 order-1 order-md-2 mt-3">
                <div id="content">

                </div>
            </div>

        </div>
    </div>


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
                    <h5 class="modal-title" id="exampleModalLongTitle">Rate This Couse</h5>

                </div>
                <div class="modal-body text-center">
                    <form method="POST" action="{{ url('rate_a_course') }}">
                        {{csrf_field()}}
                        <input type="hidden" name="course_toolkit" value="{{ Request::segment(2) }}">
                        <input type="hidden" name="slug" value="{{ Request::segment(3) }}">

                        <div class="rating my-5">
                            <label>
                                <input type="radio" name="rating" class="d-none" value="5" title="5 stars" required>
                            </label>
                            <label>
                                <input type="radio" name="rating" class="d-none" value="4" title="4 stars">
                            </label>
                            <label>
                                <input type="radio" name="rating" class="d-none" value="3" title="3 stars">
                            </label>
                            <label>
                                <input type="radio" name="rating" class="d-none" value="2" title="2 stars">
                            </label>
                            <label>
                                <input type="radio" name="rating" class="d-none" value="1" title="1 star">
                            </label>
                        </div>

                        <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white">Submit</button>
                    </form>

                </div>

            </div>
        </div>
    </div>



    @push('js')

        <script src="https://player.vimeo.com/api/player.js"></script>
        <script src="http://www.youtube.com/player_api"></script>

        <script type="text/javascript">


            $(document).ready(function () {

                $('.ItemButton').on('click', function (e) {
                    var id = $(this).attr('id');
                    var type = $(this).attr('type');

                    loadContent(id, type);
                });

                $( ".ItemButton" ).click();


                function loadContent(id, type){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        url: "{{ url('resource/load_content') }}",
                        method: 'POST',
                        data: {
                            id: id,
                            type: type,
                            resource: '{{ Request::segment(2) }}',
                        },
                        success: function(result){
                            console.log(result);
                            if(type == 1){
                                if(result.url.includes("youtube")){
                                    $('#content').html('<div class="embed-responsive  embed-responsive-16by9 "><div id="videoPlayer" data-url="'+result.url+'"></div></div><h3 class="text-center font-weight-bold mt-2">'+result.video_title+'</h3><p class="mt-3 text-center mb-3">'+result.short_description+'</p>');
                                }else {
                                    $('#content').html('<div class="embed-responsive  embed-responsive-16by9 "><iframe src="'+result.url+'" width="1150" height="650" frameborder="0" allow="autoplay;   fullscreen" allowfullscreen></iframe></div><h3 class="text-center font-weight-bold mt-2">'+result.video_title+'</h3><p class="mt-3 text-center mb-3">'+result.short_description+'</p>');
                                }
                                videoControl();
                            }else if(type == 2){
                                let html = "<div><h2>Document</h2>"+
                                    "<p>Download your document file below.</p>" +
                                    "<p>File: "+result.file+"</p>" +
                                    "<a href=/documents/"+result.file+" class='btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white' download>Download</a></div>";
                                $('#content').html(html);
                            }
                        }
                    });
                }

                function videoControl(){
                    if($('#videoPlayer').data('url')){
                        var videoId = $('#videoPlayer').data('url').split('/');
                        var player = new YT.Player('videoPlayer', {
                            videoId: videoId[4],
                            // events: {
                            //     onStateChange: onPlayerStateChange
                            // }
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


            });

        </script>

    @endpush

@endsection
