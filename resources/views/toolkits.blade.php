@extends('master')
@section('content')


	<section class="container">
    <div class="row">
        <div class="col-lg-12">
             <h2 class="mt-3 text-center font-weight-bold">Toolkits</h2>
        </div>
    </div>
</section>




<section>
   <div class="container-fluid">
   	
   		@php
  		$temp_subject_id = -1;
		@endphp

		@foreach($toolkit_info as $key =>$toolkit)
			@if($temp_subject_id!=$toolkit->subject_id)

				@php 
				$temp_subject_id = $toolkit->subject_id;
				@endphp

					@if($key > 0)

					</div>@endif


						<h4 class="mt-3 font-weight-bold">{{$toolkit->subject_name}}</h4>
							
					   		<div class="row"> 
					   		  @endif
					            <div class="col-md-3 my-3">
					            	<a href="{{ url('view') }}/t/{{$toolkit->slug}}">
					            
						                <div class="card" style="min-height: 22.5vh">
							                <img src="{{url('images\thumbnail')}}\{{ $toolkit->thumbnail }}" class="card-img-top">
							                <div class="text-center">
							                 	<img src="{{url('images\profile_picture')}}\{{ $toolkit->image }}" alt="Avatar" class="avatar">
							                </div>
							                <div class="card-body">
							                  
							                    <p class="card-title text-dark font-weight-bold">{{ str_limit(strip_tags($toolkit->toolkit_title), 30) }}</p>
							                    <p class="card-text text-yellow font-weight-bold"><small>Posted By</small><br> {{ str_limit(strip_tags($toolkit->name), 20) }}</p>

							                    <div class="text-dark">
												@for($i = 1; $i <= 5; $i++)
										          @if($toolkit->rating - $i >= 0)
										          <i class="fa fa-star checked-yellow" aria-hidden="true"></i>
										          @else
										          <i class="far fa-star"></i>
										          @endif
										        @endfor
												</div>
							                </div>
							                <div class="card-footer" style="background: #51b964;">
							                  <a href="{{ url('view') }}/t/{{$toolkit->slug}}"><h5 class="text-white text-center">Free</h5></a>
							                </div>
							            </div>
						            </a>


					             </div>
					            @endforeach 
					        </div>
      
     

     

</section>


<div class="container-fluid">
        	<div class="row">
        		<div class="col-sm-12">
        			 {{$toolkit_info->links()}}
        		</div>
        	</div>
        </div>



@endsection