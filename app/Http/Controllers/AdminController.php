<?php

namespace App\Http\Controllers;

use App\CourseActivist;
use App\CourseDocument;
use App\CourseQuestion;
use App\CourseQuiz;
use App\CourseQuizOption;
use App\CourseVideo;
use App\JobPrice;
use App\LeaderBoard;
use App\Resource;
use App\TeacherStudentCount;
use App\Toolkit;
use App\ToolkitDocument;
use App\ToolkitQuestion;
use App\ToolkitQuiz;
use App\ToolkitQuizOption;
use App\ToolkitVideo;
use App\TrackHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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

//        $username = $request->username;
//
//        $user_info = User::where('username', '=', $username)->first();
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }

        $courses = Course::paginate(10);
        $toolkits = Toolkit::with('subject')->paginate(10);
        $resources = Resource::paginate(10);
//        return $user_info;
        return view ('admin',compact( 'user_info', 'courses', 'toolkits', 'resources'));
    }

    public function userList() {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        $allUser = User::all();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }

        return view('admin.user-list', compact('user_info', 'allUser'));
    }

    public function basicInfo() {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        $allUser = User::all();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }
        $teacher_student_count = TeacherStudentCount::find(1);
        $jobPrice = JobPrice::find(1);

        return view('admin.basic_info', compact('teacher_student_count','user_info','jobPrice'));
    }

    public function leaderBoard() {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }
        $leaderboardUsers = LeaderBoard::with('user')->orderBy('position', 'asc')->limit(10)->get();

        return view('admin.leader_board', compact('leaderboardUsers', 'user_info'));
    }

    public function totalCountUpdate(Request $request, $id) {
        $this->validate($request, [
            'teacher' => 'required',
            'future_number' => 'required',
        ]);
        $stat = TeacherStudentCount::find($id);
        $stat->teacher = $request->teacher;
        $stat->future_number = $request->future_number;

        $stat->save();

        return redirect()->back()->with('success', 'Stat Updated Successfully');
    }

    public function jobPriceUpdate(Request $request, $id) {
        $this->validate($request, [
            'job_price' => 'required',
        ]);
        $jobPrice = JobPrice::find($id);
        $jobPrice->price = $request->job_price;

        $jobPrice->save();
        return redirect()->back()->with('jobSuccess', 'Job Price Updated Successfully ');
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

    public function courseActivist(){
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }
        $activists = CourseActivist::all();

        return view('admin.course-activists',compact('user_info','activists'));
    }

    public function courseActivistCreate(){
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }

        return view('admin.course-activists-create',compact('user_info'));
    }

    public function courseActivistStore(Request $request){
        $userId = Auth::id();
        $this->validate($request, [
            'name'    => 'required',
            'type'    => 'required',
            'image'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = $request->file('image');
        $image_name = $request->type.'_'.md5(rand()).'.'.$image->getClientOriginalExtension();

        $image->move(public_path("images/course_activist_image"), $image_name);

        $activist = [
            'name'          => $request->name,
            'description'   => $request->description,
            'type'          => $request->type,
            'image'         => $image_name,
        ];
        CourseActivist::create($activist);

        return redirect()->back()->with('success', $request->type.' Created Successfully ');
    }

    public function courseActivistDestroy($id){
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }
        $activist = CourseActivist::find($id);

        //user image delete
        $image = 'images/course_activist_image/'.$activist->image;
        File::delete($image);

        $activist->delete();

        return redirect()->back()->with('success', $activist->type.' Deleted Successfully ');

    }

}
