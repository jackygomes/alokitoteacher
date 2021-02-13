<?php

namespace App\Http\Controllers;

use App\JobApplication;
use App\Resource;
use App\Toolkit;
use App\ToolkitHistory;
use App\ToolkitQuiz;
use App\ToolkitRating;
use App\TrackHistory;
use App\Transaction;
use App\Utilities\LeaderBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\WorkExperience;
use App\Academic;
use App\SubjectBasedKnowledge;
use App\Skill;

class TeacherController extends Controller
{


	public function __construct()
	{
		$this->middleware('auth');
	}



	function index(Request $request)
	{

		$username = $request->username;

		$user_info = User::where('username', '=', $username)->first();

		if (isset($user_info) && $user_info->identifier != 1) {
			return abort(404);
		}

		$work_info = WorkExperience::where('user_id', '=', $user_info->id)->orderBy('from_date', 'DESC')->get();

		$academic_info = Academic::where('user_id', '=',  $user_info->id)->get();

		$skill_info = Skill::where('user_id', '=',  $user_info->id)->get();

		$progresses = DB::select("SELECT * FROM (SELECT courses.title, (SELECT count(*) FROM course_quizzes WHERE course_quizzes.course_id = courses.id) AS total_quizzes, count(course_histories.id) AS completed_quizzes, MAX(course_histories.updated_at) AS updated_at FROM courses JOIN course_quizzes ON courses.id = course_quizzes.course_id JOIN course_histories ON course_quizzes.id = course_histories.quiz_id WHERE course_histories.user_id = " . $user_info->id . " GROUP BY courses.id) a WHERE a.completed_quizzes != a.total_quizzes");

		$achievements = DB::select("SELECT * FROM (SELECT courses.title, courses.id, (SELECT count(*) FROM course_quizzes WHERE course_quizzes.course_id = courses.id) AS total_quizzes, count(course_histories.id) AS completed_quizzes, sum(course_histories.points) AS gained_points, sum((SELECT count(*) FROM course_questions WHERE course_quizzes.id = course_questions.quiz_id)) AS total_questions FROM courses JOIN course_quizzes ON courses.id = course_quizzes.course_id JOIN course_histories ON course_quizzes.id = course_histories.quiz_id WHERE course_histories.user_id = " . $user_info->id . " GROUP BY courses.id) a WHERE a.completed_quizzes = a.total_quizzes");


		//		$course_knowledges = DB::select("SELECT * FROM (SELECT subjects.subject_name, (SELECT count(*) FROM toolkit_quizzes WHERE toolkit_quizzes.toolkit_id = toolkits.id) AS total_quizzes, count(toolkit_histories.id) AS completed_quizzes, MAX(toolkit_histories.updated_at) AS updated_at, sum(toolkit_histories.points) AS gained_points, sum((SELECT count(*) FROM toolkit_questions WHERE toolkit_quizzes.id = toolkit_questions.quiz_id)) AS total_questions FROM toolkits JOIN toolkit_quizzes ON toolkits.id = toolkit_quizzes.toolkit_id JOIN toolkit_histories ON toolkit_quizzes.id = toolkit_histories.quiz_id JOIN subjects ON subjects.id = toolkits.subject_id WHERE toolkit_histories.user_id = ".$user_info->id." GROUP BY toolkits.subject_id) a WHERE a.completed_quizzes = a.total_quizzes");
		//



		$course_knowledges = DB::select("
		select tk.toolkit_title, s.subject_name, sum(th.points) as totalPoints
		FROM toolkits as tk
		JOIN subjects as s ON s.id = tk.subject_id
		JOIN toolkit_quizzes as tq ON tq.toolkit_id = tk.id
		JOIN toolkit_histories as th ON th.quiz_id = tq.id AND th.user_id = '$user_info->id'
		GROUP BY tk.id
		 ");
		foreach ($course_knowledges as $course_knowledge) {
		}

		$leaderBoard = \App\LeaderBoard::orderby('position', 'asc')->with('user')->limit(10)->get();

		$recent_work = WorkExperience::where('user_id', '=', $user_info->id)->where('to_date', '=', '0000-00-00')->first();
		$recent_institute = Academic::where('user_id', '=', $user_info->id)->orderBy('passing_year', 'DESC')->first();

		$toolkit = DB::table('toolkit_ratings')
			->select('toolkit_ratings.*', 'toolkits.user_id as teacherId')
			->join('toolkits', 'toolkits.id', '=', 'toolkit_ratings.toolkit_id')
			->where('toolkits.user_id', '=', $user_info->id)
			->get();


		if ($toolkit->count() > 0) {
			$teacherRating = round($toolkit->sum('rating') / $toolkit->count(), 2);

			$user = User::find($user_info->id);
			$user->rating = $teacherRating;
			$user->save();
		}
		$earnings = Transaction::where('user_id', Auth::id())->where('transaction_type', 'Earning')->sum('amount');


		return view('teachers', compact('earnings', 'user_info', 'work_info', 'academic_info', 'skill_info', 'progresses', 'achievements', 'course_knowledges', 'leaderBoard', 'recent_work', 'recent_institute'));
	}

	public function dashboard()
	{
		$userId = Auth::id();
		$user_info = User::where('id', '=', $userId)->first();
		if (isset($user_info) && $user_info->identifier != 1) {

			return abort(404);
		}
		//        $users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();
		$leaderBoard = \App\LeaderBoard::orderby('position', 'asc')->with('user')->limit(10)->get();
		$recent_work = WorkExperience::where('user_id', '=', $user_info->id)->where('to_date', '=', '0000-00-00')->first();
		$recent_institute = Academic::where('user_id', '=', $user_info->id)->orderBy('passing_year', 'DESC')->first();
		$toolkits = Toolkit::with('subject')->where('deleted', 0)->where('user_id', '=', $userId)->paginate(5);
		$resources = Resource::where('user_id', $userId)->where('deleted', 0)->paginate(10);
		$earnings = Transaction::where('user_id', Auth::id())->where('transaction_type', 'Earning')->sum('amount');

		foreach ($toolkits as $toolkit) {
			$toolkit->people_taken = TrackHistory::where('course_toolkit_id', $toolkit->id)->count();
		}

		// return $toolkits;
		$achievements = DB::select("SELECT * FROM (SELECT courses.title, courses.id, (SELECT count(*) FROM course_quizzes WHERE course_quizzes.course_id = courses.id) AS total_quizzes, count(course_histories.id) AS completed_quizzes, sum(course_histories.points) AS gained_points, sum((SELECT count(*) FROM course_questions WHERE course_quizzes.id = course_questions.quiz_id)) AS total_questions FROM courses JOIN course_quizzes ON courses.id = course_quizzes.course_id JOIN course_histories ON course_quizzes.id = course_histories.quiz_id WHERE course_histories.user_id = " . $user_info->id . " GROUP BY courses.id) a WHERE a.completed_quizzes = a.total_quizzes");

		return view('teacher.dashboard', compact('earnings', 'resources', 'toolkits', 'user_info', 'recent_work', 'leaderBoard', 'recent_institute', 'achievements'));
	}

	function picture(Request $request)
	{
		$this->validate($request, [

			'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
		]);

		$user = User::find(Auth::id());

		$oldImagePath = 'images/profile_picture/' . $user->image;
		File::delete($oldImagePath);

		$imageName = $user->id . '_image' . time() . '.' . request()->image->getClientOriginalExtension();
		$image = $request->file('image');
		$image_name = $user->id . '_image_' . md5(rand()) . '.' . $image->getClientOriginalExtension();

		$user->image = $image_name;
		$user->save();

		$image->move(public_path("images/profile_picture"), $image_name);

		return back()->with('success', 'Image Uploaded Successfully');
	}

	function add_work_experience(Request $request)
	{
		//       return $request->all();
		$work_experience = new WorkExperience;
		$work_experience->user_id = Auth::id();
		$work_experience->institute = $request->institute;
		$work_experience->position = $request->position;
		$work_experience->from_date = date("Y-m-d", strtotime($request->from));
		if ($request->current_check) {
			$previous_job = WorkExperience::where('user_id', '=', Auth::id())->where('to_date', '=', '0000-00-00')->first();
			if ($previous_job != null) {
				$previous_job->to_date = date('Y-m-d');
				$previous_job->save();
			}

			$work_experience->to_date = '0000-00-00';
		} else {
			$work_experience->to_date = date("Y-m-d", strtotime($request->to));
		}

		$work_experience->description = $request->description ? $request->description : '';
		$work_experience->save();


		return back()->with('success', 'Work Experience is Added Successfully');
	}

	function add_academics(Request $request)
	{
		$academic = new Academic;
		$academic->user_id = Auth::id();
		$academic->institute = $request->institute;
		$academic->passing_year = $request->passing_year;
		$academic->exam_type = $request->exam_type;
		$academic->academic = $request->academic;
		$academic->academic_details = $request->academic_details;
		$academic->cgpa = $request->cgpa;

		$academic->save();
		return back()->with('success', 'Academic is Added Successfully');
	}

	function add_skills(Request $request)
	{
		$skill = new Skill;
		$skill->user_id = Auth::id();
		$skill->training_title = $request->training_title;
		$skill->topic = $request->topic;
		$skill->institute = $request->institute;
		$skill->country = $request->country;
		$skill->location = $request->location;
		$skill->year = $request->year;
		$skill->duration = $request->duration;

		$skill->save();
		return back()->with('success', 'Skill is Added Successfully');
	}

	function remove_profile_item(Request $request)
	{
		$type = '';
		if ($request->type == 'skill') {
			Skill::where('id', '=', $request->id)->where('user_id', '=', Auth::id())->delete();
			$type = 'Skill';
		} elseif ($request->type == 'academic') {
			Academic::where('id', '=', $request->id)->where('user_id', '=', Auth::id())->delete();
			$type = 'Academic';
		} elseif ($request->type == 'work_experience') {
			WorkExperience::where('id', '=', $request->id)->where('user_id', '=', Auth::id())->delete();
			$type = 'Work Experience';
		}

		if ($type == '') {
			return back()->with('danger', 'Could Not Remove!');
		}
		return back()->with('success', $type . ' is Removed Successfully');
	}



	// function work_experience(){

	// 	$data = User::find(Auth::id())
	//     ->rightjoin('work_experiences', 'users.id', '=','work_experiences.user_id')
	//     ->select('users.id','users.name','users.username','work_experiences.previous_job','work_experiences.from_date','work_experiences.to_date','work_experiences.description')
	//     ->where('user.id',$id)
	//     ->get();

	//     return view ('teachers',compact('data'));

	// }

	public function jobList()
	{
		$userId = Auth::id();
		$user_info = User::where('id', '=', $userId)->first();
		if ($user_info) {
			if ($user_info->identifier == 1) {
			} else {
				return abort(404);
			}
		} else {
			return abort(404);
		}
		$recent_work = WorkExperience::where('user_id', '=', $user_info->id)->where('to_date', '=', '0000-00-00')->first();
		$recent_institute = Academic::where('user_id', '=', $user_info->id)->orderBy('passing_year', 'DESC')->first();
		$leaderBoard = \App\LeaderBoard::orderby('position', 'asc')->with('user')->limit(10)->get();

		$jobApplications = JobApplication::where('user_id', $userId)->get();

		$n = 0;
		foreach ($jobApplications as $jobApplication) {
			$n++;
			$jobApplication->no = $n;
		}


		return view('teacher.job-list', compact('leaderBoard', 'recent_institute', 'recent_work', 'jobApplications', 'user_info'));
	}
}
