<?php

namespace App\Http\Controllers;

use App\ContactUsForm;
use App\Revenue;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
   function index(){
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
