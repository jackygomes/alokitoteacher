@extends('master')
@section('content')
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .list-group .btn {
            width: 100%;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <div class="container-fluid" style="min-height: 90vh">
        <div class="row">

            <div id="sidebarCol" class="col-md-4 order-2 order-md-1"
                 style="padding-left: 0 !important; min-height: 90vh;overflow-y: auto;">
                <div id="sidebar" class="background-yellow" style="min-height: 100%">

                    <div class="list-group list-group-flush bg-light">
                        <div class="list-group-item list-group-item-action bg-light ItemButton">
                            <button class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white" id="addVideo">Add Video</button>
                        </div>
                        <div class="list-group-item list-group-item-action bg-light ItemButton">
                            <button class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white" id="addQuiz">Add Quiz</button>
                        </div>
                        <div class="list-group-item list-group-item-action bg-light ItemButton">
                            <button class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white" id="addQuestion">Add Question</button>
                        </div>
                        <div class="list-group-item list-group-item-action bg-light ItemButton">
                            <button class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white" id="setSequence">Set Sequence</button>
                        </div>
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
                    <div class="col-lg-12 mb-4">
                        <a href="{{route('course.edit', $info->id)}}" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white">
                            Back
                        </a>
                        <button class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white" id="editCourse">Edit Course Details</button>
                    </div>
                </div>
                <div id="editCourseDetailsSection">
                    <form action="{{route('course.details.update', $info->id)}}" method="post" enctype="multipart/form-data" style="width: 100%;">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">Course Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="course_name" class="form-control" value="{{$info->title}}" id="courseName" placeholder="Course Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseDescription" class="col-sm-2 col-form-label">Course Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="course_description" placeholder="Description" id="courseDescription" rows="3">{{$info->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="coursePrice" class="col-sm-2 col-form-label">Course Price:</label>
                            <div class="col-sm-10">
                                <input type="text" name="course_price" class="form-control" value="{{$info->price}}" id="coursePrice" placeholder="Course Price">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the Course is free.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="certificatePrice" class="col-sm-2 col-form-label">Certificate Price:</label>
                            <div class="col-sm-10">
                                <input type="text" name="certificate_price" class="form-control" value="{{$info->certificate_price}}" id="certificatePrice" placeholder="Course Price">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the Course is free.</p>
                            </div>
                        </div>
                        @php $statusOptions = ['Pending', 'Approved']; @endphp
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Status:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="status" id="status" {{ $canEdit == 1 ? "" : "disabled"}}>
                                    @foreach($statusOptions as $options)
                                        <option value="{{$options}}" {{$info->status == $options ? "selected" : ""}}>{{$options}}</option>
                                    @endforeach
                                </select>
                                @if($canEdit == 0)
                                    <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* This Course doesn't have minimum quiz question.</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="previewVideo" class="col-sm-2 col-form-label">Preview Video:</label>
                            <div class="col-sm-10">
                                <input type="text" name="preview_video" class="form-control" value="{{$previewVideo->url}}" id="previewVideo" placeholder="Preview Video Url">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Facilitator:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="facilitator[]" id="facilitator">
                                    @foreach($facilitators as $facilitator)
                                        <option value="{{$facilitator->id}}">{{$facilitator->name}}</option>
{{--                                        <option value="{{$facilitator->id}}" {{$info->course_facilitator == $facilitator->id ? "selected" : ""}}>{{$facilitator->name}}</option>--}}
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Advisor:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="advisor[]" id="advisor">
                                    @foreach($advisors as $advisor)
                                        <option value="{{$advisor->id}}">{{$advisor->name}}</option>
{{--                                        <option value="{{$advisor->id}}" {{$info->advisor == $advisor->id ? "selected" : ""}}>{{$advisor->name}}</option>--}}
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Designer:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="designer[]" id="designer">
                                    @foreach($designers as $designer)
                                        <option value="{{$designer->id}}" >{{$designer->name}}</option>
{{--                                        <option value="{{$designer->id}}" {{$info->designer == $designer->id ? "selected" : ""}}>{{$designer->name}}</option>--}}
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="thumbnail_image" class="col-sm-2 col-form-label">Image:</label>
                            <div class="col-sm-10">
                                <img style="width: 300px;" src="{{ url('images/thumbnail') }}/{{$info->thumbnail}}" alt="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thumbnailImage" class="col-sm-2 col-form-label">Thumbnail Image:</label>
                            <div class="col-sm-10">
                                <input type="file" name="courseThumbnailImage" class="form-control-file" id="thumbnailImage">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Thumbnail image ratio should be 400px X 300px (width = 400px, height = 300px).</p>
                            </div>
                        </div>
                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Submit</button>
                    </form>
                </div>
                <div id="addVideoSection">
                    <form action="{{ route('course.video.create', $info->id) }}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class='form-group'><label>Video Url</label><input name="url" class="form-control" placeholder="Enter Video Url" value=""/></div>
                        <div class='form-group'><label>Video Title</label><input name="title" class="form-control" placeholder="Enter Video Title" value=""/></div>
                        <div class='form-group'><label>Video Description</label><textarea name='description' class='form-control' placeholder="Enter Video Description" value=""></textarea></div>
                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Create</button>
                    </form>
                </div>
                <div id="addQuizSection">
                    <form action="{{ route('course.quiz.create', $info->id) }}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <p style="margin: 0 0 15px; font-size: 14px; color: #721c24">* Create quiz first then create quiz question.</p>
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
                <div id="addQuestionSection">
                    <p style="font-size: 14px; color: #004085">Add minimum 5 and maximum 10 question.</p>
                    <form action="{{ route('course.question.create', $info->id) }}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        @if(count($quizzes) > 0)
                        <div class="form-group">
                            <label for="subjects" class="">Choose Quiz:</label>
                            <div>
                                <select class="custom-select mr-sm-2 form-control" name="quiz" id="subjects">
                                    <option selected value="">Choose Quiz...</option>
                                    @foreach($quizzes as $quiz)
                                        <option value="{{$quiz->id}}">{{$quiz->quiz_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @else
                            <div class="alert alert-danger">
                                Before Creating Question, Create Atleast One Quiz.
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Quiz Question</label>
                            <input id="question-query" name="question" class="form-control" value="" placeholder="Enter Question"/>
                        </div>
                        <div class="form-group">
                            <label>Answer Options</label>
                            <div id="option-section">
                                @php $ansNo = 0; @endphp
                                @for($x=1; $x<=4; $x++)
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="width: 35px;">{{$x}}</div>
                                        </div>
                                        <input type="text" class="form-control" name="options{{$ansNo}}[]" value="" placeholder="Enter answer option"/>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <label>Choose Correct Answer Option</label>
                            </div>
                            @for($x=1; $x<=4; $x++)
                                <div class="col-lg-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="correctOption" id="radios_{{$x}}" value="{{$x}}">
                                        <label class="form-check-label" for="radios_{{$x}}">
                                            {{$x}}
                                        </label>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        @if(count($quizzes) > 0)
                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Create</button>
                        @endif
                    </form>
                </div>
                <div id="setSequenceSection">
                    @if(count($contents) > 0)
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Set Sequences</h3>
                        </div>
                    </div>
                    <form action="{{ route('course.objective.update', $info->id) }}" method="post" style="width: 100%;">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        @php $itemNo = 0 @endphp
                        @foreach($contents as $content)
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <input type="text" name="item_sequence{{$itemNo}}[]" id="itemSequence" class="form-control text-center" value="{{ $content->sequence }}"/>
                                <input type="hidden" name="item_id{{$itemNo}}[]" class="form-control" value="{{ $content->id }}">
                                <input type="hidden" name="item_type{{$itemNo}}[]" class="form-control" value="{{ $content->type }}">
                            </div>
                            <label for="itemSequence" class="col-sm-10 col-form-label">
                                @if($content->type == 1)
                                    <i class=" float-left fas fa-play-circle text-yellow"
                                        style="font-size:22px;"></i> &nbsp;
                                @elseif($content->type == 3)
                                    <i class=" float-left fas fa-question-circle text-yellow"
                                        style="font-size:22px;"></i> &nbsp;
                                @endif
                                {{$content->title}}
                            </label>
                        </div>
                        <hr>
                            @php $itemNo++ @endphp
                        @endforeach
                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Update</button>
                    </form>
                    @else
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>First Add Videos And Questions</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function () {
                $('#facilitator').select2({
                    multiple: true,
                });
                $('#advisor').select2({
                    multiple: true,
                });
                $('#designer').select2({
                    multiple: true,
                });

                faclitator();
                function faclitator(){
                    let facilitator = {!! json_encode($infoFacilitators) !!};
                    let selectedValues = [];
                    $.each( facilitator, function( key, value ) {
                        selectedValues.push(value.id);
                    });
                    $('#facilitator').val(selectedValues).trigger('change');
                }
                advisor();
                function advisor(){
                    let advisor = {!! json_encode($infoAdvisors) !!};
                    let selectedValues = [];
                    $.each( advisor, function( key, value ) {
                        selectedValues.push(value.id);
                    });
                    $('#advisor').val(selectedValues).trigger('change');
                }
                designer();
                function designer(){
                    let designer = {!! json_encode($infoDesigners) !!};
                    let selectedValues = [];
                    $.each( designer, function( key, value ) {
                        selectedValues.push(value.id);
                    });
                    $('#designer').val(selectedValues).trigger('change');
                }

                $('#editCourseDetailsSection').show();
                $('#addVideoSection').hide();
                $('#addQuizSection').hide();
                $('#addQuestionSection').hide();
                $('#setSequenceSection').hide();

                $('#editCourse').on('click', function(){
                    $('#addVideoSection').hide();
                    $('#addQuizSection').hide();
                    $('#addQuestionSection').hide();
                    $('#setSequenceSection').hide();
                    $('#editCourseDetailsSection').show();
                });
                $('#addVideo').on('click', function(){
                    $('#addVideoSection').show();
                    $('#addQuizSection').hide();
                    $('#addQuestionSection').hide();
                    $('#setSequenceSection').hide();
                    $('#editCourseDetailsSection').hide();
                });
                $('#addQuiz').on('click', function(){
                    $('#addVideoSection').hide();
                    $('#addQuizSection').show();
                    $('#addQuestionSection').hide();
                    $('#setSequenceSection').hide();
                    $('#editCourseDetailsSection').hide();
                });
                $('#addQuestion').on('click', function(){
                    $('#addVideoSection').hide();
                    $('#addQuizSection').hide();
                    $('#addQuestionSection').show();
                    $('#setSequenceSection').hide();
                    $('#editCourseDetailsSection').hide();
                });
                $('#setSequence').on('click', function(){
                    $('#addVideoSection').hide();
                    $('#addQuizSection').hide();
                    $('#addQuestionSection').hide();
                    $('#setSequenceSection').show();
                    $('#editCourseDetailsSection').hide();
                });

            });

        </script>
    @endpush

@endsection
