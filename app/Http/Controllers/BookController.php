<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\BookWorkshop;


class BookController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){
   		
      $users = User::where('identifier', '=', 1)->where('id', '!=', 1)->orderBy('rating', 'DESC')->limit(10)->get();

      return view ('book_workshop', compact('users'));
   	}

   	function book_workshop(Request $request){
   		$book_workshop = new BookWorkshop;
   		$book_workshop->user_id = Auth::id();
      $book_workshop->total_person = $request->person;
      $book_workshop->book_workshop = $request->workshop;
      $book_workshop->time_slot = $request->time_slot;
   		$book_workshop->from = $request->from;
   		$book_workshop->to = $request->to;
   		$book_workshop->details = $request->details;
   		$book_workshop->save();

   		return back()->with('success', 'Booked a Workshop Successfully');
   	}
}