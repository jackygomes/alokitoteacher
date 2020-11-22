<?php

namespace App\Http\Controllers;

use App\CourseActivist;
use App\Order;
use App\Utilities\LeaderBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use URL;
use App\User;
use App\Course;
use App\CourseVideo;
use App\CourseDocument;
use App\CourseQuiz;
use App\CourseQuestion;
use App\CourseQuizOption;
use App\CourseHistory;
use App\CourseRating;
use App\CoursePreview;

use App\Toolkit;
use App\ToolkitVideo;
use App\ToolkitDocument;
use App\ToolkitQuiz;
use App\ToolkitQuestion;
use App\ToolkitQuizOption;
use App\ToolkitHistory;
use App\ToolkitRating;

use App\TrackHistory;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    function index(Request $request)
    {

        if ($request->course_toolkit == 'c') {
            $info = Course::where('slug', '=', $request->slug)->first();

            if ($info == null) {
                return abort(404);
            }

            $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                ->where('course_or_toolkit', '=', 1)
                ->where('course_toolkit_id', '=', $info->id)
                ->first();

            if ($trackHistory == null) {
                return redirect('overview/c/' . $request->slug);
            }

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


            return view('extra', compact('info', 'contents'));

        } else {
            if ($request->course_toolkit == 't') {

                $info = Toolkit::where('slug', '=', $request->slug)->first();

                if ($info == null) {
                    return abort(404);
                }

                $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                    ->where('course_or_toolkit', '=', 0)
                    ->where('course_toolkit_id', '=', $info->id)
                    ->first();
                if ($trackHistory == null) {
                    return redirect('overview/t/' . $request->slug);
                }

                $videos = DB::table('toolkit_videos')
                    ->select('id', 'video_title as title', 'sequence', DB::raw('1 as type'))
                    ->where('toolkit_id', '=', $info->id);

                $documents = DB::table('toolkit_documents')
                    ->select('id', 'doc_title as title', 'sequence', DB::raw('2 as type'))
                    ->where('toolkit_id', '=', $info->id);

                $contents = DB::table('toolkit_quizzes')
                    ->select('id', 'quiz_title as title', 'sequence', DB::raw('3 as type'))
                    ->where('toolkit_id', '=', $info->id)
                    ->union($documents)
                    ->union($videos)
                    ->orderBy('sequence', 'ASC')
                    ->get();


                return view('extra', compact('info', 'contents'));

            } else {
                return abort(404);
            }
        }


    }

    function overview(Request $request)
    {

        if ($request->course_toolkit == 'c') {
            $info = Course::where('slug', '=', $request->slug)->first();

            $userId = Auth::check() ? Auth::user()->id : 0;
            $isOrdered = Order::where('status', 'paid')
                ->where('product_type', 'course')
                ->where('user_id', $userId)
                ->where('product_id', $info->id)->first();

            $info->isBought = $isOrdered ? 1 : 0;


            if ($info == null) {
                return abort(404);
            }

            $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                ->where('course_or_toolkit', '=', 1)
                ->where('course_toolkit_id', '=', $info->id)
                ->first();

            $video = CoursePreview::where('course_id', '=', $info->id)->first()->url;

            $thumbnailPart = '<div style="border: 2px solid #f5b82f" class="embed-responsive embed-responsive-16by9 "><iframe src="' . $video . '" width="1150" height="650" frameborder="0" allow="autoplay;   fullscreen" allowfullscreen></iframe></div>';

            $creator = User::find($info->user_id);

            $decodeFacilitators  = $info->course_facilitator == null ? [] : json_decode($info->course_facilitator) ;
            $decodeAdvisors     = $info->advisor == null ? [] : json_decode($info->advisor);
            $decodeDesigners    = $info->designer == null ? [] : json_decode($info->designer);

            $infoFacilitators = CourseActivist::where('type','Facilitator')->findMany($decodeFacilitators);
            $infoAdvisors = CourseActivist::where('type','Advisor')->findMany($decodeAdvisors);
            $infoDesigners = CourseActivist::where('type','Designer')->findMany($decodeDesigners);

            $content_rating = DB::table('course_ratings')
                ->where('course_id', '=', $info->id)
                ->avg('rating');

            return view('overview', compact('info','infoFacilitators','infoAdvisors','infoDesigners', 'thumbnailPart', 'creator', 'content_rating', 'trackHistory'));

        } else {
            if ($request->course_toolkit == 't') {

                $info = Toolkit::where('slug', '=', $request->slug)->first();

                $userId = Auth::check() ? Auth::user()->id : 0;
                $isOrdered = Order::where('status', 'paid')
                    ->where('product_type', 'toolkit')
                    ->where('user_id', $userId)
                    ->where('product_id', $info->id)->first();

                $info->isBought = $isOrdered ? 1 : 0;

                if ($info == null) {
                    return abort(404);
                }

                $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                    ->where('course_or_toolkit', '=', 0)
                    ->where('course_toolkit_id', '=', $info->id)
                    ->first();

                $thumbnailPart = '<img src="' . URL::to('/images/thumbnail') . '/' . $info->thumbnail . '" class="img-fluid">';

                $creator = User::find($info->user_id);

                $content_rating = DB::table('toolkit_ratings')
                    ->where('toolkit_id', '=', $info->id)
                    ->avg('rating');

                return view('overview', compact('info', 'thumbnailPart', 'creator', 'content_rating', 'trackHistory'));

            } else {
                return abort(404);
            }
        }


    }

    function load_content(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $course_toolkit = $request->course_toolkit;

        if ($course_toolkit == 'c') {
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
                    'html' => view('quiz', compact('quiz_details', 'questions', 'count'))->render(),
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
                        'html' => view('quiz', compact('quiz_details', 'questions', 'count'))->render(),
                    ]);
                }

            } else {
                return 'Error';
            }
        }


    }


    function load_result(Request $request)
    {
        $quiz_id = $request->quiz_id;
        $course_toolkit = $request->course_toolkit;

        $this->update_rating_of_user_table(Auth::id());

        if ($course_toolkit == 'c') {
            $quiz_result = CourseHistory::where('user_id', '=', Auth::id())->where('quiz_id', '=', $quiz_id)->first();
            $points = $quiz_result->points;
            $time = $quiz_result->time;
            $correct = $points / 2;
            $total_questions = CourseQuestion::where('quiz_id', '=', $quiz_id)->count();
            $wrong = $total_questions - $correct;

            return response()->json([
                'html' => view('quiz_result',
                    compact('points', 'total_questions', 'correct', 'wrong', 'time'))->render(),
            ]);


        } else {
            if ($course_toolkit == 't') {
                $quiz_result = ToolkitHistory::where('user_id', '=', Auth::id())->where('quiz_id', '=',
                    $quiz_id)->first();
                $points = $quiz_result->points;
                $time = $quiz_result->time;
                $correct = $points / 2;
                $total_questions = ToolkitQuestion::where('quiz_id', '=', $quiz_id)->count();
                $wrong = $total_questions - $correct;

                return response()->json([
                    'html' => view('quiz_result',
                        compact('points', 'total_questions', 'correct', 'wrong', 'time'))->render(),
                ]);

            } else {
                return 'Error';
            }
        }
    }

    function load_question(Request $request)
    {
        $course_toolkit = $request->course_toolkit;

        if ($course_toolkit == 'c') {
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

    function verify_question(Request $request)
    {
        $course_toolkit = $request->course_toolkit;

        $time = strtotime("00:02:00") - strtotime('00:' . $request->time);

        if ($course_toolkit == 'c') {
            $question_details = CourseQuestion::find($request->question_id);
            $quiz_id = $question_details->quiz_id;
            $correct_option = $question_details->correct_option;

            $course_history = CourseHistory::where('user_id', '=', Auth::id())->where('quiz_id', '=',
                $quiz_id)->first();

            if ($course_history == null) {
                $new_course_history = new CourseHistory;
                $new_course_history->user_id = Auth::id();
                $new_course_history->quiz_id = $quiz_id;
                $new_course_history->points = 0;
                $new_course_history->save();

            }

            $course_history = CourseHistory::where('user_id', '=', Auth::id())->where('quiz_id', '=',
                $quiz_id)->first();

            $course_history->time = date("H:i:s", strtotime($course_history->time) + $time);

            if ($correct_option == $request->correct_option) {
                $course_history->points = $course_history->points + 2;
            }
            $course_history->save();

        } else {
            if ($course_toolkit == 't') {
                $question_details = ToolkitQuestion::find($request->question_id);
                $quiz_id = $question_details->quiz_id;
                $correct_option = $question_details->correct_option;

                $toolkit_history = ToolkitHistory::where('user_id', '=', Auth::id())->where('quiz_id', '=',
                    $quiz_id)->first();

                if ($toolkit_history == null) {
                    $new_toolkit_history = new ToolkitHistory;
                    $new_toolkit_history->user_id = Auth::id();
                    $new_toolkit_history->quiz_id = $quiz_id;
                    $new_toolkit_history->points = 0;
                    $new_toolkit_history->save();
                }

                $toolkit_history = ToolkitHistory::where('user_id', '=', Auth::id())->where('quiz_id', '=',
                    $quiz_id)->first();

                $toolkit_history->time = date("H:i:s", strtotime($toolkit_history->time) + $time);

                if ($correct_option == $request->correct_option) {
                    $toolkit_history->points = $toolkit_history->points + 2;
                }
                $toolkit_history->save();
            }
        }

        return 'success';


    }


    function verify_track_history(Request $request)
    {
        $slug = $request->slug;
        $course_toolkit = $request->course_toolkit;
        if ($course_toolkit == 'c') {
            $course = Course::where('slug', '=', $slug)->first();
            $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                ->where('course_or_toolkit', '=', 1)
                ->where('course_toolkit_id', '=', $course->id)
                ->first();

            $retake = 60;

            if ($trackHistory == null) {
                return response()->json([
                    'status' => 'enroll',
                ]);
            } else {
                $retake = 30 - round((time() - strtotime($trackHistory->updated_at)) / (60 * 60 * 24));
            }

            return response()->json([
                'status' => 'success',
                'retake' => $retake,
                'sequence' => $trackHistory->current_sequence,
            ]);

        } else {
            if ($course_toolkit == 't') {
                $toolkit = Toolkit::where('slug', '=', $slug)->first();
                $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                    ->where('course_or_toolkit', '=', 0)
                    ->where('course_toolkit_id', '=', $toolkit->id)
                    ->first();

                $retake = 60;

                if ($trackHistory == null) {
                    return response()->json([
                        'status' => 'enroll',
                    ]);
                } else {
                    $retake = 30 - round((time() - strtotime($trackHistory->updated_at)) / (60 * 60 * 24));
                }


                return response()->json([
                    'status' => 'success',
                    'retake' => $retake,
                    'sequence' => $trackHistory->current_sequence,
                ]);

            }
        }
        return response()->json([
            'status' => 'failed',
        ]);
    }


    function update_track_history(Request $request)
    {
        $slug = $request->slug;
        $course_toolkit = $request->course_toolkit;
        if ($course_toolkit == 'c') {
            $course = Course::where('slug', '=', $slug)->first();
            $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                ->where('course_or_toolkit', '=', 1)
                ->where('course_toolkit_id', '=', $course->id)
                ->first();

            if ($trackHistory != null) {
                $trackHistory->current_sequence = $trackHistory->current_sequence + 1;
                $trackHistory->save();
            }


        } else {
            if ($course_toolkit == 't') {
                $toolkit = Toolkit::where('slug', '=', $slug)->first();
                $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                    ->where('course_or_toolkit', '=', 0)
                    ->where('course_toolkit_id', '=', $toolkit->id)
                    ->first();

                if ($trackHistory != null) {
                    $trackHistory->current_sequence = $trackHistory->current_sequence + 1;
                    $trackHistory->save();
                }

            }
        }
        return 'success';
    }

    function enroll_into_course(Request $request)
    {
        $slug = $request->slug;
        $course_toolkit = $request->course_toolkit;
        if ($course_toolkit == 'c') {
            $course = Course::where('slug', '=', $slug)->first();
            $trackHistory = new TrackHistory;
            $trackHistory->user_id = Auth::id();
            $trackHistory->course_or_toolkit = 1;
            $trackHistory->course_toolkit_id = $course->id;
            $trackHistory->save();

        } else {
            if ($course_toolkit == 't') {
                $toolkit = Toolkit::where('slug', '=', $slug)->first();
                $trackHistory = new TrackHistory;
                $trackHistory->user_id = Auth::id();
                $trackHistory->course_or_toolkit = 0;
                $trackHistory->course_toolkit_id = $toolkit->id;
                $trackHistory->save();
            }
        }
        return redirect()->back();
    }

    function rate_a_course(Request $request)
    {
        $ratingTotal = $request->comprehensibilityRating + $request->creativityRating;
        $aveRating = $ratingTotal / 2;

        $slug = $request->slug;
        $course_toolkit = $request->course_toolkit;
        if ($course_toolkit == 'c') {
            $course = Course::where('slug', '=', $slug)->first();

            $rating = CourseRating::where('user_id', '=', Auth::id())
                ->where('course_id', '=', $course->id)
                ->first();


            if ($rating == null) {
                $rating = new CourseRating;
                $rating->user_id = Auth::id();
                $rating->course_id = $course->id;
            }

            $rating->rating = $aveRating;
            $rating->save();

            $this->update_rating_of_user_table($course->user_id);

        } else {
            if ($course_toolkit == 't') {
                $toolkit = Toolkit::where('slug', '=', $slug)->first();

                $rating = ToolkitRating::where('user_id', '=', Auth::id())
                    ->where('toolkit_id', '=', $toolkit->id)
                    ->first();

                if ($rating == null) {
                    $rating = new ToolkitRating;
                    $rating->user_id = Auth::id();
                    $rating->toolkit_id = $toolkit->id;
                }
                $rating->rating = $aveRating;
                $rating->save();

                $this->update_rating_of_user_table($toolkit->user_id);
            }
        }
        return redirect('all');
    }

    function retake_course(Request $request)
    {
        $slug = $request->slug;
        $course_toolkit = $request->course_toolkit;
        if ($course_toolkit == 'c') {
            $course = Course::where('slug', '=', $slug)->first();
            $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                ->where('course_or_toolkit', '=', 1)
                ->where('course_toolkit_id', '=', $course->id)
                ->first();
            $trackHistory->current_sequence = 0;
            $trackHistory->save();

        } else {
            if ($course_toolkit == 't') {
                $toolkit = Toolkit::where('slug', '=', $slug)->first();
                $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
                    ->where('course_or_toolkit', '=', 0)
                    ->where('course_toolkit_id', '=', $toolkit->id)
                    ->first();
                $trackHistory->current_sequence = 0;
                $trackHistory->save();
            }
        }
        return 'success';
    }

    function update_rating_of_user_table($id)
    {
        $achievements = DB::select("SELECT * FROM (SELECT courses.title, (SELECT count(*) FROM course_quizzes WHERE course_quizzes.course_id = courses.id) AS total_quizzes, count(course_histories.id) AS completed_quizzes, sum(course_histories.points) AS gained_points, sum((SELECT count(*) FROM course_questions WHERE course_quizzes.id = course_questions.quiz_id)) AS total_questions FROM courses JOIN course_quizzes ON courses.id = course_quizzes.course_id JOIN course_histories ON course_quizzes.id = course_histories.quiz_id WHERE course_histories.user_id = " . $id . ") a WHERE a.completed_quizzes = a.total_quizzes");

        $course_knowledges = DB::select("SELECT * FROM (SELECT subjects.subject_name, (SELECT count(*) FROM toolkit_quizzes WHERE toolkit_quizzes.toolkit_id = toolkits.id) AS total_quizzes, count(toolkit_histories.id) AS completed_quizzes, MAX(toolkit_histories.updated_at) AS updated_at, sum(toolkit_histories.points) AS gained_points, sum((SELECT count(*) FROM toolkit_questions WHERE toolkit_quizzes.id = toolkit_questions.quiz_id)) AS total_questions FROM toolkits JOIN toolkit_quizzes ON toolkits.id = toolkit_quizzes.toolkit_id JOIN toolkit_histories ON toolkit_quizzes.id = toolkit_histories.quiz_id JOIN subjects ON subjects.id = toolkits.subject_id WHERE toolkit_histories.user_id = " . $id . " GROUP BY toolkits.subject_id) a WHERE a.completed_quizzes = a.total_quizzes");

        $toolkit_rating = DB::table('toolkit_ratings')
            ->rightJoin('toolkits', 'toolkits.id', '=', 'toolkit_ratings.toolkit_id')
            ->where('toolkits.user_id', '=', $id)
            ->avg('toolkit_ratings.rating');

        $course_rating = DB::table('course_ratings')
            ->rightJoin('courses', 'courses.id', '=', 'course_ratings.course_id')
            ->where('courses.user_id', '=', $id)
            ->avg('course_ratings.rating');

        $rating = ($toolkit_rating + $course_rating) / 2;

        $total_points = 0;
        foreach ($achievements as $achievement) {
            if ($achievement->total_quizzes != 0 && $achievement->completed_quizzes != 0) {
                $total_points += round((($achievement->gained_points / ($achievement->total_questions * 2)) * 5));
            }
        }
        if (sizeof($achievements) != 0) {
            $rating = (($total_points / sizeof($achievements)) + $rating) / 2;
        }


        $total_points = 0;
        foreach ($course_knowledges as $course_knowledge) {
            $total_points += round((($course_knowledge->gained_points / ($course_knowledge->total_questions * 2)) * 5));
        }

        if ($total_points != 0) {
            $total_points = (($total_points / sizeof($course_knowledges)) + $rating) / 2;
        }
        $rating = round(($total_points + $rating) / 2);


        $toolkit = DB::table('toolkit_ratings')
            ->select('toolkit_ratings.*','toolkits.user_id as teacherId')
            ->join('toolkits','toolkits.id','=','toolkit_ratings.toolkit_id')
            ->where('toolkits.user_id','=', $id)
            ->get();

        $user = User::find($id);
        $teacherRating = $user->rating;

        if($toolkit->count() > 0){
            $teacherRating = round($toolkit->sum('rating') / $toolkit->count(), 2);

        }

        $user->rating = $teacherRating;
        $user->save();

//        LeaderBoard::updateLeaderboardOnRatingChange($id, $teacherRating);

        return 0;
    }

}
