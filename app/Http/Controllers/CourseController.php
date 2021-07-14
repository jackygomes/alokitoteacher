<?php

namespace App\Http\Controllers;

use App\CourseActivist;
use App\CoursePreview;
use App\CourseQuestion;
use App\CourseQuiz;
use App\CourseQuizOption;
use App\CourseVideo;
use App\Order;
use App\Subject;
use App\Toolkit;
use App\ToolkitVideo;
use App\TrackHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Course;
use App\Quiz;
use Illuminate\Support\Str;


class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth', ['except' => ['courseSharePage']]);
    }

    function index()
    {

        $course_info = DB::table('users')
            ->rightJoin('courses', 'users.id', '=', 'courses.user_id')
            ->leftJoin('course_ratings', 'courses.id', '=', 'course_ratings.course_id')
            ->select('users.id', 'users.name', 'users.email', 'users.image', 'users.phone_number', 'users.balance', 'users.username', 'courses.id', 'courses.thumbnail', 'courses.title', 'courses.description', 'courses.price', 'courses.slug', DB::raw('avg(course_ratings.rating) as rating'), DB::raw('count(course_ratings.rating) as rating_count'))
            ->where('courses.status', '=', 'Approved')
            ->groupBy('courses.id')
            ->orderBy('courses.created_at', 'desc')
            ->paginate(9);

        $userId = Auth::check() ? Auth::user()->id : 0;
        foreach($course_info as $course){
            $isOrdered = Order::where('status', 'paid')
                ->where('product_type', 'course')
                ->where('user_id', $userId)
                ->where('product_id', $course->id)->count();

            $course->lessons = CourseVideo::where('course_id', $course->id)->count();

            $course->isBought = $isOrdered ? 1 : 0;
        }

        return view('courses', compact('course_info'));
    }

    //	Admin Functions
    public function create()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }
        $facilitators = CourseActivist::where('type', 'Facilitator')->get();
        $advisors = CourseActivist::where('type', 'Advisor')->get();
        $designers = CourseActivist::where('type', 'Designer')->get();
        return view('course.create', compact('user_info', 'users', 'facilitators', 'advisors', 'designers'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }
        $this->validate($request, [
            'course_name'           => 'required',
            'course_description'    => 'required',
            'course_price'          => 'required',
            'certificate_price'     => 'required',
            'preview_video'         => 'required',
            // 'facilitator'           => 'required',
            // 'advisor'               => 'required',
            // 'designer'              => 'required',
            'courseThumbnailImage'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $randomText = Str::random(6);
        $slug = Str::slug($request->input('course_name'), '-');
        $slug = $slug . '-' . $randomText;

        $image = $request->file('courseThumbnailImage');
        $image_name = $userId . '_course_' . md5(rand()) . '.' . $image->getClientOriginalExtension();

        $image->move(public_path("images/thumbnail"), $image_name);

        $course = [
            'user_id'    => $userId,
            'title'    => isset($request->course_name) ? $request->course_name : "",
            'description'    => isset($request->course_description) ? $request->course_description : "",
            'price'    => isset($request->course_price) ? $request->course_price : "",
            'certificate_price'    => isset($request->certificate_price) ? $request->certificate_price : "",
            'slug'    => $slug,
            'course_facilitator'    => json_encode($request->facilitator),
            'advisor'    => json_encode($request->advisor),
            'designer'    => json_encode($request->designer),
            'thumbnail'    => $image_name,
        ];

        if ($courseInsert = Course::create($course)) {
            $previewVideo = [
                'course_id' => $courseInsert->id,
                'url'       => $request->preview_video,
            ];
            CoursePreview::create($previewVideo);
        }

        return redirect()->route('course.edit', $courseInsert->id)->with('success', 'Course created successfully');
    }

    public function course_edit($id)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

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

        return view('course.course_edit', compact('user_info', 'info', 'contents'));
    }

    public function courseObjectiveEdit($courseId)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }

        $info = Course::find($courseId);

        $previewVideo = CoursePreview::where('course_id', '=', $courseId)->first();
        //        return $previewVideo;

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

        $quizzes = CourseQuiz::where('course_id', '=', $courseId)->get();
        if (count($quizzes) > 0) {
            foreach ($quizzes as $quiz) {
                if ($quiz->question_count < 5) {
                    $publishEnable = 0;
                    break;
                } else {
                    $publishEnable = 1;
                }
            }
        } else $publishEnable = 0;

        $decodeFacilitators  = $info->course_facilitator == null ? [] : json_decode($info->course_facilitator);
        $decodeAdvisors     = $info->advisor == null ? [] : json_decode($info->advisor);
        $decodeDesigners    = $info->designer == null ? [] : json_decode($info->designer);

        $infoFacilitators = CourseActivist::where('type', 'Facilitator')->findMany($decodeFacilitators);
        $infoAdvisors = CourseActivist::where('type', 'Advisor')->findMany($decodeAdvisors);
        $infoDesigners = CourseActivist::where('type', 'Designer')->findMany($decodeDesigners);


        $facilitators = CourseActivist::where('type', 'Facilitator')->get();
        $advisors = CourseActivist::where('type', 'Advisor')->get();
        $designers = CourseActivist::where('type', 'Designer')->get();

        //Course Publication status chack...
        $t_quizes = CourseQuiz::where('course_id',$courseId)->pluck('id');
        $canEdit = 0;
        foreach($t_quizes as $q){
            $count = CourseQuestion::where('quiz_id',$q)->count();
            if($count < 5) $canEdit = 0;
            else $canEdit = 1;
        }
        //Course Publication status chack...

        return view('course.edit_objective', compact('canEdit','users', 'infoFacilitators', 'infoAdvisors', 'infoDesigners', 'facilitators', 'advisors', 'designers', 'previewVideo', 'publishEnable', 'quizzes', 'info', 'contents'));
    }

    public function courseDetailsUpdate(Request $request, $courseId)
    {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }

        $this->validate($request, [
            'course_name'          => 'required',
            'course_description'   => 'required',
            'course_price'         => 'required',
            'certificate_price'    => 'required',
            'preview_video'        => 'required',
            // 'facilitator'          => 'required',
            // 'advisor'              => 'required',
            // 'designer'             => 'required',
        ]);
        $randomText = Str::random(10);
        $slug = Str::slug($request->input('course_name'), '-');
        $slug = $slug . '-' . $randomText;


        $previewVideo = CoursePreview::where('course_id', $courseId)->first();
        $previewVideo->url = $request->preview_video;

        $previewVideo->save();

        $course = Course::find($courseId);
        if ($course->title  == $request->input('course_name')) {
            $slug = $course->slug;
        }

        $course->title = $request->input('course_name');
        $course->description = $request->input('course_description');
        $course->price = $request->input('course_price');
        $course->certificate_price = $request->input('certificate_price');
        $course->status = isset($request->status) ? $request->input('status') : "Pending";
        $course->slug = $slug;
        $course->course_facilitator = json_encode($request->facilitator);
        $course->advisor = json_encode($request->advisor);
        $course->designer = json_encode($request->designer);

        if (isset($request->courseThumbnailImage)) {
            $oldImagePath = 'images/thumbnail/' . $course->thumbnail;
            File::delete($oldImagePath);

            $image = $request->file('courseThumbnailImage');
            $image_name = $userId . '_image_' . md5(rand()) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path("images/thumbnail"), $image_name);
            $course->thumbnail = $image_name;
        }

        $course->save();

        // TODO this code will get delete after question_count fills
        $quizzes = CourseQuiz::where('course_id', '=', $courseId)->get();
        if (count($quizzes) > 0) {
            foreach ($quizzes as $quiz) {
                $questionCount = CourseQuestion::where('quiz_id', '=', $quiz->id)->count();
                $quiz = CourseQuiz::find($quiz->id);
                $quiz->question_count = $questionCount;
                $quiz->save();
            }
        }
        // End

        return redirect()->route('course.objective.edit', $courseId)->with('success', 'Course Details Edited successfully');
    }

    public function videoCreate(Request $request, $courseId)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }
        $this->validate($request, [
            'url' => 'required',
            'title' => 'required',
        ]);

        try {
            $videoData = [
                'course_id'    => $courseId,
                'url'    => isset($request->url) ? $request->url : "",
                'video_title'    => isset($request->title) ? $request->title : "",
                'sequence' => 0,
                'short_description' => isset($request->description) ? $request->description : "",
            ];

            CourseVideo::create($videoData);
        } catch (\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }
        return redirect()->route('course.objective.edit', $courseId)->with('success', 'Video created successfully');
    }
    public function quizCreate(Request $request, $courseId)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }

        $this->validate($request, [
            'quiz_name' => 'required',
        ]);

        try {
            $quizData = [
                'course_id'    => $courseId,
                'quiz_title'    => isset($request->quiz_name) ? $request->quiz_name : "",
                'sequence' => 0,
                'description' => isset($request->quiz_description) ? $request->quiz_description : "",
            ];

            CourseQuiz::create($quizData);
        } catch (\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }
        return redirect()->route('course.objective.edit', $courseId)->with('success', 'Quiz created successfully');
    }

    public function questionCreate(Request $request, $courseId)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }


        $this->validate($request, [
            'quiz' => 'required',
            'question' => 'required',
            'correctOption' => 'required',
        ]);

        // Maximum question count check
        $questionCountCheck = CourseQuiz::find($request->quiz);

        if ($questionCountCheck->question_count >= 10) {
            return redirect()->route('course.objective.edit', $courseId)->with('warning', 'Sorry! You can add maximum 10 question.');
        }

        try {
            $questionData = [
                'quiz_id'    => $request->quiz,
                'query'    => isset($request->question) ? $request->question : "",
                'points' => 10,
                'mcq_or_not' => 1,
                'correct_option' => $request->correctOption,
            ];

            if ($questionInsert = CourseQuestion::create($questionData)) {
                foreach ($request->options0 as $option) {
                    if ($option != null) {
                        $optionData = [
                            'question_id'    => $questionInsert->id,
                            'question_option'    => isset($option) ? $option : "",
                        ];
                        CourseQuizOption::create($optionData);
                    }
                }
            }
        } catch (\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }
        return redirect()->route('course.objective.edit', $courseId)->with('success', 'Question created successfully');
    }

    public function courseSequenceUpdate(Request $request, $courseId)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }

        // Merge Sequence type and ID

        $data = $request->all();

        $items = array_map(function ($value) {
            return ["item_sequence" => $value];
        }, array_filter($data, function ($value, $key) {
            return Str::contains($key, 'item_sequence');
        }, ARRAY_FILTER_USE_BOTH));

        $id = array_filter($data, function ($value, $key) {
            return Str::contains($key, 'item_id');
        }, ARRAY_FILTER_USE_BOTH);

        $type = array_filter($data, function ($value, $key) {
            return Str::contains($key, 'item_type');
        }, ARRAY_FILTER_USE_BOTH);

        foreach ($items as $key => $item) {
            $index = str_replace("item_sequence", "", $key);
            $items["item_sequence$index"]['id'] = $id["item_id$index"];
            $items["item_sequence$index"]['type'] = $type["item_type$index"];
        }

        try {
            foreach ($items as $item) {
                if ($item['type'][0] == 1) {
                    $courseVideo = CourseVideo::find($item['id'][0]);
                    $courseVideo->sequence = $item['item_sequence'][0];
                    $courseVideo->save();
                } elseif ($item['type'][0] == 3) {
                    $courseQuiz = CourseQuiz::find($item['id'][0]);
                    $courseQuiz->sequence = $item['item_sequence'][0];

                    $courseQuiz->save();
                }
            }
        } catch (\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

        return redirect()->route('course.objective.edit', $courseId)->with('success', 'Sequence Updated successfully');
    }

    public function course_video_update(Request $request, $id)
    {


        $courseVideo = CourseVideo::find($id);
        $courseVideo->url = $request->input('url');
        $courseVideo->video_title = $request->input('title');
        $courseVideo->short_description = $request->input('description');

        $courseId = $request->input('course_id');


        $courseVideo->save();
        return redirect()->route('course.edit', $courseId);
    }

    public function course_quiz_update(Request $request, $id)
    {

        $courseId = $id;
        $quizId = $request->input('quiz_id');
        $courseQuiz = CourseQuiz::find($quizId);
        $courseQuiz->quiz_title = $request->input('quiz_name');

        $courseQuiz->save();

        $questionCount = count($request->input('questionIds'));

        for ($x = 0; $x < $questionCount; $x++) {
            $id = $request->input('questionIds.' . $x);
            $courseQuestion = CourseQuestion::find($id);
            $courseQuestion->query = $request->input('questions.' . $x);
            $courseQuestion->correct_option = $request->input('correctOption_' . $id);

            $courseQuestion->save();
        }

        $optionCount = count($request->input('optionsIds'));
        for ($x = 0; $x < $optionCount; $x++) {
            $id = $request->input('optionsIds.' . $x);
            $courseQuestionOption = CourseQuizOption::find($id);
            $courseQuestionOption->question_option = $request->input('options.' . $x);

            $courseQuestionOption->save();
        }


        return redirect()->route('course.edit', $courseId);
    }

    /**
     * Remove the specified toolkit from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $course = Course::find($id);

            $course->deleted = 1;
            $course->save();

            return back()->with('success', 'Course deleted successfully!');


        }catch(\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }
    }

    public function questionDelete($id)
    {
        $question = CourseQuestion::find($id);
        $question->delete();
        return redirect()->back()->with('success', 'Question deleted successfully!');
    }

    function courseSharePage(Request $request) {
        $info = Course::where('slug', '=', $request->slug)->first();

        if ($info == null) {
            return abort(404);
        }

        return view('share-pages.course', compact('info'));
    }
}
