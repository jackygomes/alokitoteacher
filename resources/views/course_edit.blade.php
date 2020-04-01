@extends('master')
@section('content')
    <style>
        .edit-button {
            border: 1px solid #f5b82f;
            padding: 0px 6px;
            cursor: pointer;
        }
    </style>

    <div class="container-fluid" style="min-height: 90vh">
        <div class="row">

            <div id="sidebarCol" class="col-md-4 order-2 order-md-1"
                 style="padding-left: 0 !important; min-height: 90vh;overflow-y: auto;">
                <div id="sidebar" class="background-yellow" style="min-height: 100%">

                    <div class="list-group list-group-flush">
                        @foreach($contents as $content)
                            @if($content->type == 1)
                                <div content="{{ $content->type }}" sequence="{{ $content->sequence }}"
                                     value="{{ $content->id }}"
                                     class="list-group-item list-group-item-action bg-light ItemButton"><i
                                        class=" float-left fas fa-play-circle text-yellow"
                                        style="font-size:22px;"></i> {{ $content->title }} <span
                                        type="{{ $content->type }}"
                                        id="{{ $content->id }}"
                                        class="edit-button float-right"><i
                                            class="fas fa-edit text-yellow" style="font-size:14px;"></i> edit</span>
                                </div>

                            @elseif($content->type == 2)
                                <div content="{{ $content->type }}" sequence="{{ $content->sequence }}"
                                     value="{{ $content->id }}"
                                     class="list-group-item list-group-item-action bg-light ItemButton"><i
                                        class="float-left fas fa-book text-yellow "
                                        style="font-size:22px;"></i> {{ $content->title }} <span
                                        type="{{ $content->type }}"
                                        id="{{ $content->id }}"
                                        class="edit-button float-right"><i class="fas fa-edit text-yellow"
                                                                           style="font-size:14px;"></i>edit</span>
                                </div>

                            @else
                                <div content="{{ $content->type }}" sequence="{{ $content->sequence }}"
                                     value="{{ $content->id }}"
                                     class="list-group-item list-group-item-action bg-light ItemButton"><i
                                        class="float-left fas fa-question-circle text-yellow "
                                        style="font-size:22px;"></i> {{ $content->title }} <span
                                        type="{{ $content->type }}"
                                        id="{{ $content->id }}"
                                        class="edit-button float-right"><i class="fas fa-edit text-yellow"
                                                                           style="font-size:14px;"></i> edit</span>
                                </div>

                            @endif


                        @endforeach

                    </div>
                </div>
            </div>

            <div id="contentCol" class="col-md-8 order-1 order-md-2 mt-3">
                <div id="content">


                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript">

            // console.log(1);
            // ;(function ($) {
            //     $('.list-group-item').each( function() {
            //         $(this).on('click', function(e) {
            //             console.log(e);
            //         })
            //     });
            //
            //     $('#sidebar').on('click', function(e) {
            //         console.log(1);
            //     });
            // })(jQuery);

            $(document).ready(function () {

                $('.edit-button').on('click', function (e) {
                    var id = $(this).attr('id');
                    var type = $(this).attr('type');

                    loadContent(id, type);
                    // console.log('id '+ id+' {} type'+ type);
                });

                function loadContent(id, type) {
                    // $('#content').html('id = '+id+' type= '+ type)
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        url: "{{ url('admin/load_content') }}",
                        method: 'POST',
                        data: {
                            id: id,
                            type: type,
                            course_toolkit: '{{ Request::segment(2) }}'
                        },
                        success: function (result) {
                            console.log(result);
                            let actionUrl = "{{ route('course.update', ':resultid') }}";
                            actionUrl = actionUrl.replace(":resultid", result.id);


                            if (type == 1) {
                                let formHtml = "<form action='" + actionUrl + "' method='post'>" +
                                    "<input type=\"hidden\" name=\"_token\" value=\"{{csrf_token()}}\">"+
                                    "<div class='form-group'><label>Video Url</label><input name='url' class='form-control' value='" + result.url + "'/></div>" +
                                    "<div class='form-group'><label>Video Title</label><input name='title' class='form-control' value='"+result.video_title+"'/></div>" +
                                    "<div class='form-group'><label>Video Description</label><input name='description' class='form-control' value='"+result.short_description+"'/></div>" +
                                    "<input type='hidden' name='course_id' class='form-control' value='"+result.course_id+"'/>"+
                                    "<button type=\"submit\" class=\"btn btn-primary\">Update</button>" +
                                    "</form>";

                                $('#content').html(formHtml);

                            } else if (type == 2) {
                                $('#content').html('<object style="height: 80vh" width="100%" data="' + result.doc_url + '"><p>Document</p></object><button class="btn background-yellow px-4 py-2 mt-5 shadow font-weight-bold text-white" id="nextSequence">Go to Next</button>');
                            }else{
                                {{--let formHtml = "<form action='" + actionUrl + "' method='post'>" +--}}
                                {{--    "<input type=\"hidden\" name=\"_token\" value=\"{{csrf_token()}}\">"+--}}
                                {{--    result.html+--}}
                                {{--    "</form>";--}}

                                // $('#content').html(formHtml);
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
                        url: "{{ url('admin/load_question') }}",
                        method: 'POST',
                        data: {
                            quiz_id: quiz_id,
                            serial: serial,
                            course_toolkit: '{{ Request::segment(2) }}',
                        },
                        success: function(result){


                            $('#question-query').val(result.question.query);
                            $('#question-query-hidden').val(result.question.id);
                            $('#question-query').attr('question_id', result.question.id);
                            console.log(result.options);
                            if(result.options.length == 0){
                                $('#option-section').html('<div class="form-row mt-1"><div class="col-md-12 mb-5"><input type="text" class="form-control border-yellow"  required  placeholder="Your Answer" autofocus></div></div>');
                            }else{
                                $('#option-section').empty();
                                $.each(result.options, function(key,value){
                                    // $('#option-section').append('<div class="custom-control custom-radio"><input type="radio" value='+(key+1)+' id="radio'+value.id+'" name="radio" class="custom-control-input"><label class="custom-control-label" for="radio'+value.id+'">'+value.question_option+'</label></div><hr>');
                                    $('#option-section').append("<input type='hidden' class='form-control mb-2' name='optionsId[]' value='"+value.id+"'/>");
                                    $('#option-section').append("<input type='text' class='form-control mb-2' name='options[]' value='"+value.question_option+"'/>");

                                });

                            }
                        }
                    });
                }
            });

        </script>
    @endpush

@endsection

