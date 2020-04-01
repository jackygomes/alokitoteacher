<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Job;
use App\JobApplication;
use App\SavedJob;
use Mail;

class AllJobsController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }
    
   	function index(Request $request){
   		if(Auth::user()->identifier == 2){

	    	$posted_jobs = Job::where('user_id', '=', Auth::id())->where('removed', '=', 0)->orderBy('updated_at', 'DESC')->paginate(10);

	    	$users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();


		    return view ('posted-jobs', compact('posted_jobs', 'users'));

   		}elseif (Auth::user()->identifier == 1){

   			if($request->type == 'saved'){
   				$job_info = DB::table('users')
						    ->rightJoin('jobs', 'users.id', '=','jobs.user_id')
						    ->join('saved_jobs', 'saved_jobs.job_id', '=', 'jobs.id')
						    ->select('users.id','users.name','users.email','users.phone_number','users.balance','users.username','users.image','jobs.id as job_id','jobs.description','jobs.job_title','jobs.location','jobs.expected_salary_range','jobs.minimum_requirement','jobs.created_at','jobs.nature', 'jobs.vacancy', 'jobs.deadline')
						    ->where('saved_jobs.user_id', '=', Auth::id())
						    ->orderBy('jobs.created_at', 'asc')
						    ->paginate(10);

   			}else{
				$job_info = DB::table('users')
						    ->rightJoin('jobs', 'users.id', '=','jobs.user_id')
						    ->select('users.id','users.name','users.email','users.phone_number','users.balance','users.username','users.image','jobs.id as job_id','jobs.description','jobs.job_title','jobs.location','jobs.expected_salary_range','jobs.minimum_requirement','jobs.created_at','jobs.nature', 'jobs.vacancy', 'jobs.deadline')
						    ->where('jobs.deadline', '>=', date("Y-m-d"))
						    ->orderBy('jobs.created_at', 'asc')
						    ->paginate(10);
			}

			$locations = Job::groupBy('location')->get();
			$schools = User::where('identifier', '=', 2)->get();

			$users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();
		    return view ('all-jobs', compact('job_info', 'schools', 'locations', 'users'));

		}

		return abort(404);
	}

	function job_applications(Request $request){

		if($request->type == 'shortlisted'){
			$job_applications = DB::table('job_applications')
				    ->join('jobs', 'jobs.id', '=','job_applications.job_id')
				    ->join('users', 'users.id', '=','job_applications.user_id')
				    ->select('job_applications.id', 'users.id as user_id', 'users.name', 'users.username','users.image', 'jobs.id as job_id','jobs.job_title', 'job_applications.shortlisted')
				    ->where('job_applications.shortlisted', '=', 1)
				    ->where('jobs.user_id', '=', Auth::id())
				    ->where('jobs.id', '=', $request->id)

    				->paginate(10);

		}else{
			$job_applications = DB::table('job_applications')
				    ->join('jobs', 'jobs.id', '=','job_applications.job_id')
				    ->join('users', 'users.id', '=','job_applications.user_id')
				    ->select('job_applications.id','users.name', 'users.username','users.image', 'jobs.id as job_id','jobs.job_title', 'job_applications.shortlisted')
				    ->where('jobs.user_id', '=', Auth::id())
				    ->where('jobs.id', '=', $request->id)

    				->paginate(10);

		}

    	$users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();

	    return view ('job_applications', compact('job_applications', 'users'));
	}

	function search_filter(Request $request){

		$job_info = DB::table('users')
				    ->rightJoin('jobs', 'users.id', '=','jobs.user_id')
				    ->select('users.id','users.name','users.email','users.phone_number','users.balance','users.username','users.image','jobs.id as job_id','jobs.description','jobs.job_title','jobs.location','jobs.expected_salary_range','jobs.minimum_requirement','jobs.created_at','jobs.nature', 'jobs.vacancy', 'jobs.deadline');

		if(strlen(trim($request->search)) != 0){
			$job_info = $job_info->where('users.name', 'like', '%' . $request->search . '%')
								->orWhere('jobs.description', 'like', '%' . $request->search . '%')
								->orWhere('jobs.job_title', 'like', '%' . $request->search . '%')
								->orWhere('jobs.location', 'like', '%' . $request->search . '%')
								->orWhere('jobs.expected_salary_range', 'like', '%' . $request->search . '%');
		}

		if(strlen(trim($request->location)) != 0){
			$job_info = $job_info->where('jobs.location', 'like', '%' . $request->location . '%');
		}

		if(strlen(trim($request->school)) != 0){
			$job_info = $job_info->where('users.id', '=', $request->school);
		}
		
		$job_info = $job_info->orderBy('jobs.created_at', 'asc')->paginate(10);

		

	    return view ('all-jobs-search',compact('job_info'));

	}

	function verify_applied_job(Request $request){
		$job_application = JobApplication::where('user_id', '=', Auth::id())
										->where('job_id', '=', $request->job_id)->first();

		if($job_application == null){
			return 'failed';
		}
		return 'success';
	}

	function save_job(Request $request){
		$saved_job = SavedJob::where('user_id', '=', Auth::id())->where('job_id', '=', $request->job_id)->first();
		if($saved_job == null){
			$saved_job = new SavedJob;
			$saved_job->user_id = Auth::id();
			$saved_job->job_id = $request->job_id;
			$saved_job->save();
		}
		
		return 'success';
	}

	function remove_saved_job(Request $request){
		SavedJob::where('user_id', '=', Auth::id())->where('job_id', '=', $request->job_id)->delete();
		return 'success';
	}

	function submit_cover_letter(Request $request){
		$job_application =  new JobApplication;
		$job_application->user_id = Auth::id();
		$job_application->job_id = $request->job_id;
		$job_application->cover_letter = $request->cover_letter;
		$job_application->resume = 'Example';
		$job_application->save();

		return back()->with('success', 'Successfully Applied for the job');
	}

	function job_detail(Request $request){

		$job_info = Job::find($request->job_id);
		$user_info = User::find($job_info->user_id);
		$users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();

		return view('job_details',compact('user_info', 'job_info', 'users'));
	}

	function show_offer_letter(Request $request){
		$job_application = JobApplication::find($request->application_id);

		if($job_application->cover_letter == null){
			return 'No Cover Letter Attached';
		}

		return $job_application->cover_letter;
	}

	function add_job(Request $request){
		$job = new Job;
		$job->user_id = Auth::id();
		$job->job_title = $request->job_title;
		$job->location = $request->location;
		$job->expected_salary_range = $request->expected_salary_range;
		$job->minimum_requirement = $request->minimum_requirement;
		$job->educational_requirement = $request->educational_requirement;
		$job->description = $request->description;
		$job->vacancy = $request->vacancy;
		$job->age_limit = $request->age_limit;
		$job->deadline = $request->deadline;
		$job->nature = $request->nature;
		$job->save();

		return back()->with('success', 'Job Added Successfully');
	}

	function remove_job(Request $request){
		$job = Job::find($request->id);
		$job->removed = 1;
		$job->save();

		return back()->with('danger', 'Job is Removed');
	}

	function shortlisted(Request $request){
		$job = JobApplication::find($request->id);
		$job->shortlisted = 1;
		$job->save();

		return back()->with('success', 'Application Added in Shortlist');
	}

	function confirm_interview(Request $request){
		$application = JobApplication::find($request->id);
		$applicant = User::find($application->user_id);
		$job = Job::find($application->job_id);

		if($job->user_id == Auth::id()){

			Mail::send('emails.job_confirmation', ['job' => $job, 'applicant' => $applicant], function ($message)use($applicant, $job) 
		        {

		            $message->to($applicant->email)->subject('Interview for the position '.$job->job_title);

		        });


			return back()->with('success', 'Email has been sent Successfully!');
		}else{
			return back()->with('failed', 'Something is Wrong!');
		}



	}
}
