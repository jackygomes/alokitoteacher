@extends('master')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<div class="container-fluid">

    <div class="row">
        <div class="col-md-3 col-sm-12 pt-5 pb-3 text-center" style="background-color: #f5b82f;">
            <!--left col-->

            <div style="width: 150px; height: 150px;" class="mx-auto">
                @if($user_info->image == null)
                <i class="fas fa-user-circle fa-10x text-white"></i>
                @else
                <img class="img-fluid rounded-circle h-100 w-100" src="{{ url('images/profile_picture') }}/{{ $user_info->image }}">
                @endif
            </div>


            <h3 class="mt-5 font-weight-bold text-white"> {{$user_info->name}}</h3>

            @for($i = 1; $i <= 5; $i++) @if($user_info->rating - $i >= 0)
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
                    <div class="col-md-12">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                            @endforeach
                        </div>
                        @endif
                    </div>
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
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the course is free.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="certificatePrice" class="col-sm-2 col-form-label">Certificate Price:</label>
                            <div class="col-sm-10">
                                <input type="text" name="certificate_price" class="form-control" id="certificatePrice" placeholder="Course Price">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the course is free.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="previewVideo" class="col-sm-2 col-form-label">Preview Video:</label>
                            <div class="col-sm-10">
                                <input type="text" name="preview_video" class="form-control" id="previewVideo" placeholder="Preview Video Url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Facilitator:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="facilitator[]" id="facilitator" multiple="multiple">
                                    @foreach($facilitators as $facilitator)
                                    <option value="{{$facilitator->id}}">{{$facilitator->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Advisor:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="advisor[]" id="advisor" multiple="multiple">
                                    @foreach($advisors as $advisor)
                                    <option value="{{$advisor->id}}">{{$advisor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Designer:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="designer[]" id="designer" multiple="multiple">
                                    @foreach($designers as $designer)
                                    <option value="{{$designer->id}}">{{$designer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thumbnailImage" class="col-sm-2 col-form-label">Thumbnail Image:</label>
                            <div class="col-sm-10">
                                <input type="file" name="courseThumbnailImage" class="form-control-file check-image-size" id="thumbnailImage" data-min-width="400" data-min-height="300" data-max-width="400" data-max-height="300" >
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Thumbnail image ratio should be 400px X 300px (width = 400px, height = 300px).</p>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#thumbnailImage").checkImageSize({
            minWidth: 400,
            minHeight: 300,
            maxWidth: 400,
            maxHeight: 300,
            showError:true,
            ignoreError:false
        });
        $('#facilitator').select2({
            multiple: true,
        });
        $('#advisor').select2({
            multiple: true,
        });
        $('#designer').select2({
            multiple: true,
        });
        $("#coursePrice").keydown(function(event) {
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
