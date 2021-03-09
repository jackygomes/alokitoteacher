@php $count = 0; @endphp
@foreach ($questions as $question)
    @php $count++ @endphp
    <div class="form-group">
        <label>Quiz Question {{$count}}</label><a style="color:red" onclick="del({{$question->id}})"><label class="float-right"><i class="fas fa-trash " style="font-size:16px;cursor: pointer;"></i></label></a>
        <input id="question-query" name="questions[]" class="form-control" value="{{$question->query}}"/>
        <input type="hidden" id="question-query-hidden" name="questionIds[]" class="form-control" value="{{$question->id}}"/>
    </div>
    <div class="form-group">
        <label>Answer Options</label>
        <div id="option-section">
            @php $ansNo = 0; @endphp
            @foreach($question->quizOptions as $option)
                @php $ansNo++ @endphp
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="width: 35px;">{{$ansNo}}</div>
                    </div>
                    <input type="text" class="form-control" name="options[]" value="{{$option->question_option}}"/>
                    <input type="hidden" class="form-control" name="optionsIds[]" value="{{$option->id}}"/>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label>Set Correct Answer Option</label>
        </div>
        @for($x=1; $x<=4; $x++)
            <div class="col-lg-1">
                <div class="form-check">
                    @if($question->correct_option == $x)
                    <input class="form-check-input" type="radio" name="correctOption_{{$question->id}}" id="radios_{{$x}}" value="{{$x}}" checked>
                    @else
                    <input class="form-check-input" type="radio" name="correctOption_{{$question->id}}" id="radios_{{$x}}" value="{{$x}}">
                    @endif
                    <label class="form-check-label" for="radios_{{$x}}">
                        {{$x}}
                    </label>
                </div>
            </div>
        @endfor

    </div>
    <hr>
@endforeach

<script>
 var del = function(id){
    Swal.fire({
            icon: 'question',
            title: 'Are you sure to delete?',
            confirmButtonColor: '#f5b82f',
            confirmButtonText: "Yes",
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = '/admin/course/question/delete/' + id;
            }
        })
    
}
</script>