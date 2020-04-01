@extends('master')
@section('content')


  

 

 <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
         <div class="bg-light border-right" id="sidebar-wrapper">
      @foreach($video as $v_video)
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">{{$v_video->video_title}}<i class=" float-right fas fa-play-circle " style="  font-size:30px; color: #f5b82f;"></i></a>


     <!--   
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Quiz1 1Unit 1 <i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light"> Lecture 1.2 PRINCIPLES OF GAME MAKING – খেলা তৈরী নীতি<i class="float-right  fas fa-play-circle " style="  font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Lecture 1.3 DESIGNING OR PREPARING FOR A GAME BASED SESSION – খেলা ভিত্তিক ক্লাস ডিসাইন করা <i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>

         
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Quiz 1.2 Unit 2<i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Lecture 1.4 ENGLISH GAME: HANGMAN – ইংরেজি গেম: হ্যাংম্যান <i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Lecture 1.5 BANGLA GAME: HEADS UP – বাংলা গেম: হেডস আপ<i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Quiz 1.3 Unit 3 <i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light"> Lecture 1.6 MATH GAME: BANKER – গণিত গেম: ব্যাংকার <i class="float-right  fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Lecture 1.7 SCIENCE GAME: What’s the letter – হয়াট’স দ্যা লেটার <i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Lecture1.8G. Studies: Flying planes – বাংলাদেশ ও বিশ্ব পরিচয় – ফ্লাইং প্লেইন্স <i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Quiz 1.4 Unit 4<i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Lecture 1.9 CLASS MANAGEMENT – ক্লাস পরিচালনার বিষয় <i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
        <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Lecture 1.10 EMPATHY BASED GAME – সহমর্মিতা ভিত্তিক খেলা <i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
         <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light"> Lecture1.11SUMMARY – সারাংশ <i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
          <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Quiz 1.5 Unit 5<i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a>
           <a href="#" class="list-group-item font-weight-bold list-group-item-action bg-light">Quiz 1.6 Course Quiz<i class="float-right fas fa-play-circle " style=" font-size:30px; color: #f5b82f;"></i></a> -->


      </div>
     @endforeach 
    </div>
      </div>

      <div class="col-md-10">
         <div id="page-content-wrapper">

              <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-primary" id="menu-toggle" style="background-color:#f5b82f; border-color:#ffffff;"><<</button>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                
              </nav>

        
          
             <div>
               @foreach($video as $v_video)
                 <div class="embed-responsive  embed-responsive-21by9  ">
              <iframe width="853" height="480" src="{{$v_video->url}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            </div>
             @endforeach
            <h3 class="text-center font-weight-bold mt-2">GAME BASED LEARNING</h3>
            <p class="mt-3 text-center mb-3">Short Description-In this video you will learn about...</p>

           </div>
         
       
         
    </div>
    <!-- /#page-content-wrapper -->
      </div>
    </div>
  </div>  
   
    <!-- /#sidebar-wrapper -->



    <!-- Page Content -->
    

  </div>
  <!-- /#wrapper -->


  


@endsection