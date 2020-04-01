<!DOCTYPE html>
<html>
<head>
    <title>Alokito Teachers</title>
</head>
<body style="margin: 0px !important">
    <div style="background-color: #f5b82f; color: black; text-align: center; padding: 30px">
       <h1 style="font-weight: 1200;">Alokito Teachers</h1>
    </div>
    <div style="height: 50px; padding: 10%;">
        <p>Hello <strong>{{ $applicant->name }}</strong>. Congratulations!</p>
        <p>You have been selected for the position {{ $job->job_title }} in {{ Auth::user()->name }}. {{ Auth::user()->name }} will contact you soon.</p>

        <a href="{{ url('job_detail') }}/{{ $job->id }}">Click here to see the job details</a>
        
    </div>


    <div style="background-color: #f5b82f; color: black; text-align: center; padding: 30px; color: white">
        <p>© 2019 Alokito Teachers. All rights reserved.</p>
    </div>

</body>
</html>