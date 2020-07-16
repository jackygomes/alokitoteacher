<?php

namespace App\Http\Controllers;

use App\Course;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * certificate purchase page with already enrolled course entry to order table
     * @param $courseId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|void
     */
    public function certificate($courseId) {
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();
        if(isset($user_info) && $user_info->identifier != 1){

            return abort(404);
        }
        try{
            $course = Course::find($courseId);
            $courseItem = Order::where('user_id', $userId)->where('course_toolkit_id', $courseId)->first();
            if(!$courseItem) {
                $orderData = [
                    'user_id'           => Auth::id(),
                    'course_or_toolkit' => 'course',
                    'course_toolkit_id' => $course->id,
                    'amount'            => $course->price,
                    'status'            => 'paid',
                    'transaction_id'    => "ALOKITO_" . uniqid(),
                    'currency'          => 'BDT'
                ];
                $courseItem = Order::create($orderData);
            }
        }catch(\Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 420);
        }

        return view('certificate.certificate', compact('courseId', 'course', 'courseItem', 'user_info'));
    }

    /**
     * certificate purchase function
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function certificatePurchase(Request $request) {
        $this->validate($request, [
            'order_id'          => 'required',
            'certificate_price'   => 'required',
        ]);
        $user = User::find(Auth::id());
        try {
            if($user->balance >= $request->certificate_price){
                $orderItem = Order::find($request->order_id);

                $orderItem->certificate = 1;
                $orderItem->amount += $request->certificate_price;
                $orderItem->save();

                $user->balance -= $request->certificate_price;
                $user->save();

                return redirect()->back()->with('success', 'Purchase Successful');
            }else {
                return redirect()->back()->with('error', 'Insufficient Balance');
            }
        }catch(\Exception $e) {
            return "Quiz insertion error: " . $e->getMessage();
        }

//        return $request->all();
    }
}
