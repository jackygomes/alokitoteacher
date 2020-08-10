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
                @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{$message}}
                    </div>
                @endif
                @if($message = Session::get('warning'))
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        @if(count($contents) == 1)
                            @if($contents[0]->type == 1)
                                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuiz">Add Quiz</button>
                                @if($hasQuiz == 1)
                                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuestion">Add Question</button>
                                @endif
                            @elseif($contents[0]->type == 3)
                                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addVideo">Add Video</button>
                                @if($hasQuiz == 1)
                                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuestion">Add Question</button>
                                @endif
                            @else
                                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addVideo">Add Video</button>
                                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuiz">Add Quiz</button>
                                @if($hasQuiz == 1)
                                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuestion">Add Question</button>
                                @endif
                            @endif
                        @elseif(count($contents) <= 0)
                            <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addVideo">Add Video</button>
                            <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuiz">Add Quiz</button>
                            @if($hasQuiz == 1)
                            <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuestion">Add Question</button>
                            @endif
                        @else
                            <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuestion">Add Question</button>
                        @endif
{{--                        <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addVideo">Add Video</button>--}}
{{--                        <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuiz">Add Quiz</button>--}}
{{--                        <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addQuestion">Add Question</button>--}}
                        <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="editToolkit">Edit Toolkit Details</button>
                    </div>
                </div>
{{--                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="editToolkit">Edit Toolkit Details</button>--}}
                <div id="toolkitSection">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Edit Toolkit:</h3>
                        </div>
                    </div>
                    <form action="{{ route('toolkit.update', $toolkitId) }}" method="post" enctype="multipart/form-data" style="width: 100%;">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group row">
                            <label for="toolkitName" class="col-sm-2 col-form-label">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{$toolkit->toolkit_title}}" name="toolkit_name" class="form-control" id="toolkitName" placeholder="Toolkit Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="toolkitDescription" class="col-sm-2 col-form-label">Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="toolkit_description" placeholder="Description" id="toolkitDescription" rows="3">{{$toolkit->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="toolkitPrice" class="col-sm-2 col-form-label">Price:</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{$toolkit->price}}" name="toolkit_price" class="form-control" id="toolkitPrice" placeholder="Toolkit Price">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the toolkit is free.</p>
                            </div>
                        </div>
                        @if($user_info->identifier == 101)
                        @php $statusOptions = ['Pending', 'Approved']; @endphp
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Status:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="status" id="status" {{ $publishEnable == 1 ? "" : "disabled"}}>
                                    @foreach($statusOptions as $options)
                                        <option value="{{$options}}" {{$toolkit->status == $options ? "selected" : ""}}>{{$options}}</option>
                                    @endforeach
                                </select>
                                @if($publishEnable == 0)
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* This toolkit doesn't have minimum quiz question.</p>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Subject:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="subject" id="subjects">
                                    <option>Choose Subject...</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{$subject->id}}" {{$toolkit->subject_id == $subject->id ? "selected" : ""}}>{{$subject->subject_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Type:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="toolkit_type" id="type">
                                    <option selected>Choose Type...</option>
                                    <option value="Teacher" {{$toolkit->type == 'Teacher' ? "selected" : ""}}>Teacher</option>
                                    <option value="Student" {{$toolkit->type == 'Student' ? "selected" : ""}}>Student</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thumbnail_image" class="col-sm-2 col-form-label">Image:</label>
                            <div class="col-sm-10">
                                <img style="width: 300px;" src="{{ url('images/thumbnail') }}/{{$toolkit->thumbnail}}" alt="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thumbnail_image" class="col-sm-2 col-form-label">Choose New Image:</label>
                            <div class="col-sm-10">
                                <input type="file" name="toolkitThumbnailImage" class="form-control-file" id="thumbnail_image">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Thumbnail image ratio should be  750px X 450px (width = 750px, height = 450px).</p>
                            </div>
                        </div>
                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Update</button>
                    </form>
                </div>
                <div id="addContentSection">
                    <div id="videoSection">
                        <form action="{{ route('toolkit.video.create', $toolkitId) }}" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class='form-group'>
                                <label>Video Url</label>
                                <input name="url" class="form-control" placeholder="Enter Video Url" value="" required/>
                            </div>
                            <div class='form-group'>
                                <label>Video Title</label>
                                <input name="title" class="form-control" placeholder="Enter Video Title" value="" required/>
                            </div>
                            <div class='form-group'>
                                <label>Video Description</label>
                                <textarea class="form-control" name="description" placeholder="Enter Video Description" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Create</button>
                        </form>
                    </div>
                    <div id="quizSection">
                        <form action="{{ route('toolkit.quiz.create', $toolkitId) }}" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Create quiz first then create quiz question.</p>
                            <div class="form-group">
                                <label>Quiz Name</label>
                                <input name="quiz_name" class="form-control" placeholder="Enter quiz name" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Quiz Description</label>
                                <textarea class="form-control" name="quiz_description" placeholder="Description" id="quizDescription" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Create</button>
                        </form>
                    </div>
                    <div id="questionSection">
                        <p style="font-size: 14px; color: #721c24">Add minimum 4 and maximum 10 question.</p>
                        <form action="{{ route('toolkit.question.create', $toolkitId) }}" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                            <div class="form-group">
                                <label>Quiz Question</label>
                                <input id="question-query" name="questions0[]" class="form-control" value="" placeholder="Enter Question"/>
                                @foreach($contents as $content)
                                    @if($content->type == 3)
                                    <input name="quiz_id" type="hidden" class="form-control" value="{{$content->id}}" placeholder="Enter Question"/>
                                    @endif
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label>Answer Options</label>
                                <div id="option-section">
                                    @php $ansNo = 0; @endphp
                                    @for($x=1; $x<=4; $x++)
{{--                                        @php $ansNo++ @endphp--}}
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="width: 35px;">{{$x}}</div>
                                            </div>
                                            <input type="text" class="form-control" name="options{{$ansNo}}[]" value="" placeholder="Enter answer option"/>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Choose Correct Answer Option</label>
                                </div>
                                @for($x=1; $x<=4; $x++)
                                    <div class="col-lg-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="correctOption_0" id="radios_{{$x}}" value="{{$x}}">
                                            <label class="form-check-label" for="radios_{{$x}}">
                                                {{$x}}
                                            </label>
                                        </div>
                                    </div>
                                @endfor

                            </div>
{{--                            @php--}}
{{--                                $count = 0;--}}
{{--                            @endphp--}}
{{--                            @for($ques=0; $ques<=4; $ques++)--}}
{{--                                @php $count++ @endphp--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Quiz Question {{$count}}</label>--}}
{{--                                    <input id="question-query" name="questions{{$ques}}" class="form-control" value="" placeholder="Enter Question"/>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Answer Options</label>--}}
{{--                                    <div id="option-section">--}}
{{--                                        @php $ansNo = 0; @endphp--}}
{{--                                        @for($x=1; $x<=4; $x++)--}}
{{--                                            @php $ansNo++ @endphp--}}
{{--                                            <div class="input-group mb-2 mr-sm-2">--}}
{{--                                                <div class="input-group-prepend">--}}
{{--                                                    <div class="input-group-text" style="width: 35px;">{{$x}}</div>--}}
{{--                                                </div>--}}
{{--                                                <input type="text" class="form-control" name="options{{$ques}}[]" value="" placeholder="Enter answer option"/>--}}
{{--                                            </div>--}}
{{--                                        @endfor--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-12">--}}
{{--                                        <label>Choose Correct Answer Option</label>--}}
{{--                                    </div>--}}
{{--                                    @for($x=1; $x<=4; $x++)--}}
{{--                                        <div class="col-lg-1">--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="radio" name="correctOption_{{$ques}}" id="radios_{{$x}}" value="{{$x}}">--}}
{{--                                                <label class="form-check-label" for="radios_{{$x}}">--}}
{{--                                                    {{$x}}--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endfor--}}

{{--                                </div>--}}
{{--                                <hr>--}}
{{--                            @endfor--}}
                            <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Create</button>
                        </form>
                    </div>
                </div>
                <div id="content">


                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript">

            $(document).ready(function () {
                $("#videoSection").hide();
                $("#questionSection").hide();
                $('#editToolkit').hide();
                $("#quizSection").hide();

                $('#editToolkit').on('click', function(e){
                    $("#videoSection").hide();
                    $("#questionSection").hide();
                    $("#toolkitSection").show();
                    $("#content").hide();
                    $('#editToolkit').hide();
                });
                $('#addVideo').on('click', function(e){
                    $("#questionSection").hide();
                    $("#videoSection").show();
                    $("#toolkitSection").hide();
                    $("#quizSection").hide();
                    $('#editToolkit').show();
                });
                $('#addQuiz').on('click', function(e){
                    $("#questionSection").hide();
                    $("#videoSection").hide();
                    $("#quizSection").show();
                    $("#toolkitSection").hide();
                    $('#editToolkit').show();
                });
                $('#addQuestion').on('click', function(e){
                    $("#videoSection").hide();
                    $("#questionSection").show();
                    $("#quizSection").hide();
                    $("#toolkitSection").hide();
                    $('#editToolkit').show();
                    $("#content").hide();
                });

                $('.edit-button').on('click', function (e) {
                    $("#videoSection").hide();
                    $("#questionSection").hide();
                    $("#toolkitSection").hide();
                    $("#quizSection").hide();
                    $("#content").show();
                    $('#editToolkit').show();

                    var id = $(this).attr('id');
                    var type = $(this).attr('type');

                    loadContent(id, type);
                    // console.log('id '+ id+' {} type'+ type);
                });

                $("#toolkitPrice").keydown(function (event) {
                    if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46) {
                    } else {
                        event.preventDefault();
                    }
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
                            course_toolkit: '{{ Request::segment(1) }}'
                        },
                        success: function (result) {
                            console.log(result);
                            let actionUrl = "{{ route('toolkit.video.edit', ':resultid') }}";
                            actionUrl = actionUrl.replace(":resultid", result.id);


                            if (type == 1) {
                                let formHtml = "<form action='" + actionUrl + "' method='post'>" +
                                    "<input type=\"hidden\" name=\"_token\" value=\"{{csrf_token()}}\">"+
                                    "<div class='form-group'><label>Video Url</label><input name='url' class='form-control' value='" + result.url + "'/></div>" +
                                    "<div class='form-group'><label>Video Title</label><input name='title' class='form-control' value='"+result.video_title+"'/></div>" +
                                    "<div class='form-group'><label>Video Description</label><textarea name='description' class='form-control' rows=\"3\">"+result.short_description+"</textarea></div>" +
                                    "<input type='hidden' name='toolkit_id' class='form-control' value='"+result.toolkit_id+"'/>"+
                                    "<input type='hidden' name='id' class='form-control' value='"+result.id+"'/>"+
                                    "<button type=\"submit\" class=\"btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white\" id=\"quizButton\">Update</button>"
                                    "</form>";

                                $('#content').html(formHtml);

                            } else if (type == 2) {
                                $('#content').html('<object style="height: 80vh" width="100%" data="' + result.doc_url + '"><p>Document</p></object><button class="btn background-yellow px-4 py-2 mt-5 shadow font-weight-bold text-white" id="nextSequence">Go to Next</button>');
                            }else{
                                $('#content').html(result.html);
                                // console.log('before ques');
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
                            course_toolkit: '{{ Request::segment(1) }}',
                        },
                        success: function(result){


                            // $('#question-query').val(result.question.query);
                            // $('#question-query-hidden').val(result.question.id);
                            // $('#question-query').attr('question_id', result.question.id);
                            console.log(result);
                            $('#questions').html(result.html);
                            // if(result.options.length == 0){
                            //     $('#option-section').html('<div class="form-row mt-1"><div class="col-md-12 mb-5"><input type="text" class="form-control border-yellow"  required  placeholder="Your Answer" autofocus></div></div>');
                            // }else{
                            //     $('#option-section').empty();
                            //     $.each(result.options, function(key,value){
                            //         // $('#option-section').append('<div class="custom-control custom-radio"><input type="radio" value='+(key+1)+' id="radio'+value.id+'" name="radio" class="custom-control-input"><label class="custom-control-label" for="radio'+value.id+'">'+value.question_option+'</label></div><hr>');
                            //         $('#option-section').append("<input type='hidden' class='form-control mb-2' name='optionsId[]' value='"+value.id+"'/>");
                            //         $('#option-section').append("<input type='text' class='form-control mb-2' name='options[]' value='"+value.question_option+"'/>");
                            //
                            //     });
                            //
                            // }
                        }
                    });
                }
            });

        </script>
    @endpush

@endsection

