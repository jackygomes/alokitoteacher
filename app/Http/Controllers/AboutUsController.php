<?php

namespace App\Http\Controllers;

// use App\Revenue;
// use App\Transaction;
// use App\User;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    function index(){
		// $admin = User::where('username', 'admin')->first();

		// $transactionSpendingData = [
		// 	'user_id'           => $admin->id,
		// 	// 'order_id'          => $order->id,
		// 	'transaction_type'  => 'AdminFundTransferToSuperadmin',
		// 	'amount'            => $admin->balance,
		// 	'note'              => 'AdminFundTransferToSuperadmin',
		// 	'status'            => 'Paid',
		// 	'currency'          => 'BDT'
		// ];
		// $transaction = Transaction::create($transactionSpendingData);

		// $revenueData = [
		// 	'order_id'          => $transaction->order_id,
		// 	'revenue'           => $transaction->amount,
		// 	'currency'          => 'BDT'
		// ];
		// Revenue::create($revenueData);
		// $admin->balance = 0;
		// $admin->save();
		return view('about-us');
	}
}
