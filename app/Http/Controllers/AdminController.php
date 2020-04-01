<?php

namespace App\Http\Controllers;

use App\CourseDocument;
use App\CourseQuestion;
use App\CourseQuiz;
use App\CourseQuizOption;
use App\CourseVideo;
use App\ToolkitDocument;
use App\ToolkitQuestion;
use App\ToolkitQuiz;
use App\ToolkitQuizOption;
use App\ToolkitVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Job;
use App\Course;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    function index(Request $request){

        $username = $request->username;

        $user_info = User::where('username', '=', $username)->first();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }

        $courses = Course::all();


        $toolkits = DB::table('toolkits')->join('subjects', 'subjects.id', '=', 'toolkits.subject_id')->paginate(5);


        return view ('admin',compact( 'user_info', 'courses', 'toolkits'));
    }

    public function course_edit($id)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }

        $info = Course::find($id);
//        $info = Course::where("id", $id)->with('videos')->first();
//        $info = Course::where("id", $id)->with('videos');
//        return $info;

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

//        return $contents;
//        $post = Post::find($id);
        return view('course_edit',compact( 'user_info','info', 'contents'));
    }

    function course_update(Request $request, $id) {


        $courseVideo = CourseVideo::find($id);
        $courseVideo->url = $request->input('url');
        $courseVideo->video_title = $request->input('title');
        $courseVideo->short_description = $request->input('description');

        $courseId = $request->input('course_id');


        $courseVideo->save();
        return redirect()->route('course.edit', $courseId);

    }

    function course_quiz_update (Request $request, $id) {

        $courseId = $id;
        $quizId = $request->input('quiz_id');
        $courseQuiz = CourseQuiz::find($quizId);
        $courseQuiz->quiz_title = $request->input('quiz_name');

        $courseQuiz->save();

        $questionId = $request->input('quiz_question_id');
        $courseQuestion = CourseQuestion::find($questionId);
        $courseQuestion->query = $request->input('quiz_question');

        $courseQuestion->save();

        $optionCount = count($request->input('optionsId'));


        for($x = 0; $x < $optionCount; $x++) {
            $id = $request->input('optionsId.'.$x);
            $courseQuestionOption = CourseQuizOption::find($id);
            $courseQuestionOption->question_option = $request->input('options.'.$x);

            $courseQuestionOption->save();
        }

        return redirect()->route('course.edit', $courseId);

    }

    function load_content(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $course_toolkit = $request->course_toolkit;

//        return "found type 1";

        if ($course_toolkit == 'course') {
            if ($type == 1) {
                return CourseVideo::find($id);
            } elseif ($type == 2) {
                return CourseDocument::find($id);
            } else {
                $quiz_details = CourseQuiz::find($id);
                $questions = CourseQuestion::where('quiz_id', '=', $quiz_details->id)->get();
                $count = $questions->count();

                //$quiz_result =  CourseHistory::where('quiz_id', '=', $quiz_details->id)->first();


                return response()->json([
                    'html' => view('quiz_edit', compact('quiz_details', 'questions', 'count'))->render(),
                ]);
            }

        } else {
            if ($course_toolkit == 't') {
                if ($type == 1) {
                    return ToolkitVideo::find($id);
                } elseif ($type == 2) {
                    return ToolkitDocument::find($id);
                } else {
                    $quiz_details = ToolkitQuiz::find($id);
                    $questions = ToolkitQuestion::where('quiz_id', '=', $quiz_details->id)->get();
                    $count = $questions->count();

                    return response()->json([
                        'html' => view('quiz_edit', compact('quiz_details', 'questions', 'count'))->render(),
                    ]);
                }

            } else {
                return 'Error';
            }
        }


    }
    function load_question(Request $request)
    {
        $course_toolkit = $request->course_toolkit;

        if ($course_toolkit == 'course') {
            $quiz_details = CourseQuiz::find($request->quiz_id);
            $question = CourseQuestion::where('quiz_id', '=',
                $quiz_details->id)->offset($request->serial)->limit($request->serial)->first();
            $options = CourseQuizOption::where('question_id', '=', $question->id)->get();

            return response()->json([
                'question' => $question,
                'options' => $options,
            ]);
        } else {
            if ($course_toolkit == 't') {
                $quiz_details = ToolkitQuiz::find($request->quiz_id);
                $question = ToolkitQuestion::where('quiz_id', '=',
                    $quiz_details->id)->offset($request->serial)->limit($request->serial)->first();
                $options = ToolkitQuizOption::where('question_id', '=', $question->id)->get();

                return response()->json([
                    'question' => $question,
                    'options' => $options,
                ]);
            } else {
                return 'Error';
            }
        }

    }




}
