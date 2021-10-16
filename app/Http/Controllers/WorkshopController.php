<?php

namespace App\Http\Controllers;

use App\CourseActivist;
use App\User;
use App\Workshop;
use App\Revenue;
use App\WorkshopRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Exports\WorkshopRegistrationExport;
use App\WorkshopRating;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WorkshopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => 'registerLogin']);
    }
    public function registerLogin($slug) {
        if(strpos($slug, 'no-slug') !== false){
            $data = explode("|", $slug);
            $workshopId = $data[1];
            return redirect()->route('workshops.index', compact('workshopId'));
        }else{
            return redirect()->route('workshops.overview', $slug);
        }
    }

    public function index()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }
        $revenue = Revenue::all()->sum('revenue');
        $workshops = Workshop::get();
        return view('workshop.index', compact('user_info', 'workshops', 'revenue'));
    }

    public function create()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }
        $trainers = CourseActivist::where('type', 'Trainer')->get();
        return view('workshop.create', compact('user_info', 'trainers'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                // 'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
                // 'description' => 'required',
                'price' => 'required',
                'type' => 'required',
                'duration' => 'required',
                'total_credit_hours' => 'required',
                'date_time' => 'required',
                'last_date' => 'required',
                'starting_date' => 'required',
                'status' => 'required'
            ]);

            $image = $request->file('thumbnail');
            $image_name = 'WS' . md5(rand()) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path("images/thumbnail"), $image_name);

            $workshop = [
                'name' => $request->name,
                'slug' => str_slug($request->name) . '-' . $this->generateRandomString(5),
                'thumbnail' => $image_name,
                'description' => $request->description,
                'price' => $request->price,
                'preview_video' => $request->preview_video,
                'trainers' => json_encode($request->trainers),
                'type' => $request->type,
                'duration' => $request->duration,
                'total_credit_hours' => $request->total_credit_hours,
                'date_time' => $request->date_time,
                'last_date' => $request->last_date,
                'starting_date' => $request->starting_date,
                'about_this_workshop' => $request->about_this_workshop,
                'what_you_will_learn' => $request->what_you_will_learn,
                'status' => $request->status
            ];
            // return $workshop;

            $success = Workshop::create($workshop);
            if ($success) return redirect()->route('workshop.index')->with(['success' => 'Workshop Saved Successfully!']);
            else return redirect()->route('workshop.index')->with(['error' => 'Something went wrong!']);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }
    }

    public function edit($id)
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104 &&  $user_info->identifier != 1)) {

            return abort(404);
        }
        $trainers = CourseActivist::where('type', 'Trainer')->get();
        $workshop = Workshop::find($id);
        $currentTrainers = json_decode($workshop->trainers);
        return view('workshop.edit', compact('user_info', 'users', 'trainers', 'workshop', 'currentTrainers'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                // 'thumbnail' => 'required',
                // 'description' => 'required',
                'price' => 'required',
                'type' => 'required',
                'duration' => 'required',
                'total_credit_hours' => 'required',
                'date_time' => 'required',
                'last_date' => 'required',
                'starting_date' => 'required',
                'status' => 'required'
            ]);
            $image = Workshop::where('id', $request->id)->pluck('thumbnail');
            $image_name = sizeof($image) ? $image[0] : null;

            if (isset($request->thumbnail)) {
                $image = $request->file('thumbnail');
                $image_name = 'WS' . md5(rand()) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path("images/thumbnail"), $image_name);
            }

            $oldData = Workshop::find($request->id);


            $workshop = [
                'name' => $request->name,
                'slug' => $oldData->name == $request->name ? $oldData->slug : str_slug($request->name) . '-' . $this->generateRandomString(5),
                'thumbnail' => $image_name,
                'description' => $request->description,
                'price' => $request->price,
                'preview_video' => $request->preview_video,
                'trainers' => json_encode($request->trainers),
                'type' => $request->type,
                'duration' => $request->duration,
                'total_credit_hours' => $request->total_credit_hours,
                'date_time' => $request->date_time,
                'last_date' => $request->last_date,
                'starting_date' => $request->starting_date,
                'about_this_workshop' => $request->about_this_workshop,
                'what_you_will_learn' => $request->what_you_will_learn,
                'status' => $request->status
            ];
            // return $workshop;

            $success = Workshop::updateOrCreate(
                ['id' => $request->id],
                $workshop
            );
            if ($success) return redirect()->route('workshop.index')->with(['success' => 'Workshop Updated Successfully!']);
            else return redirect()->route('workshop.index')->with(['error' => 'Something went wrong!']);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }
    }

    public function delete($id)
    {
        $workshop = Workshop::find($id);
        $workshop->delete();
        return redirect()->back()->with(['success' => 'Workshop Deleted Successfully!']);
    }

    public function overview($slug)
    {
        $workshop = Workshop::where('slug', $slug)->first();
        $content_rating = DB::table('workshop_ratings')
            ->where('workshop_id', '=', $workshop->id)
            ->avg('rating');
        if ($workshop->preview_video) {
            $thumbnailPart = '<div class="video-content embed-responsive embed-responsive-16by9 "><iframe src="' . $workshop->preview_video . '" width="1150" height="650" frameborder="0" allow="autoplay;   fullscreen" allowfullscreen></iframe></div>';
        } else {
            $thumbnailPart = false;
        }
        if(Auth::user()){
            $formData = WorkshopRegistration::where('user_id', auth()->user()->id)->first();
            if ($formData) $formData->toarray();
            else {
                $userData = auth()->user();
                $formData = [
                    'name' => $userData->name,
                    'email' => $userData->email,
                    'phone' => $userData->phone,
                    'gender' => $userData->gender,
                    "dob" => "",
                    "institution" => "",
                    "passing_year" => "",
                    "subject" => "",
                    "education_level" => "",
                    "is_teacher" => "",
                    "years_teaching" => "",
                    "teaching_institution" => "",
                    "school_type" => "",
                    "previous_training" => "",
                    "training_programs" => "",
                    "online_workshop" => "",
                    "ambassador" => "",
                    "ambassador_ref" => "",
                    "lead" => ""
                ];
            }
            $alreadyRegistered = WorkshopRegistration::where('workshop_id', $workshop->id)->where('user_id', auth()->user()->id)->count();
            $ratingGiven = WorkshopRating::where('workshop_id', $workshop->id)->where('user_id', auth()->user()->id)->count();
        }else {
            $formData = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'gender' => '',
                "dob" => "",
                "institution" => "",
                "passing_year" => "",
                "subject" => "",
                "education_level" => "",
                "is_teacher" => "",
                "years_teaching" => "",
                "teaching_institution" => "",
                "school_type" => "",
                "previous_training" => "",
                "training_programs" => "",
                "online_workshop" => "",
                "ambassador" => "",
                "ambassador_ref" => "",
                "lead" => ""
            ];
            $alreadyRegistered = [];
            $ratingGiven = 0;
        }
        
        return view('workshop.overview', compact('workshop', 'thumbnailPart', 'content_rating', 'formData', 'alreadyRegistered', 'ratingGiven'));
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //For Teachers...
    public function list(Request $request)
    {
        $workshopId = $request->workshopId;
        $workshops = Workshop::where('status', 'Enabled')->paginate(10);

        if(Auth::user()){
            $formData = WorkshopRegistration::where('user_id', auth()->user()->id)->first();
            if ($formData) $formData->toarray();
            else {
                $userData = auth()->user();
                $formData = [
                    'name' => $userData->name,
                    'email' => $userData->email,
                    'phone' => $userData->phone,
                    'gender' => $userData->gender,
                    "dob" => "",
                    "institution" => "",
                    "passing_year" => "",
                    "subject" => "",
                    "education_level" => "",
                    "is_teacher" => "",
                    "years_teaching" => "",
                    "teaching_institution" => "",
                    "school_type" => "",
                    "previous_training" => "",
                    "training_programs" => "",
                    "online_workshop" => "",
                    "ambassador" => "",
                    "ambassador_ref" => "",
                    "lead" => ""
                ];
            }
        }else {
            $formData = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'gender' => '',
                "dob" => "",
                "institution" => "",
                "passing_year" => "",
                "subject" => "",
                "education_level" => "",
                "is_teacher" => "",
                "years_teaching" => "",
                "teaching_institution" => "",
                "school_type" => "",
                "previous_training" => "",
                "training_programs" => "",
                "online_workshop" => "",
                "ambassador" => "",
                "ambassador_ref" => "",
                "lead" => ""
            ];
        }

        foreach ($workshops as $workshop) {
            $workshop->rating = DB::table('workshop_ratings')
                ->where('workshop_id', '=', $workshop->id)
                ->avg('rating');
            $workshop->ratingCount = DB::table('workshop_ratings')
                ->where('workshop_id', '=', $workshop->id)
                ->count('rating');
        }

        return view('workshop.list', compact('workshops', 'formData', 'workshopId'));
    }

    public function register(Request $request)
    {
        try {
            $register = [
                'workshop_id' => $request->workshop_id,
                'name' => $request->name,
                'user_id' => $request->id,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'phone' => $request->phone,
                'email' => $request->email,
                'institution' => $request->institution,
                'passing_year' => $request->passing_year,
                'subject' => $request->subject,
                'education_level' => $request->education_level,
                'is_teacher' => $request->is_teacher,
                'years_teaching' => $request->years_teaching,
                'teaching_institution' => $request->teaching_institution,
                'school_type' => $request->school_type,
                'classes' => json_encode($request->classes),
                'subjects' => json_encode($request->subjects),
                'previous_training' => $request->previous_training,
                'training_programs' => $request->training_programs,
                'online_workshop' => $request->online_workshop,
                'ambassador' => $request->ambassador,
                'ambassador_ref' => $request->ambassador_ref,
                'lead' => $request->lead,
                'status' => $request->status
            ];

            $success = WorkshopRegistration::create($register);
            if ($success) return redirect()->back()->with(['success' => 'Registration Successful!']);
            else return redirect()->back('workshop.index')->with(['error' => 'Something went wrong!']);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }
    }

    public function export($workshop)
    {
        return Excel::download(new WorkshopRegistrationExport($workshop), 'workshop.xlsx');
    }

    function rateWorkshop(Request $request)
    {
        try {
            $rating = WorkshopRating::where('user_id', '=', Auth::id())
                ->where('workshop_id', '=', $request->workshop_id)
                ->first();
            if ($rating == null) {
                $rating = new WorkshopRating;
                $rating->user_id = Auth::id();
                $rating->workshop_id = $request->workshop_id;
            }

            $rating->rating = $request->workshopRating;
            $rating->save();

            return back()->with('success', 'Workshop rated successfully!');
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }
    }
}
