@extends('master')
@section('content')

<h1 class="display-4 text-dark font-weight-bold text-center py-5">Contact Us</h1>

<section class="container">
    <div class="contact-us-wrapper text-white">
      <div class="row">
        <div class="col-md-4 col-sm-12">
            <h3 class="font-weight-bold mb-5">Contact Info</h3>
            <div class="contact-us-content">
                <div class="item">
                    <img src="{{asset('images/new_design/contact-us-phone.png')}}" alt="">
                    <a href="tel:+8801742812044" class="text-white">+88-01742812044</a>
                </div>
                <div class="item">
                    <img src="{{asset('images/new_design/contact-us-mail.png')}}" alt="">
                    <a href="mailto:info@alokitoteachers.com" class="text-white">info@alokitoteachers.com</a>
                </div>
                <div class="item">
                    <img src="{{asset('images/new_design/contact-us-map-pin.png')}}" alt="">
                    <p class="mb-0">3/11, Block B, Lalmatia,<br> Dhaka 1207, Bangladesh</p>
                </div>
            </div>
            <div class="contact-us-content-bottom">
                <p class="font-weight-bold mb-3">Follow us on</p>
                <div>
                    <a href=""><img src="{{asset('images/new_design/facebook.png')}}" alt=""></a>
                    <a href=""><img src="{{asset('images/new_design/instagram.png')}}" alt=""></a>
                    <a href=""><img src="{{asset('images/new_design/linkedin.png')}}" alt=""></a>
                    <a href=""><img src="{{asset('images/new_design/youtube.png')}}" alt=""></a>
                </div>
            </div>
        </div>

            <div class="col-md-8">
              <form>
                <div class="form-row">
                  <div class="col-md-6 col-sm-6 mb-6">
                    <input type="text" class="form-control" id="validationServer01" placeholder="Name" value="" required>
                  </div>
                  <div class="col-md-6 col-sm-6 mb-6 ">
                    <input type="email" class="form-control" id="validationServer02" placeholder="Email" value="" required>
                  </div>
                </div>

                <div class="form-row mt-3 mb-5">
                  <div class="col-md-12 col-sm-10">
                   <textarea class="form-control" rows="5 placeholder="Message"></textarea>
                  </div>
                </div>

                <button type="button" class="mt-3 btn text-center background-yellow text-white font-weight-bold home-explore-button btn-block" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" >Submit Now</button>

             </form>
            </div>
      </div>
    </div>
</section>



    @endsection
