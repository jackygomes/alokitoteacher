<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
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
        $userId = Auth::id();
        $user_info = User::where('id', '=', $userId)->first();

        return view('deposit.create', compact('user_info'));
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

    public function deposit(Request $request)
    {
        $this->validate($request, [
            'name'  =>  'required',
            'email'  =>  'required',
            'phone'  =>  'required',
            'amount'  =>  'required',
        ]);
        $data = [
            'request'   => $request,
            'userId'    => Auth::id(),
        ];
        $paymentData = $this->createPayment($data);
//        dd($paymentData);
//        return $paymentData;
        $this->makePayment($paymentData);
    }

    private function createPayment($paymentData)
    {

        $post_data = array();
        if(env('APP_ENV') == 'local') {
            $post_data['store_id'] = env('TEST_SSL_STORE_ID');
            $post_data['store_passwd'] = env('TEST_SSL_STORE_PASSWORD');
        } elseif(env('APP_ENV') == 'production') {
            $post_data['store_id'] = env('LIVE_SSL_STORE_ID');
            $post_data['store_passwd'] = env('LIVE_SSL_STORE_PASSWORD');
        }

        $post_data['total_amount'] = $paymentData['request']->amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = "ALOKITO_" . uniqid();
        $post_data['success_url'] = route('deposit.complete');
        $post_data['fail_url'] = route('deposit.complete');
        $post_data['cancel_url'] = route('deposit.complete');

        $post_data['emi_option'] = "0";

        $post_data['cus_name'] = $paymentData['request']->name;
        $post_data['cus_email'] = $paymentData['request']->email;
        $post_data['cus_add1'] = '3/11, Block B, Lalmatia';
        $post_data['cus_city'] = 'Dhaka';
        $post_data['cus_postcode'] = '1207';
        $post_data['cus_country'] = 'Bangladesh';
        $post_data['cus_phone'] = $paymentData['request']->phone;

        $post_data['shipping_method'] = "NO";
        $post_data['num_of_item'] = "1";

        $post_data['product_name'] = 'Deposit';
        $post_data['product_category'] = "Deposit";
        $post_data['product_profile'] = "general";

        return $post_data;
    }

    private function makePayment($paymentData) {

        # REQUEST SEND TO SSLCOMMERZ
        if(env('APP_ENV') == 'local') {
            $direct_api_url = env('TEST_SSL_TRANSACTION_API');
        } elseif(env('APP_ENV') == 'production') {
            $direct_api_url = env('LIVE_SSL_TRANSACTION_API');
        }

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url );
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1 );
        curl_setopt($handle, CURLOPT_POSTFIELDS, $paymentData);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


        $content = curl_exec($handle );

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if($code == 200 && !( curl_errno($handle))) {
            curl_close( $handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close( $handle);
            echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
            exit;
        }

        # PARSE THE JSON RESPONSE
        $sslcz = json_decode($sslcommerzResponse, true );

        if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {

            header("Location: ". $sslcz['GatewayPageURL']);
            exit;
        } else {
            echo "JSON Data parsing error!";
        }

    }

    public function paymentComplete(Request $request)
    {
//        return $request->all();
        try{
            $userId = Auth::id();
            $status = '';
            if($request->status == "VALID") {
                $status = 'success';
                $user = User::find($userId);
                $user->balance += floatval($request->amount);

                $user->save();

                return view('deposit.complete', compact('status'));
            } else{
                $status = 'failed';
                return view('deposit.complete', compact('status'));
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
