@extends('master')
@section('content')






 

 <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light">1.1 Preview <i class=" float-right fas fa-play-circle " style="  font-size:30px; color: #f5b82f;"></i>
        <a href="#" class="list-group-item list-group-item-action bg-light">1.2 What is PBL <i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i>
        <a href="#" class="list-group-item list-group-item-action bg-light">Utit-1 <i class="float-right  fas fa-play-circle " style="  font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item list-group-item-action bg-light">1.1 Unit 1 <i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>

         
        <a href="#" class="list-group-item list-group-item-action bg-light">1.3 Structure Of PBL <i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item list-group-item-action bg-light">1.4 Step-1 Problem Identification <i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item list-group-item-action bg-light">1.2 Unit 2 <i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Step-2 Diagonisis Of the Problem <i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item list-group-item-action bg-light">1.6 Imagine & visualize success <i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
      </div>

      <div class="text-center mt-3">
      	<span class="d-inline-block"><i class="fas fa-tv fa-2x mr-5"></i></span>
      	<span class="d-inline-block"><i class="fas fa-puzzle-piece fa-2x ml-5"></i></span>
      </div>

      <div class="text-center mt-3">
      	<span class="d-inline-block "><i class="fas fa-plus-circle fa-3x mr-5"></i></span>
      	<span class="d-inline-block"><i class="fas fa-plus-circle fa-3x ml-5"></i></span>
      </div>

		<div class="mb-5 mt-5">
			<span class="d-inline-block  float-left"><button type="button" class="btn btn-success px-4 shadow font-weight-bold " style="border-color:#ffffff; border-radius: 5%" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Upload</button></span>
			
			<span class="d-inline-block float-right"><button type="button" class="btn btn-success px-4 shadow font-weight-bold " style="background-color:#e3342f;border-color:#ffffff; border-radius: 5%" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Cancel</button></span>
	    </div>

      

    </div>
    <!-- /#sidebar-wrapper -->



    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle" style="background-color:#f5b82f; border-color:#ffffff;"><<</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        
      </nav>



      		<h1 class="font-weight-bold mt-5 ml-5 mb-3"> Unit 1</h1>
		     
      		<div class="ml-5">
      			<div>
	      			<span class="d-inline-block"><i class="fas fa-bullhorn inline"></i></span>
	      			<span class="d-inline-block ml-1"><p>Question</p></span>
	      			<span class="d-inline-block" ><p class="text-warning font-weight-bold">1/5</p></span>
	      			<span class="d-inline-block ml-5" ><i class="fas fa-pen"></i></span>
	      			<span class="d-inline-block" ><p class="text-warning font-weight-bold">0:05:22</p></span>
      			</div>

      			<div class="mt-5">
	      			<i class="fas fa-pen"></i>
	      			<span class="d-inline-block ml-1"><h5 class="font-weight-bold">Inquiry Based Learning</h5></span>
      			</div>
      			<hr>

			        <div class="custom-control custom-radio" >
					  <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" style="" >
					  <label class="custom-control-label" for="customRadio1">Toggle this custom radio</label>
					</div>
					<hr>
					<div class="custom-control custom-radio">
					  <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
					  <label class="custom-control-label" for="customRadio2">Or toggle this other custom radio</label>
					</div>
					<hr>
					 <div class="custom-control custom-radio">
					  <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
					  <label class="custom-control-label" for="customRadio3">Toggle this custom radio</label>
					</div>
					<hr>
					<div class="custom-control custom-radio">
					  <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
					  <label class="custom-control-label" for="customRadio4">Or toggle this other custom radio</label>
					  <hr>
					</div>

					<div class="mb-5">
						<span class="d-inline-block mr-1"><button type="button" class="btn btn-success px-4 shadow font-weight-bold " style="background-color:#343a40;border-color:#ffffff; border-radius: 5%" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Back</button></span>
						<span class="d-inline-block ml-3"><button type="button" class="btn btn-success px-4 shadow font-weight-bold " style="background-color:#343a40;border-color:#ffffff; border-radius: 5%" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Next</button></span>
						<span class="d-inline-block float-right mr-5"><button type="button" class="btn btn-success px-4 shadow font-weight-bold " style="background-color:#e3342f;border-color:#ffffff; border-radius: 5%" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Delete</button></span>
                    </div>

                    <ul class="pagination">
					  
					  <li class="page-item active"><a class="page-link" href="#" style="background-color:#f5b82f;border-color:#ffffff; ">1</a></li>
					  <li class="page-item "><a class="page-link" href="#" >2</a></li>
					  <li class="page-item"><a class="page-link" href="#">3</a></li>
					  <li class="page-item"><a class="page-link" href="#"><i class="fas fa-plus"></i></a></li>
					  
					</ul>
					</div>
			 </div>






        
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->


  


@endsection