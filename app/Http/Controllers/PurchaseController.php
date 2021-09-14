<?php

namespace App\Http\Controllers;

use App\Course;
use App\Job;
use App\Order;
use App\Resource;
use App\Revenue;
use App\Toolkit;
use App\TrackHistory;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * course purchase function with courseId
     * @param $courseId
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|void
     */
    public function purchaseCourseToolkitResource(Request $request, $productId)
    {
        if($request->type == 'course') {
            $info = Course::find($productId);
        } elseif ($request->type == 'resource') {
            $info = Resource::find($productId);
        } elseif($request->type == 'toolkit'){
            $info = Toolkit::find($productId);
        }

        if ($info == null) {
            return abort(404);
        }
        try{
            $productExist = Order::where('product_id', $info->id)
                ->where('user_id', Auth::id())
                ->where('product_type', $request->type)
                ->first();
            if($productExist == null){
                $orderData = [
                    'user_id'           => Auth::id(),
                    'product_type'      => $request->type,
                    'product_id'        => $info->id,
                    'amount'            => $info->price,
                    'status'            => 'paid',
                    'transaction_id'    => "ALOKITO_" . uniqid(),
                    'currency'          => 'BDT'
                ];

                $order = Order::create($orderData);

                //method call for transaction;
                $this->transaction($order);

                $userId = Auth::id();
                $user_info = User::where('id', '=', $userId)->first();
                $user_info->balance = $user_info->balance - $info->price;
                $user_info->save();

                if($request->type == 'course') {
                    return redirect()->back()->with('success','Your purchase to this course is successful');
                } elseif ($request->type == 'resource') {
                    return redirect()->back()->with('success','Your purchase to this resource is successful');
                } elseif($request->type == 'toolkit'){
                    return redirect()->back()->with('success','Your purchase to this toolkit is successful');
                }
            }
        } catch(\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function transaction($order) {
        try{


            // Spending entry
            $transactionSpendingData = [
                'user_id'           => Auth::id(),
                'order_id'          => $order->id,
                'transaction_type'  => 'Spending',
                'amount'            => $order->amount,
                'note'              => $order->product_type,
                'status'            => 'Paid',
                'currency'          => 'BDT'
            ];
            Transaction::create($transactionSpendingData);

            if($order->product_type == 'course')        $product = Course::find($order->product_id);
            elseif($order->product_type == 'toolkit')   $product = Toolkit::find($order->product_id);
            elseif($order->product_type == 'resource')  $product = Resource::find($order->product_id);
            elseif($order->product_type == 'Job')       $product = Job::find($order->product_id);

            $user = User::find($product->user_id);

            $earningAmount = 0;
            $earningUserId = $product->user_id;

            if($user->identifier != 101 && $user->identifier != 104)
            {
                if($order->product_type == 'Job'){
                    $earningAmount = $order->amount;

                    $admin = User::where('identifier',101)->first();
                    $earningUserId = $admin->id;
                } else {
                    $payCut = ($order->amount * 15)/100;
                    $earningAmount = $order->amount - $payCut;
                }
            } else {
                //if admin
                if($order->product_type == 'Job'){
                    //if admin and job
                    $earningAmount = 0;
                } else {
                    $earningAmount = $order->amount;
                }
            }


            // Earning entry
            $transactionEarningData = [
                'user_id'           => $earningUserId,
                'order_id'          => $order->id,
                'transaction_type'  => 'Earning',
                'amount'            => $earningAmount,
                'note'              => $order->product_type,
                'status'            => 'Paid',
                'currency'          => 'BDT'
            ];
            Transaction::create($transactionEarningData);

            // Revenue Entry
            if($user->identifier != 101 && $user->identifier != 104){
                if($order->product_type != 'Job'){
                    $revenueAmount = $payCut;

                    //user balance update
                    $admin = User::where('identifier',101)->first();
                    $admin->balance += floatval($earningAmount);
                    $admin->save();
                } else $revenueAmount = $order->amount;
            }else {
                $revenueAmount = $order->amount;

                //admin balance update
                $user->balance += floatval($revenueAmount);
                $user->save();
            }
            $revenueData = [
                'order_id'          => $order->id,
                'revenue'           => $revenueAmount,
                'currency'          => 'BDT'
            ];
            Revenue::create($revenueData);


        }catch(\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }
    }
}
