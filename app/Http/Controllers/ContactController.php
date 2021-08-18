<?php

namespace App\Http\Controllers;

use App\ContactUsForm;
use App\CourseLeaderBoards;
use App\LeaderBoard;
use App\Resource;
use App\ResourceLeaderBoards;
use App\ResourceRating;
use App\Revenue;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
   function index(){
	// 	$userTodeduct = [7,8,14,9,10,12,11,1589,16,577,5,83,13,32];
	// 	$user = User::where('identifier', '=','1')->where('id', 14)->first();
		
	// 	// foreach ($users as $user) {

	// 	// teacher rating making out of hundred
	// 	$teacherRating = $user->rating * 20;

	// 	//course percentage calculation
	// 	$courses = DB::select("SELECT * FROM (SELECT courses.title, courses.id, (SELECT count(*) FROM course_quizzes WHERE course_quizzes.course_id = courses.id) AS total_quizzes, count(course_histories.id) AS completed_quizzes, sum(course_histories.points) AS gained_points, sum((SELECT count(*) FROM course_questions WHERE course_quizzes.id = course_questions.quiz_id)) AS total_questions FROM courses JOIN course_quizzes ON courses.id = course_quizzes.course_id JOIN course_histories ON course_quizzes.id = course_histories.quiz_id WHERE course_histories.user_id = ".$user->id." GROUP BY courses.id) a WHERE a.completed_quizzes = a.total_quizzes");
	// 	$coursePercentage = 0;
	// 	if($courses){
	// 		$courseTotal = 0;
	// 		$courseCount = 0;
	// 		foreach($courses as $course){
	// 			$courseCount++;
	// 			$percentage = round((($course->gained_points/($course->total_questions * 2)) * 100), 1);
	// 			$courseTotal += $percentage;
	// 		}
	// 		$coursePercentage = $courseTotal / $courseCount;
	// 	}
	// 	$coursePercentage;


	// 	//Final percentage calculation
	// 	$totalAveragePoints = (($teacherRating + $coursePercentage) * 2 ) / 10;
		
	// 	$check = $coursePercentage;

	// 	$leaderboard = LeaderBoard::where('user_id', $user->id)->first();
	// 	if($leaderboard) {
	// 		$leaderboard->score = $totalAveragePoints;
	// 		// $leaderboard->save();
	// 	} 
	// 	// else {
	// 	// 	$leaderboardData = [
	// 	// 		'user_id'   => $user->id,
	// 	// 		'score'     => $totalAveragePoints,
	// 	// 		'position'  => 9999,
	// 	// 		'streak'    => 0,

	// 	// 	];
	// 	// 	LeaderBoard::create($leaderboardData);
	// 	// }
	// // }
	// 	$leaderboardUser = LeaderBoard::where('user_id', 14)->first();
	// 	$i = 0;
	// 	$factor = 1;
	// 	$i++;
	// 	if($i==1) {
	// 		$factor = 10 / $leaderboardUser->score;
	// 	}
	// 	if($leaderboardUser->position < 11) $leaderboardUser->streak +=1;
	// 	else $leaderboardUser->streak = 0;
	// 	if($i<11) $leaderboardUser->streak_point += (11- $i) * .1;

	// 	$leaderboardUser->score += $leaderboardUser->streak_point * $factor;
	// 	// $leaderboard->save();

	// 	return $leaderboardUser;
	
		return view('contact-us');
	}

	public function store(Request $request){
		$this->validate($request, [
            'name'   => 'required',
            'email'  => 'required',
            'message'=> 'required',
        ]);

		try{
            $data = [
                'name'   => $request->name,
				'email'  => $request->email,
				'message'=> $request->message,
            ];
			
		   	ContactUsForm::create($data);

		   return redirect()->back()->with('success', 'Your message sent successfully');

        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }
	}

	public function adminMessageListView() {
		try{

			$user_info = User::where('id', '=', Auth::id())->first();
			$revenue = Revenue::all()->sum('revenue');
			$contact_messages = ContactUsForm::get();

			return view('admin.contact-message-list', compact('contact_messages', 'user_info','revenue'));

        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }
	}
}
