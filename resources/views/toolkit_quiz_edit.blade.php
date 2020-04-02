<form action="{{ route('toolkit.quiz.update', $quiz_details->toolkit_id) }}" method="post">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="col-md-12">

        <div class="form-group">
            <label>Quiz Name</label>
            <input name="quiz_name" class="form-control" value="{{ $quiz_details->quiz_title }}"/>
            <input type="hidden" name="quiz_id" class="form-control" value="{{ $quiz_details->id }}"/>
        </div>
    </div>

    <div class="col-md-12">

        <div class="form-group">
            <label>Quiz Question</label>
            <input id="question-query" name="quiz_question" class="form-control" value=""/>
            <input type="hidden" id="question-query-hidden" name="quiz_question_id" class="form-control" value=""/>
        </div>
        <div class="form-group">
            <label>Answer Options</label>
            <div id="option-section">
            </div>
        </div>

        <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Update</button>
    </div>
</form>

