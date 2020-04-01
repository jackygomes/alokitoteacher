<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

use App\Toolkit;
use App\ToolkitVideo;
use App\ToolkitDocument;
use App\ToolkitQuiz;
use App\ToolkitQuestion;
use App\Option;


class ToolkitContentController extends Controller
{
    public function __construct()
	    {
	        $this->middleware('auth');
	    }

	    function index(Request $request){



		$info = Toolkit::where('slug','=', $request->slug)->first();

		if($info == null){
			return abort(404);
		}




		$videos =  DB::table('toolkit_videos')
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


	    return view ('extra',compact('info','contents'));

	}

	function load_content(Request $request){
		$id = $request->id;
		$type = $request->type;

		if($type == 1){
			return ToolkitVideo::find($id);
		}elseif ($type == 2) {
			return ToolkitDocument::find($id);
		}else{
			$quiz_details = ToolkitQuiz::find($id);
			$questions = ToolkitQuestion::where('quiz_id', '=', $quiz_details->id)->get();
			$count = $questions->count();

			return response()->json([
                'html' => view('quiz' , compact('quiz_details', 'questions', 'count'))->render(),
            ]);
		}
	}
	
	function load_question(Request $request){
		$quiz_details = ToolkitQuiz::find($request->quiz_id);
		$question = ToolkitQuestion::where('quiz_id', '=', $quiz_details->id)->offset($request->serial)->limit($request->serial)->first();
		$options = Option::where('question_id', '=', $question->id)->get();

		return response()->json([
                            'question' => $question,
                            'options' => $options,
                        ]);

	}


}
