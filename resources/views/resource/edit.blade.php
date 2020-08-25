@extends('master')
@section('content')
    <style>
        .edit-button {
            border: 1px solid #f5b82f;
            padding: 0px 6px;
            cursor: pointer;
        }
    </style>

    <div class="container-fluid">

        <div class="row">
            <div id="sidebarCol" class="col-md-4 order-2 order-md-1"
                 style="padding-left: 0 !important; min-height: 90vh;overflow-y: auto;">
                <div id="sidebar" class="background-yellow" style="min-height: 100%">

                    <div class="list-group list-group-flush">

                        @foreach($contents as $content)
                            @if($content->type == 1)
                                <div content="{{ $content->type }}"
                                     value="{{ $content->id }}"
                                     class="list-group-item list-group-item-action bg-light ItemButton"><i
                                        class=" float-left fas fa-play-circle text-yellow"
                                        style="font-size:22px;"></i> {{ $content->title }} <span
                                        type="{{ $content->type }}"
                                        id="{{ $content->id }}"
                                        class="edit-button float-right"><i
                                            class="fas fa-edit text-yellow" style="font-size:14px;"></i> edit</span>
                                </div>

                            @elseif($content->type == 2)
                                <div content="{{ $content->type }}"
                                     value="{{ $content->id }}"
                                     class="list-group-item list-group-item-action bg-light ItemButton"><i
                                        class="float-left fas fa-book text-yellow "
                                        style="font-size:22px;"></i> {{ $content->title }} <span
                                        type="{{ $content->type }}"
                                        id="{{ $content->id }}"
                                        class="edit-button float-right"><i class="fas fa-edit text-yellow"
                                                                           style="font-size:14px;"></i>edit</span>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>

            <div id="contentCol" class="col-md-8 order-1 order-md-2 mt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            @if(count($contents) < 1)
                                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addVideo">Add Video</button>
                                <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="addDocument">Add Document</button>
                            @endif
                            <button class="btn background-yellow mb-3 px-4 py-2 shadow font-weight-bold text-white" id="editResource">Edit Resource Info</button>
                        </div>
                    </div>
                    <div id="resourceSection">
                        <div class="row">
                            <h3>Edit Resource Information:</h3>
                        </div>
                        <div class="row">
                            @if($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{$message}}
                                </div>
                            @endif
                            @if($message = Session::get('warning'))
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <p>{{$error}}</p>
                                    @endforeach
                                </div>
                            @endif
                            <form action="{{ route('resource.update', $resource->id) }}" method="post" enctype="multipart/form-data" style="width: 100%;">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group row">
                                    <label for="resourceName" class="col-sm-2 col-form-label">Name:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="resource_name" class="form-control" value="{{$resource->resource_title}}" id="resourceName" placeholder="Resource Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="resourceDescription" class="col-sm-2 col-form-label">Description:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="resource_description" placeholder="Description" id="resourceDescription" rows="3">{{$resource->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Price" class="col-sm-2 col-form-label">Price:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="resource_price" class="form-control" value="{{$resource->price}}" id="Price" placeholder="Resource Price">
                                        <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Enter 0 in price field if the resource is free.</p>
                                    </div>
                                </div>

                                @if($user_info->identifier == 101)
                                    @php $statusOptions = ['Pending', 'Approved']; @endphp
                                    <div class="form-group row">
                                        <label for="subjects" class="col-sm-2 col-form-label">Status:</label>
                                        <div class="col-sm-10">
                                            <select class="custom-select mr-sm-2" name="status" id="status">
                                                @foreach($statusOptions as $options)
                                                    <option value="{{$options}}" {{$resource->status == $options ? "selected" : ""}}>{{$options}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label for="thumbnail_image" class="col-sm-2 col-form-label">Image:</label>
                                    <div class="col-sm-10">
                                        <img style="width: 300px;" src="{{ url('images/thumbnail') }}/{{$resource->thumbnail}}" alt="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="thumbnail_image" class="col-sm-2 col-form-label">Choose New Thumbnail Image:</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="thumbnailImage" class="form-control-file" id="thumbnail_image">
                                        <p style="margin: 5px 0 0; font-size: 14px; color: #721c24">* Thumbnail image ratio should be  750px X 450px (width = 750px, height = 450px).</p>
                                    </div>
                                </div>
                                <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white" id="quizButton">Update</button>
                            </form>
                        </div>
                    </div>

                    <div id="addContentSection">
                        <div id="videoSection">
                            <div class="row">
                                <h3>Create Video:</h3>
                            </div>
                            <form action="{{route('resource.video.create', $resource->id)}}" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class='form-group row'>
                                    <label class="col-sm-2 col-form-label">Url:</label>
                                    <div class="col-sm-10">
                                        <input name="url" class="form-control" placeholder="Enter Video Url" value="" required/>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label class="col-sm-2 col-form-label">Title:</label>
                                    <div class="col-sm-10">
                                        <input name="title" class="form-control" placeholder="Enter Video Title" value="" required/>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label class="col-sm-2 col-form-label">Description:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="description" placeholder="Enter Video Description" rows="3"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Create</button>
                            </form>
                        </div>

                        <div id="documentSection">
                            <div class="row">
                                <h3>Create Document:</h3>
                            </div>
                            <form action="{{route('resource.document.create', $resource->id)}}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class='form-group row'>
                                    <label class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10">
                                        <input name="title" class="form-control" placeholder="Enter Document Title" value="" required/>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="description" placeholder="Enter Document Description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="doc_file" class="col-sm-2 col-form-label">Document File:</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="doc_file" class="form-control-file" id="doc_file">
                                    </div>
                                </div>
                                <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Create</button>
                            </form>
                        </div>
                    </div>
                    <div id="content">


                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('js')

        <script type="text/javascript">
            $(document).ready(function(){
                $("#Price").keydown(function (event) {
                    // Allow Only: keyboard 0-9, numpad 0-9, backspace, tab, left arrow, right arrow, delete
                    if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46) {
                        // Allow normal operation
                    } else {
                        // Prevent the rest
                        event.preventDefault();
                    }
                });
            });

            $("#videoSection").hide();
            $("#documentSection").hide();
            $("#editResource").hide();

            $('#addVideo').on('click', function(e){
                $("#resourceSection").hide();
                $("#addVideo").hide();
                $("#documentSection").hide();
                $("#addDocument").show();
                $("#videoSection").show();
                $("#editResource").show();
            });
            $('#addDocument').on('click', function(e){
                $("#resourceSection").hide();
                $("#addDocument").hide();
                $("#videoSection").hide();
                $("#documentSection").show();
                $("#editResource").show();
                $("#addVideo").show();
            });
            $('#editResource').on('click', function(e){
                $("#videoSection").hide();
                $("#editResource").hide();
                $("#documentSection").hide();
                $("#content").hide();
                $("#addDocument").show();
                $("#addVideo").show();
                $("#resourceSection").show();
            });

            $('.edit-button').on('click', function (e) {
                $("#resourceSection").hide();
                $("#content").show();
                $('#editResource').show();

                var id = $(this).attr('id');
                var type = $(this).attr('type');

                loadContent(id, type);
            });

            function loadContent(id, type) {
                // type 1 = video
                // type 2 = document
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('resource/load_content') }}",
                    method: 'POST',
                    data: {
                        id: id,
                        type: type,
                        resource: '{{ Request::segment(1) }}'
                    },
                    success: function (result) {
                        console.log(result);
                        let actionUrl = "{{ route('resource.video.update', ':resultid') }}";
                        actionUrl = actionUrl.replace(":resultid", result.id);
                        let documentActionUrl = "{{ route('resource.document.update', ':resultid') }}";
                        documentActionUrl = documentActionUrl.replace(":resultid", result.id);


                        if (type == 1) {
                            let formHtml = "<form action='" + actionUrl + "' method='post'>" +
                                "<input type=\"hidden\" name=\"_token\" value=\"{{csrf_token()}}\">"+
                                "<div class='form-group'><label>Video Url</label><input name='url' class='form-control' value='" + result.url + "'/></div>" +
                                "<div class='form-group'><label>Video Title</label><input name='title' class='form-control' value='"+result.video_title+"'/></div>" +
                                "<div class='form-group'><label>Video Description</label><textarea name='description' class='form-control' rows=\"3\">"+result.description+"</textarea></div>" +
                                "<input type='hidden' name='resource_id' class='form-control' value='"+result.resource_id+"'/>"+
                                "<input type='hidden' name='id' class='form-control' value='"+result.id+"'/>"+
                                "<button type=\"submit\" class=\"btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white\">Update</button>"
                            "</form>";

                            $('#content').html(formHtml);

                        } else if (type == 2) {
                            let formHtml = "<form action='" + documentActionUrl + "' method='post' enctype=\"multipart/form-data\">" +
                                "<input type=\"hidden\" name=\"_token\" value=\"{{csrf_token()}}\">"+
                                "<div class='form-group'><label>Title</label><input name='title' class='form-control' value='"+result.doc_title+"'/></div>" +
                                "<div class='form-group'><label>Description</label><textarea name='description' class='form-control' rows=\"3\">"+result.description+"</textarea></div>" +
                                "<div class='form-group'><label>File</label><p style=\"margin: 5px 0 0; font-size: 14px; color: #721c24\">"+result.file+"</p></div>" +
                                "<div class='form-group'><label>Download and check file before approve</label></div>" +
                                "<a href=/documents/"+result.file+" class='btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white' download>Download</a></div>"+
                                "<div class='form-group'><label>Select New File To Replace Old File</label><input type='file' name='doc_file' class='form-control-file' id='doc_file'></div>" +
                                "<input type='hidden' name='resource_id' class='form-control' value='"+result.resource_id+"'/>"+
                                "<input type='hidden' name='id' class='form-control' value='"+result.id+"'/>"+
                                "<button type=\"submit\" class=\"btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white\">Update</button>"
                            "</form>";

                            $('#content').html(formHtml);
                        }
                    }
                });
            }
        </script>

    @endpush
@endsection
