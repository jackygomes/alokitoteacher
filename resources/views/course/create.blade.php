@extends('master')
@section('content')


<div class="container-fluid">

    <div class="row">
        <div class="col-md-3 col-sm-12 pt-5 pb-3 text-center" style="background-color: #f5b82f;"><!--left col-->

            <div style="width: 150px; height: 150px;" class="mx-auto">
                @if($user_info->image == null)
                    <i class="fas fa-user-circle fa-10x text-white"></i>
                @else
                    <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $user_info->image }}">
                @endif
            </div>


            <h3 class="mt-5 font-weight-bold text-white"> {{$user_info->name}}</h3>

            @for($i = 1; $i <= 5; $i++)
                @if($user_info->rating - $i >= 0)
                    <i class="fa fa-star" aria-hidden="true"></i>
                @else
                    <i class="far fa-star text-white"></i>
                @endif
            @endfor



            @if($user_info->id == Auth::id())

                <div class="row text-left p-2 mt-3">
                    <div class="col-2">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="col-10">
                        {{$user_info->email}}
                    </div>
                    <div class="col-2">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="col-10">
                        {{$user_info->phone_number}}
                    </div>

                </div>

            @endif


        </div>

        <div class="col-md-9 col-sm-12 mt-2">
            <div class="container-fluid">
                <div class="row">
                    <h3>Create Course:</h3>
                </div>
                <div class="row">
                    <form action="{{ route('course.store') }}" method="post" enctype="multipart/form-data" style="width: 100%;">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">Course Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="course_name" class="form-control" id="courseName" placeholder="Course Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseDescription" class="col-sm-2 col-form-label">Course Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="course_description" placeholder="Description" id="courseDescription" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="coursePrice" class="col-sm-2 col-form-label">Course Price:</label>
                            <div class="col-sm-10">
                                <input type="text" name="course_price" class="form-control" id="coursePrice" placeholder="Course Price">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the toolkit is free.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="certificatePrice" class="col-sm-2 col-form-label">Certificate Price:</label>
                            <div class="col-sm-10">
                                <input type="text" name="certificate_price" class="form-control" id="certificatePrice" placeholder="Course Price">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the toolkit is free.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="previewVideo" class="col-sm-2 col-form-label">Preview Video:</label>
                            <div class="col-sm-10">
                                <input type="text" name="preview_video" class="form-control" id="previewVideo" placeholder="Preview Video Url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thumbnailImage" class="col-sm-2 col-form-label">Thumbnail Image:</label>
                            <div class="col-sm-10">
                                <input type="file" name="courseThumbnailImage" class="form-control-file" id="thumbnailImage">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Thumbnail image ratio should be  400px X 300px (width = 400px, height = 300px).</p>
                            </div>
                        </div>
                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')

    <script type="text/javascript">
        $(document).ready(function(){
            $("#coursePrice").keydown(function (event) {
                // Allow Only: keyboard 0-9, numpad 0-9, backspace, tab, left arrow, right arrow, delete
                if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46) {
                    // Allow normal operation
                } else {
                    // Prevent the rest
                    event.preventDefault();
                }
            });
        });

    </script>

@endpush
@endsection
