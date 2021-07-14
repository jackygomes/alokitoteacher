<?php

namespace App\Http\Controllers;

use App\CourseActivist;
use App\User;
use App\Workshop;
use App\Revenue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
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
        return view('workshop.create', compact('user_info', 'users', 'trainers'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                // 'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
                'description' => 'required',
                'price' => 'required',
                'type' => 'required',
                'duration' => 'required',
                'total_credit_hours' => 'required',
                'date_time' => 'required',
                'last_date' => 'required'
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
                'about_this_workshop' => $request->about_this_workshop,
                'what_you_will_learn' => $request->what_you_will_learn
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
                'description' => 'required',
                'price' => 'required',
                'type' => 'required',
                'duration' => 'required',
                'total_credit_hours' => 'required',
                'date_time' => 'required',
                'last_date' => 'required'
            ]);
            $image = Workshop::where('id', $request->id)->pluck('thumbnail');
            $image_name = sizeof($image) ? $image[0] : null;

            if (isset($request->thumbnail)) {
                $image = $request->file('thumbnail');
                $image_name = 'WS' . md5(rand()) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path("images/thumbnail"), $image_name);
            }

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
                'about_this_workshop' => $request->about_this_workshop,
                'what_you_will_learn' => $request->what_you_will_learn
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
        $thumbnailPart = '<div class="video-content embed-responsive embed-responsive-16by9 "><iframe src="' . $workshop->preview_video . '" width="1150" height="650" frameborder="0" allow="autoplay;   fullscreen" allowfullscreen></iframe></div>';

        return view('workshop.overview', compact('workshop', 'thumbnailPart'));
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
    public function list()
    {
        $workshops = Workshop::paginate(10);
        return view('workshop.list', compact('workshops'));
    }
}