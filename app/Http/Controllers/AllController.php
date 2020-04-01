<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Course;
use App\Toolkit;

class AllController extends Controller
{
    
     function index(){

	    $course_info = DB::table('users')
						->rightJoin('courses', 'users.id', '=','courses.user_id')
						->leftJoin('course_ratings', 'courses.id', '=', 'course_ratings.course_id')
						->select('users.id','users.name', 'users.image','courses.thumbnail','users.email','users.phone_number','users.balance','users.username','courses.id','courses.title','courses.description','courses.price','courses.slug', DB::raw('avg(course_ratings.rating) as rating'))
						->groupBy('courses.id')
						->limit(4)
						->get();


	    $toolkit_info = DB::table('users')
						->rightJoin('toolkits', 'users.id', '=','toolkits.user_id')
						->join('subjects', 'toolkits.subject_id', '=','subjects.id')
						->leftJoin('toolkit_ratings', 'toolkits.id', '=', 'toolkit_ratings.toolkit_id')
						->select('users.id','users.name', 'users.image','users.email','users.phone_number','users.balance','users.username','toolkits.id','toolkits.subject_id','toolkits.toolkit_title','toolkits.description','toolkits.thumbnail','toolkits.price','subjects.subject_name','subjects.id','toolkits.slug', DB::raw('avg(toolkit_ratings.rating) as rating'))
						->groupBy('toolkits.id')
						->limit(4)
						->get();
	   

	    return view ('course_and_toolkit',compact('course_info','toolkit_info'));

	}
}
