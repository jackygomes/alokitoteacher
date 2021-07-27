<?php

namespace App\Console\Commands;

use App\CourseLeaderBoards;
use App\LeaderBoard;
use App\Resource;
use App\ResourceLeaderBoards;
use App\ResourceRating;
use App\ToolkitHistory;
use App\ToolkitQuiz;
use App\User;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LeaderBoardUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboard:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command Updates the current Score and positions of the Leader Board';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //script for toolkit point percentage just for one time
        // $toolkitHistories = ToolkitHistory::get();
        // foreach($toolkitHistories as $toolkitHistory){
        //     $quiz = ToolkitQuiz::find($toolkitHistory->quiz_id);
        //     if($quiz->question_count > 0){
        //         $totalPoint = 2 * $quiz->question_count;
        //         $percentage = ($toolkitHistory->points * 100 ) / $totalPoint;

        //         $history = ToolkitHistory::find($toolkitHistory->id);
        //         $history->point_percentage = $percentage;
        //         $history->save();
        //     }
        // }
        // script end
    
        //Rating calculation...
        $users = User::where('identifier', '=','1')->where('id', '!=', 13)->get();
        foreach ($users as $user) {

            // teacher rating making out of hundred
            $teacherRating = $user->rating * 20;

            //course percentage calculation
            $courses = DB::select("SELECT * FROM (SELECT courses.title, courses.id, (SELECT count(*) FROM course_quizzes WHERE course_quizzes.course_id = courses.id) AS total_quizzes, count(course_histories.id) AS completed_quizzes, sum(course_histories.points) AS gained_points, sum((SELECT count(*) FROM course_questions WHERE course_quizzes.id = course_questions.quiz_id)) AS total_questions FROM courses JOIN course_quizzes ON courses.id = course_quizzes.course_id JOIN course_histories ON course_quizzes.id = course_histories.quiz_id WHERE course_histories.user_id = ".$user->id." GROUP BY courses.id) a WHERE a.completed_quizzes = a.total_quizzes");
            $coursePercentage = 0;
            if($courses){
                $courseTotal = 0;
                $courseCount = 0;
                foreach($courses as $course){
                    $courseCount++;
                    $percentage = round((($course->gained_points/($course->total_questions * 2)) * 100), 1);
                    $courseTotal += $percentage;
                }
                $coursePercentage = $courseTotal / $courseCount;
            }
            //course percentage ends

            // course leaderboard start
            
            $courseleaderboard = CourseLeaderBoards::where('user_id', $user->id)->first();
            if($courseleaderboard) {
                $courseleaderboard->score = $coursePercentage;
                $courseleaderboard->save();
            } else {
                $courseleaderboardData = [
                    'user_id'   => $user->id,
                    'score'     => $coursePercentage,
                    'position'  => 9999,

                ];
                CourseLeaderBoards::create($courseleaderboardData);
            }

            // course leaderboard End

            // Resource leaderboard Start

            $resources = Resource::where('user_id', $user->id)->get();
			$resourceRatingCount = 0;
			$totalRating = 0;
			foreach($resources as $resource){
				
				$resource_rating = ResourceRating::where('resource_id', $resource->id)->get();
				foreach($resource_rating as $rating){
					$resourceRatingCount++;
					$totalRating += $rating->rating;
				}
			}

            if($resourceRatingCount > 0) $aveResourceRating = (($totalRating / $resourceRatingCount) / 5) * 100;
            else $aveResourceRating = 0;

            $resourceleaderboard = ResourceLeaderBoards::where('user_id', $user->id)->first();
            if($resourceleaderboard) {
                $resourceleaderboard->score = $aveResourceRating;
                $resourceleaderboard->save();
            } else {
                $resourceleaderboardData = [
                    'user_id'   => $user->id,
                    'score'     => $aveResourceRating,
                    'position'  => 9999,

                ];
                ResourceLeaderBoards::create($resourceleaderboardData);
            }

            // Resource leaderboard End

            // toolkit percentage calculation
            // $toolkits = DB::select("
            // select tk.toolkit_title, s.subject_name, th.point_percentage, sum(th.points) as totalPoints
            // FROM toolkits as tk
            // JOIN subjects as s ON s.id = tk.subject_id
            // JOIN toolkit_quizzes as tq ON tq.toolkit_id = tk.id
            // JOIN toolkit_histories as th ON th.quiz_id = tq.id AND th.user_id = '$user->id'
            // GROUP BY tk.id
            //  ");

            // $toolkitTotal = 0;
            // $toolkitCount = 0;
            // $toolkitPercentage = 0;
            // if($toolkits){
            //     foreach ($toolkits as $toolkit){
            //         $toolkitCount++;
            //         $toolkitTotal += $toolkit->point_percentage;
            //     }
            //     $toolkitPercentage = $toolkitTotal / $toolkitCount;
            // }

            //toolkit percentage ends

            //Final percentage calculation
            $totalAveragePoints = (($teacherRating + $coursePercentage) * 2 ) / 10;

            $leaderboard = LeaderBoard::where('user_id', $user->id)->first();
            if($leaderboard) {
                $leaderboard->score = $totalAveragePoints;
                $leaderboard->save();
            } else {
                $leaderboardData = [
                    'user_id'   => $user->id,
                    'score'     => $totalAveragePoints,
                    'position'  => 9999,
                    'streak'    => 0,

                ];
                LeaderBoard::create($leaderboardData);
            }
        }
        // general leaderboard Entry start
        $leaderboardUsers = LeaderBoard::orderBy('score', 'desc')->get();
        $i = 0;
        $factor = 1;
        foreach($leaderboardUsers as $leaderboardUser){
            $i++;
            if($i==1) {
                $factor = 10 / $leaderboardUser->score;
            }
            if($leaderboardUser->position < 11) $leaderboardUser->streak +=1;
            else $leaderboardUser->streak = 0;
            $leaderboardUser->position = $i;
            if($i<11) $leaderboardUser->streak_point += (11- $i) * .1;

            $leaderboardUser->score += $leaderboardUser->streak_point * $factor;
            $leaderboardUser->save();
        }
        // general leaderboard Entry end

        // Course leaderboard Entry Start
        $courseleaderboardUsers = CourseLeaderBoards::orderBy('score', 'desc')->get();
        $coursePosition = 0;
        foreach($courseleaderboardUsers as $user){
            $coursePosition++;
            $user->position = $coursePosition;
            $user->save();
        }
        // Course leaderboard Entry End

        // Resource leaderboard Entry Start

        $resourceleaderboardUsers = ResourceLeaderBoards::orderBy('score', 'desc')->get();
        $resourcePosition = 0;
        foreach($resourceleaderboardUsers as $user){
            $resourcePosition++;
            $user->position = $resourcePosition;
            $user->save();
        }

        // Resource leaderboard Entry End

        //Only rating in leaderboards table..

    }
}
