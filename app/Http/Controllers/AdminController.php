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
use App\Order;
use App\Resource;
use App\Revenue;
use App\TeacherStudentCount;
use App\Toolkit;
use App\ToolkitDocument;
use App\ToolkitQuestion;
use App\ToolkitQuiz;
use App\ToolkitQuizOption;
use App\ToolkitVideo;
use App\TrackHistory;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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


    function index(Request $request)
    {

        //        $username = $request->username;
        //
        //        $user_info = User::where('username', '=', $username)->first();
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {
            return abort(404);
        }

        $courses = Course::paginate(10);
        $toolkits = Toolkit::with('subject')->where('deleted', 0)->paginate(10);
        $resources = Resource::where('deleted', 0)->paginate(10);

        $revenue = Revenue::all()->sum('revenue');

        //TODO: one time script for transaction note field update
        //        $certificateOrders = Order::where('certificate', 1)->get();
        //
        //        foreach($certificateOrders as $order){
        //            $trackHistory = TrackHistory::where('user_id', $order->user_id)->where('course_toolkit_id', $order->product_id)->first();
        //            $trackHistory->certificate_withdrawn_date = $order->updated_at;
        //            $trackHistory->save();
        //        }
        //        $transactions = Transaction::all();
        //        foreach ($transactions as $transaction) {
        //            if($transaction->order_id != null){
        //                $order = Order::find($transaction->order_id);
        //                if(isset($order)) {
        //                    $transaction->note = $order->product_type;
        //                    $transaction->save();
        //                }
        //            }
        //        }
        //        one time script end




        return view('admin', compact('user_info', 'courses', 'toolkits', 'resources', 'revenue'));
    }

    public function userList()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        $allUser = User::all();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {

            return abort(404);
        }
        $revenue = Revenue::all()->sum('revenue');
        return view('admin.user-list', compact('user_info', 'allUser', 'revenue'));
    }

    public function basicInfo()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        $allUser = User::all();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {

            return abort(404);
        }
        $teacher_student_count = TeacherStudentCount::find(1);
        $jobPrice = JobPrice::find(1);

        $revenue = Revenue::all()->sum('revenue');
        return view('admin.basic_info', compact('teacher_student_count', 'user_info', 'jobPrice', 'revenue'));
    }

    public function leaderBoard()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {

            return abort(404);
        }
        $leaderboardUsers = LeaderBoard::with('user')->orderBy('position', 'asc')->limit(10)->get();

        $revenue = Revenue::all()->sum('revenue');

        return view('admin.leader_board', compact('leaderboardUsers', 'user_info', 'revenue'));
    }

    /**
     * view all jobs for admin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function adminJobList()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {

            return abort(404);
        }
        $jobs = Job::orderBy('id', 'desc')->get();
        $revenue = Revenue::all()->sum('revenue');
        $jobPrice = JobPrice::find(1);

        //        return $mytime = date('Y-m-d');

        $deadLineMin = Carbon::now()->format('Y-m-d');
        $deadLineMax = Carbon::now()->addMonth(1)->format('Y-m-d');
        $featuredJobCount = Job::where('featured', 1)->whereDate('deadline', '>', \Carbon\Carbon::today()->toDateString())->count();
        $schools = User::where('identifier', 2)->get();
        // return $schools;

        return view('admin.job-list', compact('jobs', 'user_info', 'revenue', 'jobPrice', 'deadLineMin', 'deadLineMax', 'featuredJobCount', 'schools'));
    }

    public function totalCountUpdate(Request $request, $id)
    {
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

    public function jobPriceUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'job_price' => 'required',
        ]);
        $jobPrice = JobPrice::find($id);
        $jobPrice->price = $request->job_price;

        $jobPrice->save();
        return redirect()->back()->with('jobSuccess', 'Job Price Updated Successfully ');
    }

    /**
     * course taker view for admin
     * @param $id
     */
    public function course_admin_view($id)
    {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        $revenue = Revenue::all()->sum('revenue');
        $histories = TrackHistory::where('course_or_toolkit',1)->where('course_toolkit_id', $id)->orderBy('id', 'DESC')->get();

        return view('course.admin_view', compact('user_info', 'revenue', 'histories'));
    }

    /**
     * toolkit taker view for admin
     * @param $id
     */
    public function toolkit_admin_view($id)
    {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        $revenue = Revenue::all()->sum('revenue');
        $histories = TrackHistory::where('course_or_toolkit',0)->where('course_toolkit_id', $id)->orderBy('id', 'DESC')->get();

        return view('toolkit.admin_view', compact('user_info', 'revenue', 'histories'));
    }

    /**
     * transaction lists
     * @param $id
     */
    public function transactions()
    {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && $user_info->identifier != 101) {
            return abort(404);
        }

        $revenue = Revenue::all()->sum('revenue');

        $transactions = Transaction::where('status','!=','Pending')->get();

        return view('admin.transactions', compact('user_info', 'revenue', 'transactions'));
    }

    /**
     * Revenue
     * @param $id
     */
    public function revenue()
    {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && $user_info->identifier != 101) {
            return abort(404);
        }

        $revenue = Revenue::all()->sum('revenue');
        $revenueList = Revenue::all();

        foreach ($revenueList as $item) {
            $order = Order::find($item->order_id);
            if (isset($order)) {
                $item->product_type = $order->product_type;
            }
        }
        //        return $revenueList;

        return view('admin.revenue_list', compact('user_info', 'revenue', 'revenueList'));
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

    public function courseActivist()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {

            return abort(404);
        }
        $activists = CourseActivist::all();
        $revenue = Revenue::all()->sum('revenue');

        return view('admin.course-activists', compact('user_info', 'activists', 'revenue'));
    }

    public function courseActivistCreate()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {

            return abort(404);
        }

        return view('admin.course-activists-create', compact('user_info'));
    }

    public function courseActivistStore(Request $request)
    {
        $userId = Auth::id();
        $this->validate($request, [
            'name'    => 'required',
            'type'    => 'required',
            'image'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = $request->file('image');
        $image_name = $request->type . '_' . md5(rand()) . '.' . $image->getClientOriginalExtension();

        $image->move(public_path("images/course_activist_image"), $image_name);

        $activist = [
            'name'          => $request->name,
            'description'   => $request->description,
            'type'          => $request->type,
            'image'         => $image_name,
        ];
        CourseActivist::create($activist);

        return redirect()->back()->with('success', $request->type . ' Created Successfully ');
    }

    public function courseActivistDestroy($id)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {

            return abort(404);
        }
        $activist = CourseActivist::find($id);

        //user image delete
        $image = 'images/course_activist_image/' . $activist->image;
        File::delete($image);

        $activist->delete();

        return redirect()->back()->with('success', $activist->type . ' Deleted Successfully ');
    }
}
