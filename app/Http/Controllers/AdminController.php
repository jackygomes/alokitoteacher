<?php

namespace App\Http\Controllers;

use App\CourseDocument;
use App\CourseQuestion;
use App\CourseQuiz;
use App\CourseQuizOption;
use App\CourseVideo;
use App\Toolkit;
use App\ToolkitDocument;
use App\ToolkitQuestion;
use App\ToolkitQuiz;
use App\ToolkitQuizOption;
use App\ToolkitVideo;
use App\TrackHistory;
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


        $toolkits = Toolkit::with('subject')->paginate(5);

//        return $toolkits;
        return view ('admin',compact( 'user_info', 'courses', 'toolkits'));
    }


    /** toolkit content or course content return
     * ajax request method
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Throwable
     */
    public function load_content(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $course_toolkit = $request->course_toolkit;

        if ($course_toolkit == 'course') {
            if ($type == 1) {
                return CourseVideo::find($id);
            } elseif ($type == 2) {
                return CourseDocument::find($id);
            } else {
                $quiz_details = CourseQuiz::find($id);
                $questions = CourseQuestion::where('quiz_id', '=', $quiz_details->id)->get();
                $count = $questions->count();

                return response()->json([
                    'html' => view('course.quiz_edit', compact('quiz_details', 'questions', 'count'))->render(),
                ]);
            }

        } else {
            if ($course_toolkit == 'toolkit') {
                if ($type == 1) {
                    return ToolkitVideo::find($id);
                } elseif ($type == 2) {
                    return ToolkitDocument::find($id);
                } else {
                    $quiz_details = ToolkitQuiz::find($id);
                    $questions = ToolkitQuestion::where('quiz_id', '=', $quiz_details->id)->get();
                    $count = $questions->count();
//                    return $count;
                    return response()->json([
                        'html' => view('toolkit.toolkit_quiz_edit', compact('quiz_details', 'questions', 'count'))->render(),
                    ]);
                }

            } else {
                return 'Error';
            }
        }


    }

    /** returns all questions for toolkit or course
     * ajax request method
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Throwable
     */
    public function load_question(Request $request)
    {
        $course_toolkit = $request->course_toolkit;

        if ($course_toolkit == 'course') {
            $quiz_details = CourseQuiz::find($request->quiz_id);
            $questions = CourseQuestion::where('quiz_id', '=', $quiz_details->id)->get();

            return response()->json([
                'html' => view('course.question_edit', compact('questions'))->render(),
            ]);
        } else {
            if ($course_toolkit == 'toolkit') {

                $quiz_details = ToolkitQuiz::find($request->quiz_id);
                $questions = ToolkitQuestion::where('quiz_id', '=', $quiz_details->id)->get();

                return response()->json([
                    'html' => view('toolkit.toolkit_question_edit', compact('questions'))->render(),
                ]);
            } else {
                return 'Error';
            }
        }

    }




}
