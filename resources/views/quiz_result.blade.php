
<div class="container mt-5 mb-5">
	<div class="row">
		<div class="col-md-12">
			<h3 class="font-weight-bold">Your Result</h3>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">

         <div class="col-md-2">
            <div class="result-circle yellow-border">
                <div class="row h-100">
                    <div class="m-auto text-center">
                        <h5 class="font-weight-bold text-secondary">Question</h5>
                        <h2 class="font-weight-bold text-yellow">{{ $total_questions }}</h2>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="col-md-2">
            <div class="result-circle green-border">
                <div class="row h-100">
                    <div class="m-auto text-center">
                        <h5 class="font-weight-bold text-secondary">Correct</h5>
                        <h2 class="font-weight-bold text-success">{{ $correct }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="result-circle red-border">
                <div class="row h-100">
                    <div class="m-auto text-center">
                        <h5 class="font-weight-bold text-secondary">Wrong</h5>
                        <h2 class="font-weight-bold text-danger">{{ $wrong }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 block">
            <div class="result-circle black-border">
                <div class="row h-100">
                    <div class="m-auto text-center">
                        <h5 class="font-weight-bold text-secondary">Total Points</h5>
                        <h2 class="font-weight-bold">{{ $points }}</h2>
                    </div>
                    
                </div>
            </div>
        </div>
       
        <div class="col-md-2">
            <div class="result-circle blue-border">
                <div class="row h-100">
                    <div class="m-auto text-center">
                        <h5 class="font-weight-bold text-secondary">Time</h5>
                        <h2 class="font-weight-bold text-primary">{{ $time }}</h2>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="row mt-5">

        <button class="btn background-yellow px-4 py-3 shadow font-weight-bold text-white" id="nextSequence">Go to Next</button>
    </div>
</div>
  
