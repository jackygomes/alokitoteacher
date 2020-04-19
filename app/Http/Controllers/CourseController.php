<?php

namespace App\Http\Controllers;

use App\CourseQuestion;
use App\CourseQuiz;
use App\CourseQuizOption;
use App\CourseVideo;
use App\Subject;
use App\Toolkit;
use App\ToolkitVideo;
use App\TrackHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Course;



class CourseController extends Controller
{




    function index(){

	    $course_info = DB::table('users')
	    ->rightJoin('courses', 'users.id', '=','courses.user_id')
	    ->leftJoin('course_ratings', 'courses.id', '=', 'course_ratings.course_id')
	    ->select('users.id','users.name','users.email', 'users.image','users.phone_number','users.balance','users.username','courses.id','courses.thumbnail','courses.title','courses.description','courses.price','courses.slug', DB::raw('avg(course_ratings.rating) as rating'))
	    ->groupBy('courses.id')
	    ->paginate(4);

	    return view ('courses',compact('course_info'));
	    //return var_dump($data);

	}

//	Admin Functions
    public function create () {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }

        return view('course.create', compact('user_info'));
    }

    public function course_edit($id)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }

        $info = Course::find($id);

        $videos = DB::table('course_videos')
            ->select('id', 'video_title as title', 'sequence', DB::raw('1 as type'))
            ->where('course_id', '=', $info->id);


        $documents = DB::table('course_documents')
            ->select('id', 'doc_title as title', 'sequence', DB::raw('2 as type'))
            ->where('course_id', '=', $info->id);

        $contents = DB::table('course_quizzes')
            ->select('id', 'quiz_title as title', 'sequence', DB::raw('3 as type'))
            ->where('course_id', '=', $info->id)
            ->union($documents)
            ->union($videos)
            ->orderBy('sequence', 'ASC')
            ->get();

        return view('course.course_edit',compact( 'user_info','info', 'contents'));
    }

    public function course_update(Request $request, $id) {


        $courseVideo = CourseVideo::find($id);
        $courseVideo->url = $request->input('url');
        $courseVideo->video_title = $request->input('title');
        $courseVideo->short_description = $request->input('description');

        $courseId = $request->input('course_id');


        $courseVideo->save();
        return redirect()->route('course.edit', $courseId);

    }

    public function course_quiz_update (Request $request, $id)
    {

        $courseId = $id;
        $quizId = $request->input('quiz_id');
        $courseQuiz = CourseQuiz::find($quizId);
        $courseQuiz->quiz_title = $request->input('quiz_name');

        $courseQuiz->save();

        $questionCount = count($request->input('questionIds'));

        for($x = 0; $x < $questionCount; $x++) {
            $id = $request->input('questionIds.'.$x);
            $courseQuestion = CourseQuestion::find($id);
            $courseQuestion->query = $request->input('questions.'.$x);
            $courseQuestion->correct_option = $request->input('correctOption_'.$id);

            $courseQuestion->save();
        }

        $optionCount = count($request->input('optionsIds'));
        for($x = 0; $x < $optionCount; $x++) {
            $id = $request->input('optionsIds.'.$x);
            $courseQuestionOption = CourseQuizOption::find($id);
            $courseQuestionOption->question_option = $request->input('options.'.$x);

            $courseQuestionOption->save();
        }


        return redirect()->route('course.edit', $courseId);

    }
}
