<?php

namespace App\Http\Controllers;

use App\Course;
use App\Order;
use App\Resource;
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

    /**
     * course purchase function with courseId
     * @param $courseId
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|void
     */
    public function course($courseId) {
        $info = Course::find($courseId);

        if ($info == null) {
            return abort(404);
        }
        try{
            $courseExist = Order::where('product_id', $info->id)
                ->where('user_id', Auth::id())
                ->where('product_type', 'course')
                ->first();
            if($courseExist == null){
                $orderData = [
                    'user_id'           => Auth::id(),
                    'product_type'      => 'course',
                    'product_id'        => $info->id,
                    'amount'            => $info->price,
                    'status'            => 'paid',
                    'transaction_id'    => "ALOKITO_" . uniqid(),
                    'currency'          => 'BDT'
                ];

                Order::create($orderData);

                $userId = Auth::id();
                $user_info = User::where('id', '=', $userId)->first();
                $user_info->balance = $user_info->balance - $info->price;
                $user_info->save();

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
     * resource purchase function with resourceId
     * @param $resourceId
     */
    public function resource($resourceId) {
        $resource = Resource::find($resourceId);

        if ($resource == null) {
            return abort(404);
        }
        try{

            $resourceExist = Order::where('product_id', $resource->id)
                ->where('user_id', Auth::id())
                ->where('product_type', 'resource')
                ->first();

            if($resourceExist == null){
                $orderData = [
                    'user_id'           => Auth::id(),
                    'product_type'      => 'resource',
                    'product_id'        => $resource->id,
                    'amount'            => $resource->price,
                    'status'            => 'paid',
                    'transaction_id'    => "ALOKITO_" . uniqid(),
                    'currency'          => 'BDT'
                ];

                Order::create($orderData);

                $userId = Auth::id();
                $user_info = User::where('id', '=', $userId)->first();
                $user_info->balance = $user_info->balance - $resource->price;
                $user_info->save();

                return redirect()->back()->with('success','Your purchase to this resource is successful');
            }

        } catch (\Exception $e){
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
