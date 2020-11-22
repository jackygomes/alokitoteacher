<?php

namespace App\Http\Controllers;

use App\JobPrice;
use App\Order;
use Carbon\Carbon;
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
//        $this->middleware('auth');
//        $this->middleware('auth')->except(['index']);
        $this->middleware('auth', ['except' => ['index', 'search_filter']]);
    }

   	function index(Request $request){
//   		if(Auth::user()->identifier == 2){
//
//	    	$posted_jobs = Job::where('user_id', '=', Auth::id())->where('removed', '=', 0)->orderBy('updated_at', 'DESC')->paginate(10);
//
//	    	$users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();
//
//
//		    return view ('posted-jobs', compact('posted_jobs', 'users'));
//
//   		}elseif (Auth::user()->identifier == 1 || Auth::user()->identifier == 101){

   			if($request->type == 'saved'){
   				$job_info = DB::table('users')
						    ->rightJoin('jobs', 'users.id', '=','jobs.user_id')
						    ->join('saved_jobs', 'saved_jobs.job_id', '=', 'jobs.id')
						    ->select('users.id','users.name','users.email','users.phone_number','users.balance','users.username','users.image','jobs.id as job_id','jobs.description','jobs.job_title','jobs.location','jobs.expected_salary_range','jobs.job_responsibilities','jobs.created_at','jobs.nature', 'jobs.vacancy', 'jobs.deadline')
						    ->where('saved_jobs.user_id', '=', Auth::id())
						    ->orderBy('jobs.created_at', 'asc')
						    ->paginate(10);

   			}else{
				$job_info = DB::table('users')
						    ->rightJoin('jobs', 'users.id', '=','jobs.user_id')
						    ->select('users.id','users.name','users.email','users.phone_number','users.balance','users.username','users.image','jobs.id as job_id','jobs.description','jobs.job_title','jobs.location','jobs.expected_salary_range','jobs.job_responsibilities','jobs.created_at','jobs.nature', 'jobs.vacancy', 'jobs.deadline')
						    ->where('jobs.deadline', '>=', date("Y-m-d"))
						    ->orderBy('jobs.created_at', 'asc')
						    ->paginate(10);
			}

			$locations = Job::groupBy('location')->get();
			$schools = User::where('identifier', '=', 2)->get();

			$users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();
		    return view ('all-jobs', compact('job_info', 'schools', 'locations', 'users'));

//		}

//		return abort(404);
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
				    ->select('jobs.id as job_id', 'users.id as user_id','users.name','users.email','users.phone_number','users.balance','users.username','users.image','jobs.description','jobs.job_title','jobs.location','jobs.expected_salary_range','jobs.job_responsibilities','jobs.created_at','jobs.nature', 'jobs.vacancy', 'jobs.deadline', 'jobs.removed', 'jobs.admin_status');


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

        $condition = [
            ['jobs.removed', '=', 0],
            ['jobs.admin_status', '=', 'Approved'],
        ];

		$job_info = $job_info
                    ->where($condition)
                    ->whereDate('jobs.deadline', '>', Carbon::today()->toDateString())
                    ->orderBy('jobs.created_at', 'DESC')->paginate(10);


        $userId = Auth::check() ? Auth::user()->id : 0;
        foreach($job_info as $job){

            $appliedCount = JobApplication::where('user_id','=', $userId)->where('job_id','=', $job->job_id)->count();

            $job->isApplied = $appliedCount ? 1 : 0;
        }
//        return json_encode($job_info);

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
		$job_application->resume = null;
		$job_application->save();

		return back()->with('success', 'Successfully Applied for the job');
	}

	function job_detail(Request $request){

		$job_info = Job::find($request->job_id);
		$user_info = User::find($job_info->user_id);
		$users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();
        $leaderBoard = \App\LeaderBoard::orderby('position', 'asc')->with('user')->limit(10)->get();
        $applicants = JobApplication::where('job_id', $request->job_id)->paginate(10);
        $n = 0;

        $userId = Auth::check() ? Auth::user()->id : 0;
        $appliedCount = JobApplication::where('user_id','=', $userId)->where('job_id','=', $job_info->id)->count();
        $job_info->isApplied = $appliedCount ? 1 : 0;

        foreach ($applicants as $applicant) {
            $n++;
            $applicant->no = $n;
        }


		return view('job_details',compact('user_info', 'job_info', 'users','leaderBoard', 'applicants'));
	}

	function show_offer_letter(Request $request){
		$job_application = JobApplication::find($request->application_id);

		if($job_application->cover_letter == null){
			return 'No Cover Letter Attached';
		}

		return $job_application->cover_letter;
	}

	function add_job(Request $request){
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        $jobPrice = JobPrice::find(1);
        if($user_info->balance >= $jobPrice->price){
            $job = new Job;
            $job->user_id = Auth::id();
            $job->job_title = $request->job_title;
            $job->location = $request->location;
            $job->expected_salary_range = $request->expected_salary_range;
            $job->job_responsibilities = $request->job_responsibilities;
            $job->educational_requirements = $request->educational_requirement;
            $job->experience_requirements = $request->experience_requirements;
            $job->additional_requirements  = $request->additional_requirements;
            $job->compensation_other_benefits = $request->compensation_other_benefits;
            $job->description = $request->description;
            $job->vacancy = $request->vacancy;
            $job->age_limit = $request->age_limit;
            $job->gender = $request->gender;
            $job->deadline = $request->deadline;
            $job->nature = $request->nature;
            $job->save();

            $orderData = [
                'user_id'           => Auth::id(),
                'product_type'      => 'Job',
                'product_id'        => $job->id,
                'amount'            => $jobPrice->price,
                'status'            => 'paid',
                'transaction_id'    => "ALOKITO_" . uniqid(),
                'currency'          => 'BDT'
            ];

            Order::create($orderData);

            $user_info->balance = $user_info->balance - $jobPrice->price;
            $user_info->save();


            return back()->with('success', 'Job Added Successfully');
        } else {
            return back()->with('danger', 'Insufficient Balance');
        }

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

    /**
     * view all jobs for admin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function adminJobList()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }
        $jobs = Job::orderBy('id', 'desc')->get();
        return view('admin.job-list', compact('jobs', 'user_info'));
    }

    /**
     * View single job for approve disapprove
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function adminEdit($id)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if(isset($user_info) && $user_info->identifier != 101){

            return abort(404);
        }

        $job = Job::find($id);
        return view('admin.job-edit', compact('user_info', 'job'));
    }

    /**
     * admin view job approval edit
     *
     * @param Request $request
     * @param $id
     */
    public function adminUpdate(Request $request, $id)
    {

//        return $request->all();
        $job = Job::find($id);
        $job->admin_status = $request->admin_status;

        if($request->admin_status == 'Disapprove'){
            $this->validate($request, [
                'comment' => 'required',
            ]);
            $job->admin_comment = $request->comment;
        }elseif($request->admin_status == 'Approved'){
            $job->admin_comment = null;
        }

        $job->save();
        return back()->with('success', 'Job Status Updated Successfully.');
    }

    public function jobEdit($id)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        if(isset($user_info) && $user_info->identifier != 2){

            return abort(404);
        }
        $job = Job::find($id);
        return view('job_edit', compact('user_info', 'job'));
    }

    /**
     * job update from school
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|mixed|string|void
     */
    public function jobUpdate(Request $request, $id)
    {

        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 2){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }

        try{

            $job = Job::find($id);
            if ($job == null) {
                return abort(404);
            }
            $this->validate($request, [
                'job_title'                 => 'required',
                'job_location'              => 'required',
                'description'               => 'required',
                'job_responsibilities'      => 'required',
                'educational_requirements'  => 'required',
                'experience_requirements'   => 'required',
                'salary'                    => 'required',
                'age_limit'                 => 'required',
                'gender'                    => 'required',
                'nature'                    => 'required',
                'vacancy'                   => 'required',
                'deadline'                  => 'required',
            ]);


            $job->job_title = $request->job_title;
            $job->location = $request->job_location;
            $job->expected_salary_range = $request->salary;
            $job->job_responsibilities = $request->job_responsibilities;
            $job->educational_requirements = $request->educational_requirements;
            $job->experience_requirements = $request->experience_requirements;
            $job->additional_requirements  = $request->additional_requirements;
            $job->compensation_other_benefits = $request->compensation_other_benefits;
            $job->description = $request->description;
            $job->vacancy = $request->vacancy;
            $job->age_limit = $request->age_limit;
            $job->gender = $request->gender;
            $job->deadline = $request->deadline;
            $job->nature = $request->nature;
            $job->save();

            return back()->with('success', 'Job Edited Successfully.');

        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

    }

    public function schoolJobStatusUpdate(Request $request, $id)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if($user_info) {
            if($user_info->identifier == 2){
            } else {
                return abort(404);
            }
        }else {
            return abort(404);
        }
        $application = JobApplication::find($id);

        $application->status = $request->admin_status;

        $application->save();

        return back()->with('job-status-success', 'Job Status Successfully Changed.');
    }
}
