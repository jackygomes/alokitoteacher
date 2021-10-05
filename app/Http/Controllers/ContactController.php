<?php

namespace App\Http\Controllers;

use App\ContactUsForm;
use App\CourseLeaderBoard;
use App\LeaderBoard;
use App\Resource;
use App\ResourceLeaderBoard;
use App\ResourceRating;
use App\Revenue;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
   function index(){
		// $userTodeduct = [7,8,14,9,10,12,11,1589,16,577,5,83,13,32];
		// $users = User::where('identifier', '=','1')->where('id', 2005)->get();
		// $users = User::where('identifier', '=','1')->whereNotIn('id',  $userTodeduct)->get();
		// $juri=0;
		// $rating=0;
		// $noRating=0;
		// foreach ($users as $user) {
		// // Resource leaderboard Start

		// 	$resources = Resource::where('user_id', $user->id)->where('status', 'Approved')->where('deleted', '0')->get();
		// 	$resourceRatingCount = 0;
		// 	$totalRating = 0;
		// 	$totalReview = 0;
		// 	$resourceCount = 0;
		// 	$totalJuriPoint = 0;
		// 	$aveJuriPoint = 0;
		// 	$noOfRating = 0;
		// 	foreach($resources as $resource){
		// 		$resourceCount++;
		// 		$totalJuriPoint += $resource->juri_point;
		// 		$resource_rating = ResourceRating::where('resource_id', $resource->id)->get();
		// 		foreach($resource_rating as $rating){
		// 			$resourceRatingCount++;
		// 			$totalRating += $rating->rating;
		// 			$totalReview ++;
		// 		}
		// 	}
		// 	if($resourceCount > 0) $juri = $aveJuriPoint = $totalJuriPoint/$resourceCount;
		// 	if($resourceRatingCount > 0) {
		// 		$rating = $aveResourceRating = ((($totalRating / $resourceRatingCount)/5)*20);
		// 		$noRating = $noOfRating = ($totalReview/$users->count())*20;
		// 	} else $aveResourceRating = 0;

		// 	$totalScore = $aveJuriPoint + $aveResourceRating + $noOfRating;

		// 	$resourceleaderboard = ResourceLeaderBoard::where('user_id', $user->id)->first();
		// 	if($resourceleaderboard) {
		// 		$resourceleaderboard->score = $totalScore;
		// 		$resourceleaderboard->no_of_review  = $totalReview;
		// 		$resourceleaderboard->save();
		// 	} else {
		// 		$resourceleaderboardData = [
		// 			'user_id'   => $user->id,
		// 			'score'     => $aveResourceRating,
		// 			'position'  => 9999,
		// 			'no_of_review'  => $totalReview,

		// 		];
		// 		ResourceLeaderBoard::create($resourceleaderboardData);
		// 	}
		// }
	
		// return $juri.' | '. $rating.' | '. $noRating ;
		return view('contact-us');
	}

	public function store(Request $request){
		$this->validate($request, [
            'name'   => 'required',
            'email'  => 'required',
            'message'=> 'required',
        ]);

		try{
            $data = [
                'name'   => $request->name,
				'email'  => $request->email,
				'message'=> $request->message,
            ];
			
		   	ContactUsForm::create($data);

		   return redirect()->back()->with('success', 'Your message sent successfully');

        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }
	}

	public function adminMessageListView() {
		try{

			$user_info = User::where('id', '=', Auth::id())->first();
			$revenue = Revenue::all()->sum('revenue');
			$contact_messages = ContactUsForm::get();

			return view('admin.contact-message-list', compact('contact_messages', 'user_info','revenue'));

        } catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }
	}
}
