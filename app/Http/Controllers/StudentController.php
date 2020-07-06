<?php


namespace App\Http\Controllers;


use App\Job;
use App\StudentPersonalInfo;
use App\Toolkit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController
{
    function index(Request $request){
        $username = $request->username;

        $user_info = User::where('username', '=', $username)->first();

        if($user_info) {
            if($user_info->identifier == 4){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }
//        $toolkits = Toolkit::with('subject')->where('type', '=', 'Student')
//                                                    ->where('status', '=', 'Approved')
//                                                    ->get();
        $subject_based_knowledges = DB::select("
		select tk.toolkit_title, s.subject_name, sum(th.points) as totalPoints
		FROM toolkits as tk
		JOIN subjects as s ON s.id = tk.subject_id
		JOIN toolkit_quizzes as tq ON tq.toolkit_id = tk.id
		JOIN toolkit_histories as th ON th.quiz_id = tq.id AND th.user_id = '$user_info->id'
		GROUP BY tk.id
		 ");
        $personalInfo = StudentPersonalInfo::where('user_id', $user_info->id)->first();
//        return $personalInfo;

        return view ('student.profile',compact('user_info', 'subject_based_knowledges', 'personalInfo'));
    }
}
