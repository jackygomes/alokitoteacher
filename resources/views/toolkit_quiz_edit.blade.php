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

        <div id="questions"></div>

        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Update</button>
    </div>
</form>

