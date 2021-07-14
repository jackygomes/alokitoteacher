<?php

namespace App\Http\Controllers;

use App\Academic;
use App\JobPrice;
use App\Resource;
use App\Toolkit;
use App\TrackHistory;
use App\WorkExperience;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Job;
use App\Transaction;

class SchoolController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    function index(Request $request)
    {

        $username = $request->username;

        $user_info = User::where('username', '=', $username)->first();

        if (isset($user_info) && $user_info->identifier != 2) {
            return abort(404);
        }

        $job_info = Job::where('user_id', '=', $user_info->id)->get();

        $users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();

        $earnings = Transaction::where('user_id', Auth::id())->where('transaction_type', 'Earning')->sum('amount');
			$condition = [
				['jobs.removed', '=', 0],
				['jobs.admin_status', '=', 'Approved'],
			];
        $openJobs = Job::where('user_id', '=', $user_info->id)
                ->where($condition)
                ->whereDate('jobs.deadline', '>', Carbon::today()->toDateString())
                ->get();

        return view('schools', compact('openJobs', 'earnings', 'user_info', 'job_info', 'users'));

        //return var_dump($data);

    }

    public function dashboard()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && $user_info->identifier != 2) {

            return abort(404);
        }

        $job_info = Job::where('user_id', '=', $user_info->id)->orderby('id', 'desc')->get();
        $leaderBoard = \App\LeaderBoard::orderby('position', 'asc')->with('user')->limit(10)->get();
        $toolkits = Toolkit::with('subject')->where('deleted', 0)->where('user_id', '=', $userId)->paginate(5);
        $resources = Resource::where('user_id', $userId)->where('deleted', 0)->paginate(10);
        $jobPrice = JobPrice::find(1);

        $deadLineMin = Carbon::now()->format('Y-m-d');
        $deadLineMax = Carbon::now()->addMonth(1)->format('Y-m-d');
        $featuredJobCount = Job::where('featured', 1)->whereDate('deadline', '>', \Carbon\Carbon::today()->toDateString())->count();
        $earnings = Transaction::where('user_id', Auth::id())->where('transaction_type', 'Earning')->sum('amount');

        $condition = [
            ['jobs.removed', '=', 0],
            ['jobs.admin_status', '=', 'Approved'],
        ];
        $openJobs = Job::where('user_id', '=', $user_info->id)
                ->where($condition)
                ->whereDate('jobs.deadline', '>', Carbon::today()->toDateString())
                ->get();

        foreach ($toolkits as $toolkit) {
            $toolkit->people_taken = TrackHistory::where('course_toolkit_id', $toolkit->id)->count();
        }

        return view('educational-institute.dashboard', compact( 'openJobs', 'earnings','leaderBoard', 'job_info', 'resources', 'toolkits', 'user_info', 'jobPrice', 'deadLineMin', 'deadLineMax', 'featuredJobCount'));
    }

    function add_job(Request $request)
    {
        $newJob = new Job;
        $newJob->job_title = $request->job_title;
        $newJob->location = $request->location;
        $newJob->expected_salary_range = $request->expected_salary_range;
        $newJob->minimum_requirement = $request->minimum_requirement;
        $newJob->description = $request->description;
        $newJob->save();
        return back()->with('success', 'Successfully posted the job');
    }
}
