<?php


namespace App\Http\Controllers;


use App\Job;
use App\Toolkit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController
{
    function index(){
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if($user_info) {
            if($user_info->identifier == 4){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }
        $toolkits = Toolkit::with('subject')->where('type', '=', 'Student')
                                                    ->where('status', '=', 'Approved')
                                                    ->get();

        return view ('student.profile',compact('user_info', 'toolkits'));
    }
}
