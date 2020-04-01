<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Toolkit;


class ToolkitController extends Controller
{
   function index(){


	    $toolkit_info = DB::table('users')
	    ->rightJoin('toolkits', 'users.id', '=','toolkits.user_id')
	    ->join('subjects', 'toolkits.subject_id', '=','subjects.id')
	    ->leftJoin('toolkit_ratings', 'toolkits.id', '=', 'toolkit_ratings.toolkit_id')
	    ->select('users.id','users.name','users.email','users.image','users.phone_number','users.balance','users.username','toolkits.id','toolkits.subject_id','toolkits.toolkit_title','toolkits.description','toolkits.slug','toolkits.price','toolkits.thumbnail','subjects.subject_name','subjects.id', DB::raw('avg(toolkit_ratings.rating) as rating'))
	    ->groupBy('toolkits.id')
	    ->orderby('toolkits.subject_id','asc')
	    ->paginate(12);

	    return view ('toolkits',compact('toolkit_info'));
	    //return var_dump($data);
	    //return view('toolkits');
	}
}
