<?php

namespace App\Http\Controllers;

use App\User;
use App\Revenue;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        return view('withdraw.create', compact('user_info'));
    }

    public function submit(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user->balance < $request->amount) return redirect()->back()->with('successFailed', 'Insufficient Balance');
        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->transaction_type = 'withdrawal';
        $transaction->amount = $request->amount;
        $transaction->note = $request->payment_details;
        $transaction->save();
        return redirect()->back()->with('successInfo', 'Withdrawal Request Submitted Successfully!');
    }

    public function list()
    {
        $user_info = User::find(Auth::id());
        if (isset($user_info) && ($user_info->identifier != 101 && $user_info->identifier != 104)) {
            return abort(404);
        }
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        $revenue = Revenue::all()->sum('revenue');
        $transactions = Transaction::where('transaction_type', 'withdrawal')->get();
        return view('withdraw.list', compact('transactions', 'user_info', 'revenue'));
    }

    public function approve($id)
    {
        $transaction = Transaction::find($id);
        $user = User::find($transaction->user_id);
        if ($transaction->amount > $user->balance) {
            $transaction->status = 'rejected';
            $transaction->update();
            return redirect()->back()->with('success', 'Request has been dismissed due to inshifient balance!');
        }
        $user->balance = $user->balance - $transaction->amount;
        $user->update();

        $transaction->status = 'paid';
        $transaction->update();
        return redirect()->back()->with('success', 'Withdrawal Request Approved Successfully!');
    }
}
