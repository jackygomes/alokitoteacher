<div class="com-md-12">
    <h3 class="font-weight-bold" id="quiz_id" content="{{ $quiz_details->id }}">{{ $quiz_details->quiz_title }}</h3>
</div>
<div class="col-md-12">
    <div class="float-left">
        <i class="fas fa-bullhorn"></i>
        <h5 class="text_in_line">Questions</h5>
        <h5 class="text_in_line text-yellow"><span id="serial-question">1</span>/<span id="serial-limit">{{ $count}}</span></h5>    
    </div>
    
    <div class="float-right">
        <i class="fas fa-clock"></i>
        <h5 class="text_in_line">Time</h5>
        <h5 class="text_in_line text-yellow" id="timer">2:00</h5>
    </div>
</div>


<div class="col-md-12">
    <h4 class="font-weight-bold mt-5 mb-5" id="question-query"></h4>
    <div id="option-section">
    </div>

    <button type="submit" class="btn background-yellow px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Next</button>
    
    
</div>