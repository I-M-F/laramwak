<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use AfricasTalking\SDK\AfricasTalking;


use Mail;

class MPESAController extends Controller
{
    public function payment()  {

        $response = $this->getAccessToken();
    
        $all = DB::table('users')->get();
        $member = DB::table('member_registartions')->get();
        $this->middleware('auth');
        //{{auth()->user()->role}} 
        $user = Auth::user()->role;
        //$phone = Auth::user()->email;
        
        if ($user == 'Admin') {
            # code...
            $paymentDB = DB::table('payments')->get();
        } else {
            # code...
            $phone = DB::table('member_registartions')->where('email','=',Auth::user()->email)->value('phone');
            $paymentDB = DB::table('payments')
            ->where('phone','=',$phone)
            ->get();
        }       
  
        return view('backend.user.payments', compact('all','response','member','paymentDB'));

        //dd($user);
    }

    public function getAccessToken(){
        
        $url = env('MPESA_ENV') == 0
        ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
        : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init($url);
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => env('MPESA_CONSUMER_KEY') . ':' . env('MPESA_CONSUMER_SECRET')
            )
        );
        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        return $response;
    }

    
    
    public function sndSMS($OTP){
                
        $username = 'MWAK'; // use 'sandbox' for development in the test environment
        $apiKey   = 'e5ea09562f3ad404503a38c8e3f3ef3cdaf3efa89193b27268b954a3f6bf7694'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);

        // // Get one of the services
         $sms      = $AT->sms();
         //$from = 'MWAK';

        // // Use the service
        $result   = $sms->send([
            'to'      => '+254720478650',
            'message' => $OTP,
            'from'    => $username 
        ]);

        dd($result);
    }

    public function sendSMS(){
        $OTP = random_int(111111, 999999);
        $this->sndSMS($OTP);
    }

    public function sendEmail(){
        
    }


    /**
     * Lipa na M-PESA password
     * */
    public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $passkey = "aEEDWsULApPvkXGI4WOuWBUbjvnHDdRD";
        $BusinessShortCode = 174379;
        $timestamp =$lipa_time;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);
        return $lipa_na_mpesa_password;
    }

    public function customerMpesaSTKPush($phone)//$phone
    {


    $amount = '1'; //Amount to transact 
    $phonenumber = $phone; // Phone number paying
    
    $Account_no = 'MWAK'; // Enter account number optional
    $url = 'https://tinypesa.com/api/v1/express/initialize';
    $data = array(
        'amount' => $amount,
        'msisdn' => $phonenumber,
        'account_no'=>$Account_no
    );
    $headers = array(
        'Content-Type: application/x-www-form-urlencoded',
        'ApiKey: IxD3nsaSdDy' // Replace with your api key
     );
    $info = http_build_query($data);
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $info);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $resp = curl_exec($curl);
    $msg_resp = json_decode($resp);
    
    
    // if ($msg_resp ->success == 'true') {
    //     echo "WAIT FOR  STK POP UP🔥";
    //   } else {
    //     echo "Transaction Failed";
       
    //   }

      //dd($msg_resp);
    }

    public function editTx($phone)
    {
        //dd($phone);

        $edit = DB::table('payments')->where('phone',$phone)->first();
        //dd($edit);
        return view('backend.user.edit-tx', compact('edit'));
    }

    public function updateTx(Request $request,$phone)
    {
  
        $data = array();
        $data['tx_number'] = $request->tx_number;
        $data['payment_description'] = $request->payment_description;
        $data['status'] = $request->status;        
        //$data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $update = DB::table('payments')
        ->where('phone',$phone)
        ->update($data);
        if($update)
        {
            echo "Data Updated Succesfully";
        }
        else{
            Echo "Something wnet wrong";
        }
    }
    /**
     * Lipa na M-PESA STK Push method
     * */
    // public function customerMpesaSTKPush()
    // {
    //     $timestamp = Carbon::rawParse('now')->format('YmdHms');
    //     $passkey = env('MPESA_CONSUMER_KEY');
    //     $BusinessShortCode = 600123;        
    //     $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);

    //     $url = env('MPESA_ENV') == 0
    //     ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
    //     : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    //     $curl = curl_init();
    //     curl_setopt($curl, CURLOPT_URL, $url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->getAccessToken()));
    //     $curl_post_data = [
    //         //Fill in the request parameters with valid values
    //         'BusinessShortCode' => $BusinessShortCode,//600123
    //         'Password' => $lipa_na_mpesa_password,
    //         'Timestamp' => $timestamp,
    //         'TransactionType' => 'CustomerPayBillOnline',
    //         'Amount' => 1,
    //         'PartyA' => 254720478650, // replace this with your phone number
    //         'PartyB' => $BusinessShortCode,
    //         'PhoneNumber' => 254720478650, // replace this with your phone number
    //         'CallBackURL' => 'http://127.0.0.1:8000/payment',
    //         'AccountReference' => "Member Payment",
    //         'TransactionDesc' => "Testing STK push on sandbox"
    //     ];
    //     $data_string = json_encode($curl_post_data);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    //     $curl_response = curl_exec($curl);
    //     //return $curl_response;
    //     dd($curl_post_data);
    // }
}
