@extends('master')
@section('content')

<div class="container-fluid">

    <div class="row">
        @include('includes.dashboard.admin')

        <div class="col-md-9 col-sm-12 mt-4">
            <div class="container-fluid">
                <div class="row">
                    
                    <h3>Update Blog:</h3>
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
                    
                    <form action="{{ route('blog.update') }}" method="post" enctype="multipart/form-data" style="width: 100%;">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="id" value="{{$blog->id}}">
                        <div class="form-group row">
                            <label for="courseName" class="col-sm-2 col-form-label">Blog Title:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name" value="{{$blog->name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseDescription" class="col-sm-2 col-form-label">Short Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="short_description" placeholder="Short Description" id="short_description" rows="2">{{$blog->short_description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thumbnail_image" class="col-sm-2 col-form-label">Image:</label>
                            <div class="col-sm-10">
                                <img style="width: 300px;" src="{{ url('images/thumbnail') }}/{{$blog->thumbnail}}" alt="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thumbnailImage" class="col-sm-2 col-form-label">Change Thumbnail Image:</label>
                            <div class="col-sm-10">
                                <input type="file" name="thumbnail" class="form-control-file check-image-size" id="thumbnail" data-min-width="1160" data-min-height="542" data-max-width="1160" data-max-height="542" >
                                <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Thumbnail image ratio should be 1160px X 542px (width = 1160px, height = 542px).</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseDescription" class="col-sm-2 col-form-label">Content:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="content" placeholder="Content" id="content" rows="3">{{$blog->content}}</textarea>
                            </div>
                        </div>
                        <a href="{{route('blog.index')}}" class="btn btn-dark mb-4 px-4 py-2 shadow font-weight-bold text-white">Cancel</a>
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
        CKEDITOR.replace( 'content');
        $("#thumbnail").checkImageSize({
            minWidth: 1160,
            minHeight: 542,
            maxWidth: 1160,
            maxHeight: 542,
            showError:true,
            ignoreError:false
        });
    });
</script>

@endpush
@endsection