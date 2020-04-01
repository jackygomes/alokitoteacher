<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Course;



class CourseController extends Controller
{

	


    function index(){

	    $course_info = DB::table('users')
	    ->rightJoin('courses', 'users.id', '=','courses.user_id')
	    ->leftJoin('course_ratings', 'courses.id', '=', 'course_ratings.course_id')
	    ->select('users.id','users.name','users.email', 'users.image','users.phone_number','users.balance','users.username','courses.id','courses.thumbnail','courses.title','courses.description','courses.price','courses.slug', DB::raw('avg(course_ratings.rating) as rating'))
	    ->groupBy('courses.id')
	    ->paginate(4);

	    return view ('courses',compact('course_info'));
	    //return var_dump($data);

	}

}
