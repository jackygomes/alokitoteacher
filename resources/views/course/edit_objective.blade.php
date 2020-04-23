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
                <div id="addVideoSection">
                    <form action="{{ route('toolkit.video.create', $info->id) }}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class='form-group'><label>Video Url</label><input name="url" class="form-control" placeholder="Enter Video Url" value=""/></div>
                        <div class='form-group'><label>Video Title</label><input name="title" class="form-control" placeholder="Enter Video Title" value=""/></div>
                        <div class='form-group'><label>Video Description</label><input name='description' class='form-control' placeholder="Enter Video Description" value=""/></div>
                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Create</button>
                    </form>
                </div>
                <div id="addQuizSection">
                    <form action="{{ route('toolkit.quiz.create', $info->id) }}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                    <form action="{{ route('toolkit.question.create', $info->id) }}" method="post">
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
                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Create</button>
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
                        @foreach($contents as $content)
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <input type="text" name="item_sequence[]" id="itemSequence" class="form-control text-center" value="{{ $content->sequence }}"/>
                                <input type="hidden" name="item_id[]" class="form-control" value="{{ $content->id }}" placeholder="Sequence">
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
        <script type="text/javascript">

            $(document).ready(function () {
                $('#addVideoSection').hide();
                $('#addQuizSection').hide();
                $('#addQuestionSection').hide();
                $('#setSequenceSection').hide();

                $('#addVideo').on('click', function(){
                    $('#addVideoSection').show();
                    $('#addQuizSection').hide();
                    $('#addQuestionSection').hide();
                    $('#setSequenceSection').hide();
                });
                $('#addQuiz').on('click', function(){
                    $('#addVideoSection').hide();
                    $('#addQuizSection').show();
                    $('#addQuestionSection').hide();
                    $('#setSequenceSection').hide();
                });
                $('#addQuestion').on('click', function(){
                    $('#addVideoSection').hide();
                    $('#addQuizSection').hide();
                    $('#addQuestionSection').show();
                    $('#setSequenceSection').hide();
                });
                $('#setSequence').on('click', function(){
                    $('#addVideoSection').hide();
                    $('#addQuizSection').hide();
                    $('#addQuestionSection').hide();
                    $('#setSequenceSection').show();
                });

            });

        </script>
    @endpush

@endsection
