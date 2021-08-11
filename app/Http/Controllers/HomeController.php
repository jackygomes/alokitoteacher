<?php

namespace App\Http\Controllers;

use App\CourseVideo;
use App\LeaderBoard;
use App\Order;
use App\Resource;
use App\TeacherStudentCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Course;
use App\CourseLeaderBoards;
use App\Toolkit;
use App\EmailSubscriber;
use App\ResourceLeaderBoards;

class HomeController extends Controller
{

	function index(){
        $course_info = DB::table('users')
						->rightJoin('courses', 'users.id', '=','courses.user_id')
						->leftJoin('course_ratings', 'courses.id', '=', 'course_ratings.course_id')
						->select('users.id','users.name', 'users.image','courses.thumbnail','users.email','users.phone_number','users.balance','users.username','courses.id','courses.title','courses.description','courses.price','courses.slug', DB::raw('avg(course_ratings.rating) as rating'), DB::raw('count(course_ratings.rating) as rating_count'))
                        ->where('courses.status', '=', 'Approved')
                        ->groupBy('courses.id')
                        ->orderBy('courses.created_at', 'desc')
						->get();
        $userId = Auth::check() ? Auth::user()->id : 0;
        foreach($course_info as $course){
            $isOrdered = Order::where('status', 'paid')
                ->where('product_type', 'course')
                ->where('user_id', $userId)
                ->where('product_id', $course->id)->count();
            $course->lessons = CourseVideo::where('course_id', $course->id)->count();

            $course->isBought = $isOrdered ? 1 : 0;
        }

	    $toolkit_info = DB::table('users')
						->rightJoin('toolkits', 'users.id', '=','toolkits.user_id')
						->join('subjects', 'toolkits.subject_id', '=','subjects.id')
						->leftJoin('toolkit_ratings', 'toolkits.id', '=', 'toolkit_ratings.toolkit_id')
						->select('users.id as user_id','users.name', 'users.image','users.email','users.phone_number','users.balance','users.username','toolkits.id as toolkit_id','toolkits.subject_id','toolkits.toolkit_title','toolkits.description','toolkits.thumbnail','toolkits.price','subjects.subject_name','subjects.id','toolkits.slug', DB::raw('avg(toolkit_ratings.rating) as rating'))
                        ->where('toolkits.status', '=', 'Approved')
                        ->groupBy('toolkits.id')
						->inRandomOrder(12)
						->get();

        foreach($toolkit_info as $toolkit){
            $isOrdered = Order::where('status', 'paid')
                ->where('product_type', 'toolkit')
                ->where('user_id', $userId)
                ->where('product_id', $toolkit->toolkit_id)->count();

            $toolkit->isBought = $isOrdered ? 1 : 0;
        }

       $resources = Resource::with('user')->with('ratingCount')->limit(10)->where('deleted',0)->where('status', '=', 'Approved')->orderBy('created_at', 'desc')->get();

        foreach($resources as $resource){
            $isOrdered = Order::where('status', 'paid')
                ->where('product_type', 'resource')
                ->where('user_id', $userId)
                ->where('product_id', $resource->id)->count();

            $resource->isBought = $isOrdered ? 1 : 0;
        }

		$users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();
		$stat = TeacherStudentCount::find(1);

        $leaderBoard = LeaderBoard::orderby('position', 'asc')->with('user')->limit(10)->get();
        $courseleaderBoard = CourseLeaderBoards::orderby('position', 'asc')->with('user')->limit(10)->get();
        $resourceleaderBoard = ResourceLeaderBoards::orderby('position', 'asc')->with('user')->limit(10)->get();

//        return $leaderBoard;
	    return view ('home',compact('course_info','toolkit_info', 'users','stat','leaderBoard', 'resources', 'courseleaderBoard', 'resourceleaderBoard'));
	}

	function email_subscribe(Request $request){
		$email_subscribe = new EmailSubscriber;
		$email_subscribe->email = $request->email;
		$email_subscribe->save();

		return back()->with('subscribed', 'Successfully Subscribed');

	}
}
