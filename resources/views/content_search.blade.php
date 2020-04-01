
@extends('master')
@section('content')



<div class="container-fluid">
	<div class="row">

		<div class="col-md-2 h-100" style="border-right: 1px solid #f5b82f; min-height: 100vh">
			<h3 class="font-weight-bold mt-5">Filter</h3>
			<hr>
			<select class="form-control border-yellow" name="identifier" required="">
				<option value="" disabled="" selected="">-- Course Completed --</option>
				
				<option>dfgdf</option>
				
			</select>
			<br>
			<select class="form-control border-yellow" name="identifier" required="">
				<option value="" disabled="" selected="">-- Toolkit Completed --</option>
				
				<option>asd</option>
				
			</select>
			<br>
			<select class="form-control border-yellow" name="identifier" required="">
				<option value="" disabled="" selected="">-- Weighted Average --</option>
				
				<option>asd</option>
				
			</select>

			<h3 class="font-weight-bold mt-5">Filter</h3>
			<hr>
			<select class="form-control border-yellow" name="identifier" required="">

				<option value="" disabled="" selected="">-- Subject --</option>
				
				<option>dfgdf</option>
				
			</select>
			<br>
			<select class="form-control border-yellow" name="identifier" required="">
				<option value="" disabled="" selected="">-- Instructor --</option>
				
				<option>asd</option>
				
			</select>
			<br>
			<select class="form-control border-yellow" name="identifier" required="">
				<option value="" disabled="" selected="">-- Rating --</option>
				
				<option>asd</option>
				
			</select>
		
		</div>
		<div class="col-md-8">
			<div class="container-fluid">
				<div class="row justify-content-center mt-5">
					<div class="col-md-12">
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text" id="inputGroup-sizing-default">Search</span>
						  </div>
						  <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
						</div>
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<ul class="nav nav-tabs">
						  <li class="nav-item">
						    <a class="nav-link active" href="#">Teacher</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" href="#">Content</a>
						  </li>
						</ul>
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered">
							<thead>
							    <tr>
							      <th scope="col">No.</th>
							      <th scope="col">Name</th>
							      <th scope="col">Courses completed</th>
							      <th scope="col">Toolkits completed</th>
							      <th scope="col">Weighted Average/5</th>
							    </tr>
							</thead>
							<tbody>
							    <tr>
							      <th scope="row">1</th>
							      <td>Azwa Nayeem</td>
							      <td>2</td>
							      <td>4</td>
							      <td>3.2</td>
							    </tr>
							    <tr>
							      <th scope="row">2</th>
							      <td>Shifat</td>
							      <td>1</td>
							      <td>3</td>
							      <td>4.2</td>
							    </tr>
							    
	                        </tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<ul class="nav nav-tabs">
						  <li class="nav-item">
						    <a class="nav-link " href="#">Teacher</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link active" href="#">Content</a>
						  </li>
						</ul>
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered">
							<thead>
							    <tr>
							      <th scope="col">No.</th>
							      <th scope="col">Name</th>
							      <th scope="col">Subject</th>
							      <th scope="col">Instructor</th>
							      <th scope="col">Rating/5</th>
							    </tr>
							</thead>
							<tbody>
							    <tr>
							      <th scope="row">1</th>
							      <td>Problem Based Learning</td>
							      <td>Maths</td>
							      <td>Azwa Nayeem</td>
							      <td>4</td>
							    </tr>
	                        </tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
		<div class="col-md-2" style="border-left: 1px solid #f5b82f;">
			<h5 class="mt-5">LeaderBoard</h5>
		</div>
	</div>
</div>










@endsection