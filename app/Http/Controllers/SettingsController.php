<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Academic;
use App\WorkExperience;
use Hash;



class SettingsController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){

    	if(Auth::user()->identifier == 1){
    		$recent_work = WorkExperience::where('user_id', '=', Auth::id())->where('to_date', '=', '0000-00-00')->first();
	    	$recent_institute = Academic::where('user_id', '=', Auth::id())->orderBy('passing_year', 'DESC')->first();

		    return view ('settings_teacher', compact('recent_work', 'recent_institute'));

    	}elseif(Auth::user()->identifier == 2) {
            return view ('settings_school');

        } elseif(Auth::user()->identifier == 4) {
            return view ('student.settings');

        }

	}

	function updateInfo(Request $request){


        $user = User::find(Auth::id());
		$user->name = $request->name;
		$user->phone_number = $request->phone_number;
		$user->gender = $request->gender;

//        return $user;

		if($user->identifier == 1 || $user->identifier == 4){
			$user->date_of_birth = $request->date_of_birth;
		}elseif($user->identifier == 2){
			$user->location = $request->location;
			$user->curriculum = $request->curriculum;
			$user->classes_from = $request->classes_from;
			$user->classes_to = $request->classes_to;
			$user->no_of_student = $request->no_of_student;
			$user->no_of_teacher = $request->no_of_teacher;
			$user->no_of_teacher_alo_cert = $request->no_of_teacher_alo_cert;
			$user->no_of_alokito_master = $request->no_of_alokito_master;
			$user->founded = $request->founded;
			$user->playing_area = $request->playing_area;
			$user->students_per_classroom = $request->students_per_classroom;
			$user->min_qualification_teacher = $request->min_qualification_teacher;
			$user->subject_periods = $request->subject_periods;
		}
		$user->save();


		return back()->with('successInfo', 'Info Updated Successfully');

	}

	function updatePassword(Request $request){

		if(!Hash::check($request->current_password, Auth::user()->password)){
			return redirect()->back()->withInput()->withErrors([
                'current_password' => 'Current Password is Wrong.',
            ]);
		}

		if(strlen($request->password) < 8){
			return redirect()->back()->withInput()->withErrors([
                'password' => 'Minimum 8 characters are required',
            ]);
		}

		if($request->password != $request->password_confirmation){
			return redirect()->back()->withInput()->withErrors([
                'password' => 'Password does not match',
            ]);
		}

		$user = User::find(Auth::id());
		$user->password = Hash::make($request->password);
		$user->save();

		Auth::logoutOtherDevices($request->password);

		return back()->with('successPassword', 'Password Updated Successfully');
	}

}
