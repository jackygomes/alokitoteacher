@extends('master')
@section('content')


<div class="jumbotron" style="background: url(https://alokitoteachers.com/wp-content/uploads/2019/06/Cover-Banner.jpg) no-repeat center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; padding-top:15%; padding-bottom: 15%; ">
 <h1 class="display-4 text-white font-weight-bold">Contact Us</h1>
</div>

<section class="ml-5">
  <div class="row ml-5">

    <div class="col-md-6 col-sm-12">
      <h1 class="font-weight-bold mt-5 mb-5">Contact Info</h1>
      <hr>
      <div class="row">
        <div class="col-md-6 text-center">
           
           <div class="">
              <i class="fas fa-phone-alt" style="color: #f5b82f;"></i>
              <span class="d-inline-block"><h5 class="font-weight-bold">Phone</h5></span>
              <p class=" font-weight-bold text-secondary">+88-01742812044</p>
              
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
           
           <div class="">
              <i class="fas fa-envelope" style="color: #f5b82f;"></i>
              <span class="d-inline-block"><h5 class="font-weight-bold">Email</h5></span>
              <p class=" font-weight-bold text-secondary">info@alokitoteachers.com</p>
            
            </div>
        </div>
      </div>
      <hr>
        <div class="row">
           <div class="col-md-6 col-sm-12 text-center">
              <div class="">
                <i class="fas fa-map-marker-alt"style="color: #f5b82f;"></i>
                <span class="d-inline-block"><h5 class="font-weight-bold">Address</h5></span>
                <p class=" font-weight-bold text-secondary">3/11, Block B, Lalmatia,
                  Dhaka 1207, Bangladesh</p>
                
              </div>
           </div>
        </div>
       <hr>
    </div>

     <div class="col-md-6 ">
       <h1 class="font-weight-bold mt-5 mb-5">Send A Message</h1>

       <div class="">


          <form class="mb-5">
            <div class="form-row">
              <div class="col-md-5 col-sm-6 mb-6">
                
                <input type="text" class="form-control is-valid" style="border-color: #f6993f;" id="validationServer01" placeholder="Name" value="" required>

              </div>
              <div class="col-md-5 col-sm-6 mb-6 ">
               
                <input type="text" class="form-control is-valid" style="border-color: #f6993f;" id="validationServer02" placeholder="Email" value="" required>
                
              </div>
              
            </div>

            <div class="form-row mt-5">
              <div class="col-md-10 col-sm-10">
                
                <input type="text" class="form-control is-valid" style="border-color: #f6993f;" id="validationServer01" placeholder="Name" value="" required>

              </div>
              
            </div>

            <div class="form-row mt-3 mb-5">
              <div class="col-md-10 col-sm-10">
                
               <textarea class="form-control" rows="5" id="comment" style="border-color: #f6993f;" placeholder="Message"></textarea>

              </div>
              
            </div>

            <button type="button" class="mb-5 btn btn-success px-4 py-2 shadow font-weight-bold " style="background-color:#f5b82f;border-color:#ffffff; border-radius: 5%" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" >Submit</button>

         </form>
       </div>
     </div>

  </div>
</section>



    @endsection