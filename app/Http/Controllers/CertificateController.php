<?php

namespace App\Http\Controllers;

use App\Course;
use App\Order;
use App\Question;
use App\TrackHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * certificate purchase page with already enrolled course entry to order table
     * @param $courseId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|void
     */
    public function certificate($courseId)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && $user_info->identifier != 1) {

            return abort(404);
        }
        try {
            $achievements = DB::select("SELECT * FROM (SELECT courses.title, courses.id, (SELECT count(*) FROM course_quizzes WHERE course_quizzes.course_id = courses.id) AS total_quizzes, count(course_histories.id) AS completed_quizzes, sum(course_histories.points) AS gained_points, sum((SELECT count(*) FROM course_questions WHERE course_quizzes.id = course_questions.quiz_id)) AS total_questions FROM courses JOIN course_quizzes ON courses.id = course_quizzes.course_id JOIN course_histories ON course_quizzes.id = course_histories.quiz_id WHERE course_histories.user_id = " . $user_info->id . " GROUP BY courses.id) a WHERE a.completed_quizzes = a.total_quizzes ");


            $newAchievements = collect($achievements);

            $achievement = $newAchievements->filter( function ($course) use ($courseId) {
               return $course->id == $courseId;
            })->values()[0];

//            return $achievement;

            $courseScore = round((($achievement->gained_points / ($achievement->total_questions * 2)) * 100), 1);

            $course = Course::find($courseId);
            $courseItem = Order::where('user_id', $userId)->where('product_id', $courseId)->first();
            if (!$courseItem) {
                $orderData = [
                    'user_id' => Auth::id(),
                    'product_type' => 'course',
                    'product_id' => $course->id,
                    'amount' => $course->price,
                    'status' => 'paid',
                    'transaction_id' => "ALOKITO_" . uniqid(),
                    'currency' => 'BDT'
                ];
                $courseItem = Order::create($orderData);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 420);
        }

        return view('certificate.certificate', compact('courseScore', 'courseId', 'course', 'courseItem', 'user_info'));
    }

    /**
     * certificate purchase function
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function certificatePurchase(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required',
            'certificate_price' => 'required',
        ]);
        $user = User::find(Auth::id());
        try {
            if ($user->balance >= $request->certificate_price) {
                $orderItem = Order::find($request->order_id);

                $orderItem->certificate = 1;
                $orderItem->amount += $request->certificate_price;
                $orderItem->save();

                $user->balance -= $request->certificate_price;
                $user->save();

                $trackHistory = TrackHistory::where('user_id',Auth::id())->where('course_toolkit_id',$orderItem->product_id)->first();
                if($trackHistory != null){

                    $trackHistory->certificate_withdrawn = date('Y-m-d H:i:s');
                    $trackHistory->save();
                }

                return redirect()->back()->with('success', 'Purchase Successful');
            } else {
                return redirect()->back()->with('error', 'Insufficient Balance');
            }
        } catch (\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

//        return $request->all();
    }
}
