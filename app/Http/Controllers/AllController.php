<?php

namespace App\Http\Controllers;

use App\Order;
use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Course;
use App\Toolkit;

class AllController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     function index(){
         $userId = Auth::id();
         $user_info = User::where('id', '=', $userId)->first();

         if($user_info->identifier == 4) {

             $course_info = [];
             $toolkit_info = DB::table('users')
                 ->rightJoin('toolkits', 'users.id', '=','toolkits.user_id')
                 ->join('subjects', 'toolkits.subject_id', '=','subjects.id')
                 ->leftJoin('toolkit_ratings', 'toolkits.id', '=', 'toolkit_ratings.toolkit_id')
                 ->select('users.id','users.name', 'users.image','users.email','users.phone_number','users.balance','users.username','toolkits.id','toolkits.subject_id','toolkits.toolkit_title','toolkits.description','toolkits.thumbnail','toolkits.price','subjects.subject_name','subjects.id','toolkits.slug', DB::raw('avg(toolkit_ratings.rating) as rating'))
                 ->where('toolkits.status', '=', 'Approved')
                 ->where('toolkits.type', '=', 'Student')
                 ->groupBy('toolkits.id')
                 ->limit(4)
                 ->get();
         }elseif ($user_info->identifier == 1){

             $course_info = DB::table('users')
                 ->rightJoin('courses', 'users.id', '=','courses.user_id')
                 ->leftJoin('course_ratings', 'courses.id', '=', 'course_ratings.course_id')
                 ->select('users.id','users.name', 'users.image','courses.thumbnail','users.email','users.phone_number','users.balance','users.username','courses.id','courses.title','courses.description','courses.price','courses.slug', DB::raw('avg(course_ratings.rating) as rating'))
                 ->where('courses.status', '=', 'Approved')
                 ->groupBy('courses.id')
                 ->limit(4)
                 ->get();

             $toolkit_info = DB::table('users')
                 ->rightJoin('toolkits', 'users.id', '=','toolkits.user_id')
                 ->join('subjects', 'toolkits.subject_id', '=','subjects.id')
                 ->leftJoin('toolkit_ratings', 'toolkits.id', '=', 'toolkit_ratings.toolkit_id')
                 ->select('users.id','users.name', 'users.image','users.email','users.phone_number','users.balance','users.username','toolkits.id','toolkits.subject_id','toolkits.toolkit_title','toolkits.description','toolkits.thumbnail','toolkits.price','subjects.subject_name','subjects.id','toolkits.slug', DB::raw('avg(toolkit_ratings.rating) as rating'))
                 ->where('toolkits.status', '=', 'Approved')
                 ->where('toolkits.type', '=', 'Teacher')
                 ->groupBy('toolkits.id')
                 ->limit(4)
                 ->get();

         } else {
             $course_info = DB::table('users')
                 ->rightJoin('courses', 'users.id', '=','courses.user_id')
                 ->leftJoin('course_ratings', 'courses.id', '=', 'course_ratings.course_id')
                 ->select('users.id','users.name', 'users.image','courses.thumbnail','users.email','users.phone_number','users.balance','users.username','courses.id','courses.title','courses.description','courses.price','courses.slug', DB::raw('avg(course_ratings.rating) as rating'))
                 ->where('courses.status', '=', 'Approved')
                 ->groupBy('courses.id')
                 ->limit(4)
                 ->get();

             $toolkit_info = DB::table('users')
                 ->rightJoin('toolkits', 'users.id', '=','toolkits.user_id')
                 ->join('subjects', 'toolkits.subject_id', '=','subjects.id')
                 ->leftJoin('toolkit_ratings', 'toolkits.id', '=', 'toolkit_ratings.toolkit_id')
                 ->select('users.id','users.name', 'users.image','users.email','users.phone_number','users.balance','users.username','toolkits.id','toolkits.subject_id','toolkits.toolkit_title','toolkits.description','toolkits.thumbnail','toolkits.price','subjects.subject_name','subjects.id','toolkits.slug', DB::raw('avg(toolkit_ratings.rating) as rating'))
                 ->where('toolkits.status', '=', 'Approved')
                 ->groupBy('toolkits.id')
                 ->limit(4)
                 ->get();
         }
         $resource_info = Resource::with('user')->where('status', 'Approved')->get();

         $userId = Auth::check() ? Auth::user()->id : 0;
         foreach($course_info as $course){
             $isOrdered = Order::where('status', 'paid')
                 ->where('product_type', 'course')
                 ->where('user_id', $userId)
                 ->where('product_id', $course->id)->count();

             $course->isBought = $isOrdered ? 1 : 0;
         }

         return view ('course_and_toolkit',compact('user_info','course_info','toolkit_info', 'resource_info'));

	}
}
