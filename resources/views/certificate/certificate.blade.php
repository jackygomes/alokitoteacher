@extends('master')
@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css?family=Lato');
        /* latin-ext */
        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v16/S6uyw4BMUTPHjxAwXjeu.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v16/S6uyw4BMUTPHjx4wXg.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        #certificate-wrap-1, #certificate-wrap-2 {
            font-family: 'lato';
            background-image: url("{{asset('images/certificate/border1.png')}}");
            height: 640px;
            width: 900px;
            background-size: 100% 100%;
            /*margin: 40px auto;*/
            margin-bottom: 50px;
            padding: 14px 9px;
            color: #58595b;
        }
        .inner-wrap {
            background-color: #fffcf6;
            margin: 5px 5px 0px 6px;
            height: 99%;
        }
        .top-section {
            padding: 10px;
            overflow: hidden;
        }
        .top-left, .top-right {
            width: 45%;
            float: left;
        }
        .top-right{
            float: right;
            text-align: right;
        }
        .top-left ul, .top-right ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .top-right.other-certificate ul li {
            width: 22%;
        }
        .top-left ul li, .top-right ul li {
            display: inline-block;
            width: 28%;
        }
        .top-left ul li img, .top-right ul li img {
            display: block;
            width: 100%;
        }
        .middle-section {
            /*margin-top: 35px;*/
            text-align: center;
        }
        .middle-section h2 {
            font-size: 46px;
            margin: 0;
        }
        .bold {font-weight: bold;}
        .certificate-heading p {
            font-size: 24px;
            margin: 0;
            letter-spacing: 5px;
        }
        .gold-badge img {
            width: 20px;
        }
        .middle-section .info p {
            margin-bottom: 0;
        }
        .middle-section .info .person-name {
            font-size: 28px;
        }
        .middle-section .info {
            width: 80%;
            margin: 0 auto;
        }
        .top-border {
            border-top: 1px dotted black;
            margin-top: 8px;
        }
        .middle-section .info .course-name {
            font-size: 30px;
        }
        .bottom-section {
            width: 100%;
            padding: 0 20px;
            overflow: hidden;
            margin-top: 20px;
        }
        .bottom-left, .bottom-right {
            width: 40%;
            text-align: center;
            overflow: hidden;
            float: left;
        }
        .bottom-right {float:right}
        .bottom-section .bottom-right img { width: 223px; }
        .bottom-section .bottom-right .brig { margin: 16px 0; }
        .bottom-section .bottom-right .mannan { margin: 13px 0; }
        .bottom-section .azwa {width:110px; margin-bottom: 3px;}
        .bottom-section .top-border { margin-top: 0; margin-bottom: 4px;}
        .designation { font-size: 11px;}
    </style>
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

                @if($user_info->id == Auth::id())

                    <form method="post" id="pro_pic_upload_form" action="{{ url('upload_picture') }}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <!-- <div class="form-group mt-3">
            <input type="file" class="text-center center-block mx-auto" name="image">
            <input type="submit" class="btn background-yellow text-white mt-2" value="Upload">
          </div> -->
                        <input type="file" name="image" id="profile_picture" class="d-none">
                        <button type="button" id="pro_pic_choose" class="btn bg-white mt-2 mb-3">Upload</button>
                    </form>

                    <a href="{{ url('settings') }}" class="text-dark float-right mt-3"><i class="fas fa-pen" ></i> <small>Edit Details</small></a>

                @endif


                <h3 class="mt-5 font-weight-bold text-white"> {{$user_info->name}}</h3>

                @for($i = 1; $i <= 5; $i++)
                    @if($user_info->rating - $i >= 0)
                        <i class="fa fa-star" aria-hidden="true"></i>
                    @else
                        <i class="far fa-star text-white"></i>
                    @endif
                @endfor

                <div class="row text-left p-2 mt-3">

                    <div class="col-2 mt-3">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <div class="col-10 mt-3">
                        @if($user_info->date_of_birth != null) {{ date("jS F, Y", strtotime($user_info->date_of_birth)) }} @else - @endif
                    </div>
                </div>

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




                    <h4 class="mt-3">Current Balance </h4>
                    <p>{{ round($user_info->balance, 2) }}</p>
                    <div class="">
                        <a href="{{route('deposit.form')}}" class=" btn btn-success btn-sm"style="display: inline-block" >Deposit</a>
                        <button type="button" class="  btn btn-danger btn-sm">Withdraw</button>
                    </div>
                @endif


            </div>

            <div class="col-md-9 col-sm-12 mt-5">
                <div class="container-fluid">
                    <div class="row">
                        @if($message = Session::get('success'))
                            <div class="alert alert-success">
                                {{$message}}
                            </div>
                        @elseif($message = Session::get('error'))
                            <div class="alert alert-danger">
                                {{$message}}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        @if($course->certificate_price == 0)
                            @if($courseItem->certificate == 0)
                            <div class="col-md-12">
                                <h3>Certificate is Free.</h3>
                            </div>
                            @endif
                        @else
                            @if($courseItem->certificate == 0)
                            <div class="col-md-12">
                                <h3>Purchase Certificate</h3>
                            </div>
                            <div class="col-md-12">

                                <p style="font-size: 18px;">Certificate price is {{round($course->certificate_price, 2)}} BDT.</p>

                            </div>
                            @endif
                        @endif
                        <div class="col-md-12">
                            @if($courseItem->certificate == 0)
                                @if($course->certificate_price == 0)
                                    <p style="font-size: 18px;">Click "Purchase" to get your certificate now.</p>
                                @else
                                    <p style="font-size: 18px;">If you want to purchase certificate click "Purchase" button.</p>
                                @endif
                                <p style="font-size: 18px;">Please fix your name from profile setting before you download your certificate.</p>
                                <form action="{{route('certificate.purchase')}}" onclick="return confirm('Are you sure to purchase this certificate? if yes then click ok.')" method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$courseItem->id}}">
                                    <input type="hidden" name="certificate_price" value="{{$course->certificate_price}}">
                                    <button type="submit" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Purchase</button>
                                </form>
                            @else
                                <p style="font-size: 18px;">Download your certificate.</p>
                                <p style="font-size: 18px;">Please fix your name from profile setting before you download your certificate.</p>
                                @if($courseId == 3)
                                <button type="button" onClick="downloadPdf(2)" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Download</button>
                                @else
                                <button type="button" onClick="downloadPdf(1)" class="btn background-yellow mb-4 px-4 py-2 shadow font-weight-bold text-white">Download</button>
                                @endif
                            @endif
                        </div>

                    </div>
                </div>
                @if($courseItem->certificate != 0)
                @if($courseId != 3)
                <div class="container-fluid ">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="certificate-wrap-1">
                                    <div class="inner-wrap">
                                    <div class="top-section">
                                        <div class="top-left">
                                            <ul>
                                                <li><img src="{{asset('images/certificate/alokito_teacher.png')}}" alt=""></li>
                                            </ul>
                                        </div>
                                        <div class="top-right">
                                            <ul>
                                                <li><img src="{{asset('images/certificate/alokito_hridoy.png')}}" alt=""></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="middle-section">
                                        <div class="certificate-heading">
                                            <h2><span class="bold">CERTIFICATE</span></h2>
                                            <p>OF PARTICIPATION</p>
                                        </div>
                                        <p>This is to certify that</p>
                                        <div class="info">
                                            <p class="person-name">{{$user_info->name}}</p>
                                            <p class="top-border">has successfully completed
                                                @if($courseScore >= 85)
                                                <span class="gold-badge">with a gold badge<img src="{{asset('images/certificate/gold-badge.png')}}" alt=""></span>
                                                @endif
                                                the online course on</p>
                                            <p class="course-name bold">{{$course->title}}</p>
                                        </div>
                                    </div>
                                    <div class="bottom-section">
                                        <div class="bottom-left">
                                            <img class="azwa" src="{{asset('images/certificate/Azwa_nayeem.png')}}" alt="">
                                            <p class="top-border">Azwa Nayeem</p>
                                            <p class="designation">Chairperson <br>Alokito Hridoy Foundation</p>
                                        </div>
                                        <div class="bottom-right">
                                            <img class="brig" src="{{asset('images/certificate/abu_nayeem.png')}}" alt="">
                                            <p class="top-border">Brig. Gen. Abu Nayeem Md. Shahidullah(Retd.)</p>
                                            <p class="designation">Vice Chairman <br>Alokito Hridoy Foundation</p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="certificate-wrap-2">
                                    <div class="inner-wrap">
                                    <div class="top-section">
                                        <div class="top-left">
                                            <ul>
                                                <li><img src="{{asset('images/certificate/alokito_teacher.png')}}" alt=""></li>
                                                <li><img src="{{asset('images/certificate/alokito_hridoy.png')}}" alt=""></li>
                                            </ul>
                                        </div>
                                        <div class="top-right other-certificate">
                                            <ul>
                                                <li><img src="{{asset('images/certificate/mutho_path.png')}}" alt=""></li>
                                                <li><img src="{{asset('images/certificate/a2i.png')}}" alt=""></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="middle-section">
                                        <div class="certificate-heading">
                                            <h2><span class="bold">CERTIFICATE</span></h2>
                                            <p>OF PARTICIPATION</p>
                                        </div>
                                        <p>This is to certify that</p>
                                        <div class="info">
                                            <p class="person-name">{{$user_info->name}}</p>
                                            <p class="top-border">has successfully completed
                                                @if($courseScore >= 85)
                                                    <span class="gold-badge">with gold badge<img src="{{asset('images/certificate/gold-badge.png')}}" alt=""></span>
                                                @endif
                                                   the online course on</p>
                                            <p class="course-name bold">{{$course->title}}</p>
                                        </div>
                                    </div>
                                    <div class="bottom-section">
                                        <div class="bottom-left">
                                            <img class="azwa" src="{{asset('images/certificate/Azwa_nayeem.png')}}" alt="">
                                            <p class="top-border">Azwa Nayeem</p>
                                            <p class="designation">Chairperson <br>Alokito Hridoy Foundation</p>
                                        </div>
                                        <div class="bottom-right">
                                            <img class="mannan" src="{{asset('images/certificate/abdul_mannan.png')}}" alt="">
                                            <p class="top-border">Dr. Md Abdul Mannan(PAA)</p>
                                            <p class="designation">Joint Secretary and Project Director Access to Information(a2i) Programme ICT Division</p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
        <script type="application/javascript">
            // function downloadPdf(id){
            //     // Initiate PDF create and Download
            //     const filename  = 'certificate.pdf';
            //     html2canvas(document.querySelector('#certificate-wrap-'+id ),
            //         {scale: 2, dpi:144}
            //     ).then(canvas => {
            //         const imgData = canvas.toDataURL('image/png');
            //         const pdf = new jsPDF({
            //             orientation: 'Landscape',
            //             quality:4
            //         });
            //         const imgProps= pdf.getImageProperties(imgData);
            //         const pdfWidth = pdf.internal.pageSize.getWidth();
            //         const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            //         // pdf.addImage(imgData, 'PNG', 40, -100, pdfWidth, pdfHeight,'','Slow', -90);
            //         pdf.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight);
            //         pdf.internal.scaleFactor = 1.55
            //         pdf.save(filename);
            //     });
            // };
            function downloadPdf(id) {
                var node = document.querySelector('#certificate-wrap-'+id);
                var options = {
                    quality: 1,
                    bgcolor: '#FFFFFF',
                    style: {
                        margin: 0,
                    }
                };

                domtoimage.toJpeg(node, options).then(function (dataUrl)
                {
                    var doc = new jsPDF({
                        orientation: 'Landscape',
                    });
                    const imgProps= doc.getImageProperties(dataUrl);
                    const pdfWidth = doc.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                    doc.addImage(dataUrl, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    doc.save('certificate.pdf');
                })
            }
        </script>
    @endpush
@endsection
