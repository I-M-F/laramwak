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
    public function payment()
    {

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

            $phone = DB::table('member_registartions')->where('email', '=', Auth::user()->email)->value('phone');
            $paymentDB = DB::table('payments')
                ->where('id', '=', $phone)
                ->get();
        }

        return view('backend.user.payments', compact('all', 'response', 'member', 'paymentDB'));

        //dd($user);
    }

    public function pendingPay()
    {
        //haven't paid, Name, phone, spouse name, spouse rank, amount to pay
        $response = $this->getAccessToken();

        $all = DB::table('users')->get();
        $member = DB::table('member_registartions')->get();
        $this->middleware('auth');
        //{{auth()->user()->role}} 
        $user = Auth::user()->role;
        //$phone = Auth::user()->email;

        if ($user == 'Admin') {
           

            $paymentDB = DB::table('payments')
            ->join('member_registartions', 'payments.phone', '=', 'member_registartions.phone')
            ->get();


            //printf($paymentDB);
            

        } else {
            # code...
            $phone = DB::table('member_registartions')->where('email', '=', Auth::user()->email)->value('phone');
            $paymentDB = DB::table('payments')
            ->where('id', '=', $phone)
                ->get();
        }

        return view('backend.user.pendingpay', compact('all', 'response', 'member', 'paymentDB'));

        //dd($user);
    }

    public function getAccessToken()
    {

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



    public function sndSMS($OTP)
    {

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

    public function sendSMS()
    {
        $OTP = random_int(111111, 999999);
        $this->sndSMS($OTP);
    }

    public function sendEmail()
    {
    }


    /**
     * Lipa na M-PESA password
     * */
    public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $passkey = "aEEDWsULApPvkXGI4WOuWBUbjvnHDdRD";
        $BusinessShortCode = 174379;
        $timestamp = $lipa_time;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode . $passkey . $timestamp);
        return $lipa_na_mpesa_password;
    }

    public function mwakSTKPush($phone)
    {
        //dd($phone);
        # access token
        $consumerKey = 'o1QYI6OQjLTNrvJbFYreRjacWHEh9fxe'; //Fill with your app Consumer Key
        $consumerSecret = 'xT2hd4Kirj5H0AY3'; // Fill with your app Secret

        # define the variales
        # provide the following details, this part is found on your test credentials on the developer account
        $BusinessShortCode = '7893469';
        $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';


        $paymentDB = DB::table('payments')
            ->where('phone', '=', $phone)
            ->first();



        $PartyA = preg_replace("/^0/", "254", $phone); // This is your phone number, 
        $AccountReference = 'MWAK';
        $TransactionDesc = $paymentDB->payment_description;
        $Amount = $paymentDB->amount;

        # Get the timestamp, format YYYYmmddhms -> 20181004151020
        $Timestamp = date('YmdHis');

        # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
        $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

        # header for access token
        $headers = ['Content-Type:application/json; charset=utf8'];

        # M-PESA endpoint urls
        $access_token_url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $initiate_url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        # callback url
        $CallBackURL = 'https://morning-basin-87523.herokuapp.com/callback_url.php';

        $curl = curl_init($access_token_url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo(
            $curl,
            CURLINFO_HTTP_CODE
        );
        $result = json_decode($result);
        $access_token = $result->access_token;
        curl_close($curl);

        # header for stk push
        $stkheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

        # initiating the transaction
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $initiate_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => $PartyA,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc
        );

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        // print_r($curl_response);

        // echo $curl_response;


        return $this->payment($curl_response);
    }




    // public function mpesaSTKPush($phone){

    //         $simu = preg_replace("/^0/", "254", $phone);

    //         $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
    //         $lipa_time = Carbon::rawParse('now')->format('YmdHms');
    //         $data = array(
    //             'BusinessShortCode'=> 174379,
    //             'Password'=> "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjIwOTEyMDkxNTI5",
    //             'Timestamp'=> $lipa_time,
    //             'TransactionType'=> "CustomerPayBillOnline",
    //             'Amount'=> 1,
    //             'PartyA'=> $simu,
    //             'PartyB'=> 174379,
    //             'PhoneNumber'=> $simu,
    //             'CallBackURL'=> "http://app.mwak.ke/payment",
    //             'AccountReference'=> "MWAK",
    //             'TransactionDesc'=> "Payment of MWAK" 
    //         );
    //         $info = http_build_query($data);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //             'Authorization: Bearer KY9flPHOOYU8EkqaGnXCJ1sw7S2z',
    //             'Content-Type: application/json'
    //         ]);
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //         $response     = curl_exec($ch);
    //         curl_close($ch);
    //         echo $response .'----'.$info ;

    // }

    public function customerMpesaSTKPush($phone) //$phone
    {


        $amount = '1'; //Amount to transact 
        $phonenumber = $phone; // Phone number paying

        $Account_no = 'MWAK'; // Enter account number optional
        $url = 'https://tinypesa.com/api/v1/express/initialize';
        $data = array(
            'amount' => $amount,
            'msisdn' => $phonenumber,
            'account_no' => $Account_no
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


        if ($msg_resp->success == 'true') {
            echo "WAIT FOR  STK POP UP🔥";
        } else {
            echo "Transaction Failed";
        }

        //dd($msg_resp);
    }

    public function editTx($id)
    {
        //dd($phone);

        $edit = DB::table('payments')->where('id', $id)->first();
        //dd($edit);
        return view('backend.user.edit-tx', compact('edit'));
    }

    public function tumaSMS($id)
    {
        //dd($phone);

        $tuma = DB::table('payments')->where('id', $id)->first();
        $member = DB::table('member_registartions')->where('phone', $tuma->phone)->first();
        //dd($member);
        return view('backend.user.tuma-sms', compact('tuma', 'member'));
    }

    public function pendingNotify(){
        $paymentDB = DB::table('payments')->where('status','Pending')->get();

        

        foreach ($paymentDB as $user) {

            

            $member = DB::table('member_registartions')->where('phone', $user->phone)->first();

            //dd($member);
            // if (is_null($member)) {
            //     # code...
            //     dd($user->phone);
            // }
            
            //printf($member->first_name);
           // $member = DB::table('member_registartions')->where('phone', $tuma->phone)->first();

            $message = 'Dear ' . $member->first_name . ', MWAK would like to remind you that Kes ' . $user->amount . '/=  for  ' . $user->payment_description . ' is due. Make Payment to Mpesa details below. KCB Paybill number 7893469 account name - Your First Name/Spouse Name. If paid kindly ignore this SMS.';
            //dd($message);

            $this->SendNotifySMS($user->phone, $message);


            //printf($message.'\n');

            $notification = array(
                'messege' => 'Succesfully Notified User',
                'alert-type' => 'success'
            );
            return redirect()->route('payment')->with($notification);


        }

        //dd($paymentDB);


    }

    public function payNotify($id)
    {
        $tuma = DB::table('payments')->where('id', $id)->first();
        $member = DB::table('member_registartions')->where('phone', $tuma->phone)->first();

        $message = 'Dear ' . $member->first_name . ', MWAK would like to remind you that Kes ' . $tuma->amount . '/=  for  ' . $tuma->payment_description . ' is due. Make Payment to Mpesa details below. KCB Paybill number 7893469 account name - Your First Name/Spouse Name. If paid kindly ignore this SMS.';
        //dd($message);

        $this->SendNotifySMS($tuma->phone, $message);


        $notification = array(
            'messege' => 'Succesfully Notified User',
            'alert-type' => 'success'
        );
        return redirect()->route('payment')->with($notification);
    }

    public function SendNotifySMS($phone, $message)
    {

        $username = 'MWAK'; // use 'sandbox' for development in the test environment
        $apiKey   = 'e5ea09562f3ad404503a38c8e3f3ef3cdaf3efa89193b27268b954a3f6bf7694'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);

        // // Get one of the services
        $sms      = $AT->sms();
        $output = preg_replace("/^0/", "+254", $phone);
        // // Use the service
        $result   = $sms->send([
            'to'      => $output,
            'message' => $message,
            'from' => $username
        ]);
        print_r($result);
    }
    public function updateTx(Request $request, $id)
    {

        $data = array();
        $data['tx_number'] = $request->tx_number;
        $data['payment_description'] = $request->payment_description;
        $data['status'] = $request->status;
        //$data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $update = DB::table('payments')
            ->where('id', $id)
            ->update($data);
        if ($update) {
            $notification = array(
                'messege' => 'Succesfull Transaction Updated',
                'alert-type' => 'success'
            );
            return redirect()->route('payment')->with($notification);
        } else {
            $notification = array(
                'messege' => 'Something is Wrong, please try transaction update again!',
                'alert-type' => 'error'
            );
            return redirect()->route('payment')->with($notification);
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
