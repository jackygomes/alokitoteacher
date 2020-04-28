<?php

namespace App\Http\Controllers;

use App\Question;
use App\Subject;
use App\ToolkitQuestion;
use App\ToolkitQuiz;
use App\ToolkitQuizOption;
use App\ToolkitVideo;
use App\TrackHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Toolkit;
use Illuminate\Support\Str;


class ToolkitController extends Controller
{
    function index(){


	    $toolkit_info = DB::table('users')
	    ->rightJoin('toolkits', 'users.id', '=','toolkits.user_id')
	    ->join('subjects', 'toolkits.subject_id', '=','subjects.id')
	    ->leftJoin('toolkit_ratings', 'toolkits.id', '=', 'toolkit_ratings.toolkit_id')
	    ->select('users.id','users.name','users.email','users.image','users.phone_number','users.balance','users.username','toolkits.id','toolkits.subject_id','toolkits.toolkit_title','toolkits.description','toolkits.slug','toolkits.price','toolkits.thumbnail','subjects.subject_name','subjects.id', DB::raw('avg(toolkit_ratings.rating) as rating'))
	    ->where('toolkits.status', '=', 'Approved')
        ->groupBy('toolkits.id')
	    ->orderby('toolkits.subject_id','asc')
	    ->paginate(12);

//        return $toolkit_info;

	    return view ('toolkits',compact('toolkit_info'));
	    //return var_dump($data);
	    //return view('toolkits');
    }

//	Admin Functions
    public function create () {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }

        $subjects = Subject::all();

        return view('toolkit.create', compact('user_info', 'subjects'));
    }

    public function store(Request $request) {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }

        $this->validate($request, [
            'subject'               => 'required',
            'toolkit_name'          => 'required',
            'toolkit_description'   => 'required',
            'toolkit_price'         => 'required',
            'thumbnailImage'        => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $randomText = Str::random(10);
        $slug = Str::slug($request->input('toolkit_name'), '-');
        $slug = $slug.'-'.$randomText;

        $image = $request->file('thumbnailImage');
        $image_name = $userId.'_toolkit_'.md5(rand()).'.'.$image->getClientOriginalExtension();
        $image->move(public_path("images/thumbnail"), $image_name);

        $toolkit = new Toolkit();
        $toolkit->subject_id = $request->input('subject');
        $toolkit->user_id = $userId;
        $toolkit->toolkit_title = $request->input('toolkit_name');
        $toolkit->description = $request->input('toolkit_description');
        $toolkit->price = $request->input('toolkit_price');
        $toolkit->status = 'Pending';
        $toolkit->slug = $slug;
        $toolkit->thumbnail = $image_name;

        $toolkit->save();

        if($user_info->identifier == 1){
            return redirect()->route('teacher.dashboard')->with('success', 'Toolkit created successfully');
        }else {
            return redirect()->route('dashboard')->with('success', 'Toolkit created successfully');
        }

    }

    public function toolkitDetailsUpdate(Request $request, $toolkitId) {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }

        $toolkit = Toolkit::find($toolkitId);
        if ($toolkit == null) {
            return abort(404);
        }

        $this->validate($request, [
            'subject'               => 'required',
            'toolkit_name'          => 'required',
            'toolkit_description'   => 'required',
            'toolkit_price'         => 'required',
        ]);

        $randomText = Str::random(10);
        $slug = Str::slug($request->input('toolkit_name'), '-');
        $slug = $slug.'-'.$randomText;


        $toolkit = Toolkit::find($toolkitId);

        if($toolkit->toolkit_title == $request->input('toolkit_name')){
            $slug = $toolkit->slug;
        }

        $toolkit->subject_id = $request->input('subject');
//        $toolkit->user_id = $userId;
        $toolkit->toolkit_title = $request->input('toolkit_name');
        $toolkit->description = $request->input('toolkit_description');
        $toolkit->price = $request->input('toolkit_price');
        $toolkit->status = $request->input('status');
        $toolkit->slug = $slug;

        if(isset($request->toolkitThumbnailImage)) {
            $image = $request->file('toolkitThumbnailImage');
            $image_name = $userId.'_image_'.md5(rand()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path("images/thumbnail"), $image_name);
            $toolkit->thumbnail = $image_name;
        }


        $toolkit->save();
        return redirect()->route('toolkit.edit', $toolkitId)->with('success', 'Toolkit Edited successfully');
    }

    public function videoCreate(Request $request, $id){
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }

        $this->validate($request, [
            'url' => 'required',
            'title' => 'required',
        ]);

        $video = new ToolkitVideo();
        $video->toolkit_id = $id;
        $video->url = $request->input('url');
        $video->video_title = $request->input('title');
        $video->short_description = isset($request->description) ? $request->description : "";
        $video->sequence = '1';

        $video->save();

        return redirect()->route('toolkit.edit', $id)->with('success', 'Video created successfully');
    }

    public function quizCreate(Request $request, $toolkitId){
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }

        try{
            $quizData = [
                'toolkit_id'    => $toolkitId,
                'quiz_title'    => isset($request->quiz_name) ? $request->quiz_name : "",
                'description'    => isset($request->quiz_description) ? $request->quiz_description : "",
                'sequence'      => 2
            ];
//            return $quizData;
            ToolkitQuiz::create($quizData);

        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

        return redirect()->route('toolkit.edit', $toolkitId)->with('success', 'Quiz created successfully');

    }

    public function questionCreate(Request $request, $toolkitId){
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }
        // Maximum question count check
        $questionCountCheck = ToolkitQuiz::find($request->quiz_id);

        if($questionCountCheck->question_count >= 10) {
            return redirect()->route('toolkit.edit', $toolkitId)->with('warning', 'Sorry! You can add maximum 10 question.');
        }

        // Merge Questions and Options
        $data = $request->all();

        $questions = array_map(function($value) {
            return ["question" => $value];
        }, array_filter($data, function($value, $key) {
            return Str::contains($key, 'question');
        }, ARRAY_FILTER_USE_BOTH));

        $options = array_filter($data, function($value, $key) {
            return Str::contains($key, 'options');
        }, ARRAY_FILTER_USE_BOTH);

        $correctOptions = array_filter($data, function($value, $key) {
            return Str::contains($key, 'correctOption_');
        }, ARRAY_FILTER_USE_BOTH);


        foreach ($questions as $key => $question) {
            $index = str_replace("questions", "", $key);
            $questions["questions$index"]['options'] = $options["options$index"];
            $questions["questions$index"]['correct_option'] =isset($correctOptions["correctOption_$index"]) ? $correctOptions["correctOption_$index"] : "";
        }
//        return $questions;

        try {
            // TODO: Create Quiz
            foreach ($questions as $question) {
                if($question['question'] != null){
                    $questionData = [
                        'quiz_id'    => $request->quiz_id,
                        'query'    => isset($question['question'][0]) ? $question['question'][0] : "",
                        'points'      => 2,
                        'mcq_or_not' => 2,
                        'correct_option' => $question['correct_option'],
                    ];
//                        return $questionData;

                    if($questionInsert = ToolkitQuestion::create($questionData)) {
                        foreach ($question['options'] as $option){
                            if($option != null){
                                $optionData = [
                                    'question_id'    => $questionInsert->id,
                                    'question_option'    => isset($option) ? $option : "",
                                ];
                                ToolkitQuizOption::create($optionData);
                            }
                        }
                    } else {
                        return "Question insertion error: Failed to insert Question";
                    }
                }
            }
        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

        $questionCount = ToolkitQuestion::where('quiz_id', '=', $request->quiz_id)->count();

        $quiz = ToolkitQuiz::find($request->quiz_id);
        $quiz->question_count = $questionCount;
        $quiz->save();


        return redirect()->route('toolkit.edit', $toolkitId)->with('success', 'Questions created successfully');
    }

    public function toolkit_edit($toolkitId) {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 101 || $user_info->identifier == 1){
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }

        $toolkit = Toolkit::find($toolkitId);

        if ($toolkit == null) {
            return abort(404);
        }
        $subjects = Subject::all();

        $trackHistory = TrackHistory::where('user_id', '=', Auth::id())
            ->where('course_or_toolkit', '=', 0)
            ->where('course_toolkit_id', '=', $toolkit->id)
            ->first();

        $videos = DB::table('toolkit_videos')
            ->select('id', 'video_title as title', 'sequence', DB::raw('1 as type'))
            ->where('toolkit_id', '=', $toolkit->id);

        $documents = DB::table('toolkit_documents')
            ->select('id', 'doc_title as title', 'sequence', DB::raw('2 as type'))
            ->where('toolkit_id', '=', $toolkit->id);

        $contents = DB::table('toolkit_quizzes')
            ->select('id', 'quiz_title as title', 'sequence', DB::raw('3 as type'))
            ->where('toolkit_id', '=', $toolkit->id)
            ->union($documents)
            ->union($videos)
            ->orderBy('sequence', 'ASC')
            ->get();

        $quiz = ToolkitQuiz::where('toolkit_id', '=', $toolkitId)->get();

        if(count($quiz) > 0){
            if( $quiz[0]->question_count >= 4) $publishEnable = 1;
            else $publishEnable = 0;
        } else $publishEnable = 0;

//        return $contents;
        return view('toolkit.toolkit_edit', compact('publishEnable', 'user_info', 'toolkit', 'contents', 'toolkitId', 'subjects'));
    }

    public function toolkit_video_update(Request $request, $id)
    {
        $toolkitVideo = ToolkitVideo::find($id);
        $toolkitVideo->url = $request->input('url');
        $toolkitVideo->video_title = $request->input('title');
        $toolkitVideo->short_description = $request->input('description');

        $toolkitId = $request->input('toolkit_id');


        $toolkitVideo->save();

        return redirect()->route('toolkit.edit', $toolkitId);

    }
    public function toolkit_quiz_update (Request $request, $id) {

        $toolkit = $id;
        $quizId = $request->input('quiz_id');
        $toolkitQuiz = toolkitQuiz::find($quizId);
        $toolkitQuiz->quiz_title = $request->input('quiz_name');

        $toolkitQuiz->save();


        $questionCount = count($request->input('questionIds'));
        for($x = 0; $x < $questionCount; $x++) {
            $id = $request->input('questionIds.'.$x);
            $toolkitQuestion = ToolkitQuestion::find($id);
            $toolkitQuestion->query = $request->input('questions.'.$x);
            $toolkitQuestion->correct_option = $request->input('correctOption_'.$id);

            $toolkitQuestion->save();
        }

        $optionCount = count($request->input('optionsIds'));
        for($x = 0; $x < $optionCount; $x++) {
            $id = $request->input('optionsIds.'.$x);
            $toolkitQuestionOption = ToolkitQuizOption::find($id);
            $toolkitQuestionOption->question_option = $request->input('options.'.$x);

            $toolkitQuestionOption->save();
        }

        // TODO: below code will get deleted
        // this code is just to fill the question_count field as it was newly created
        $questionCount = ToolkitQuestion::where('quiz_id', '=', $quizId)->count();
        $quiz = ToolkitQuiz::find($quizId);
        $quiz->question_count = $questionCount;
        $quiz->save();
        // end

        return redirect()->route('toolkit.edit', $toolkit);

    }
}

