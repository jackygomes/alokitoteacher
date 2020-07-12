<?php

namespace App\Http\Controllers;

use App\Course;
use App\Order;
use App\TrackHistory;
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

    public function course($courseId) {
        $info = Course::find($courseId);

        if ($info == null) {
            return abort(404);
        }
        try{
            $courseExist = Order::where('course_toolkit_id', $info->id)
                            ->where('user_id', Auth::id())->first();
            if($courseExist == null){
                $orderData = [
                    'user_id'           => Auth::id(),
                    'course_or_toolkit' => 'course',
                    'course_toolkit_id' => $info->id,
                    'amount'            => $info->price,
                    'status'            => 'paid',
                    'transaction_id'    => "ALOKITO_" . uniqid(),
                    'currency'          => 'BDT'
                ];

                Order::create($orderData);

                $userId = Auth::id();
//                return $userId;
                $user_info = User::where('id', '=', $userId)->first();
                $user_info->balance = $user_info->balance - $info->price;
                $user_info->save();

                // redirect to course enroll page

                return redirect()->back()->with('success','Your purchase to this course is successful');
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
}
