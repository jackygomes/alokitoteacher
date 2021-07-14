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
                    <h3>Edit Workshop:</h3>
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
                    <form action="{{ route('workshop.update') }}" method="post" enctype="multipart/form-data" style="width: 100%;">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="id" value="{{$workshop->id}}">
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">Workshop Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{$workshop->name}}" class="form-control" id="name" placeholder="Workshop Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseDescription" class="col-sm-2 col-form-label">Workshop Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" placeholder="Description" id="description" rows="3">{{$workshop->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="coursePrice" class="col-sm-2 col-form-label">Workshop Price:</label>
                            <div class="col-sm-10">
                                <input type="text" name="price" value="{{$workshop->price}}" class="form-control" id="price" placeholder="Workshop Price">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the workshop is free.</p>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="certificatePrice" class="col-sm-2 col-form-label">Certificate Price:</label>
                            <div class="col-sm-10">
                                <input type="text" name="certificate_price" class="form-control" id="certificatePrice" placeholder="Course Price">
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the course is free.</p>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="previewVideo" class="col-sm-2 col-form-label">Preview Video:</label>
                            <div class="col-sm-10">
                                <input type="text" name="preview_video" value="{{$workshop->preview_video}}"  class="form-control" id="previewVideo" placeholder="Preview Video Url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Trainer:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="trainers[]" id="trainer" multiple="multiple">
                                    @foreach($trainers as $trainer)
                                    <option value="{{$trainer->id}}" {{in_array($trainer->id, $currentTrainers) ? 'selected' : ''}}>{{$trainer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thumbnailImage" class="col-sm-2 col-form-label">Thumbnail Image:</label>
                            <div class="col-sm-10">
                                <img src="{{public_path('images/thumbnail/') . $workshop->thumbnail}}">
                                <input type="file" name="courseThumbnailImage" class="form-control-file check-image-size" id="thumbnailImage" data-min-width="400" data-min-height="300" data-max-width="400" data-max-height="300" >
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Thumbnail image ratio should be 400px X 300px (width = 400px, height = 300px).</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subjects" class="col-sm-2 col-form-label">Workshop Type:</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" name="type" id="type">
                                    <option value="Online" {{$workshop->type=='Online' ? 'selected' : ''}}>Online</option>
                                    <option value="Offline" {{$workshop->type=='Offline' ? 'selected' : ''}}>Offline</option>
                                    <option value="Blended" {{$workshop->type=='Blended' ? 'selected' : ''}}>Blended</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">Duration:</label>
                            <div class="col-sm-10">
                                <input type="text" name="duration" value="{{$workshop->duration}}" class="form-control" id="duration" placeholder="Workshop duration">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">Total Credit Hours:</label>
                            <div class="col-sm-10">
                                <input type="text" name="total_credit_hours" value="{{$workshop->total_credit_hours}}" class="form-control" id="duration" placeholder="Total Credit Hours">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">Date & Time:</label>
                            <div class="col-sm-10">
                                <input type="text" name="date_time" value="{{$workshop->date_time}}" class="form-control" id="date_time" placeholder="Date & Time">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">Last date of application:</label>
                            <div class="col-sm-10">
                                <input type="date" name="last_date" value="{{$workshop->last_date}}" class="form-control" id="last_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">About This Workshop:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="about_this_workshop" name="about_this_workshop" placeholder="About This Workshop">
                                    {{$workshop->about_this_workshop}}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">What you will learn:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="what_you_will_learn" name="what_you_will_learn" placeholder="What you will learn">
                                    {{$workshop->what_you_will_learn}}
                                </textarea>
                            </div>
                        </div>
                        <a href="{{route('workshop.index')}}" class="btn btn-dark mb-4 px-4 py-2 shadow font-weight-bold text-white">Cancel</a>
                        <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Update</button>
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
        CKEDITOR.replace( 'about_this_workshop');
        CKEDITOR.replace( 'what_you_will_learn');
        // $("#thumbnailImage").checkImageSize({
        //     minWidth: 400,
        //     minHeight: 300,
        //     maxWidth: 400,
        //     maxHeight: 300,
        //     showError:true,
        //     ignoreError:false
        // });
        $('#trainer').select2({
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
