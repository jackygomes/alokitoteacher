<?php


namespace App\Utilities;


use Carbon\Carbon;

class LeaderBoard
{
    public static function updateLeaderboardOnRatingChange($userId, $teacherRating)
    {
        try {
            $leaderboard = \App\LeaderBoard::where('user_id', $userId)->first();

            $totalPoint = 0;
            $average_points = 0;

            // teacher rating making out of hundred
            $teacherRating = $teacherRating * 20;

            if($leaderboard) {

            } else {
                $totalPoint = $teacherRating;
                $average_points = $totalPoint / 3;
                $leaderboardData = [
                    'user_id'           => $userId,
                    'personal_rating'   => $teacherRating,
                    'course_total'      => 0,
                    'toolkit_total'     => 0,
                    'total_points'      => $totalPoint,
                    'average_points'    => $average_points,
                    'position'          => 1,
                    'position_date'     => Carbon::now()->toDateTimeString(),

                ];
            }
        } catch(\Exception $e) {
            return "Rating update on leaderboard error: " . $e->getMessage();
        }
    }
}
