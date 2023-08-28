<?php

namespace App\Http\Controllers\backend;

use App\Models\MemberRegistartion;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports;


use AfricasTalking\SDK\AfricasTalking;
use App\Imports\CountyImport;

use Smalot\PdfParser\Parser;

use Mail;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AllUser()
    {

        $all = DB::table('users')->get();

        //dd($all);
        return view('backend.user.all-user', compact('all'));
    }

    public function AllMembers()
    {
        $all_members = DB::table('member_registartions')
        ->join('users', 'member_registartions.email', '=', 'users.email')
        ->get();

        $get_county = [];
        foreach ($all_members as $member) {
            $countyDB = DB::table('counties')
            ->where('id', '=', $member->county)
                ->first();
            $subCountyDB = DB::table('constituencies')
            ->where('county_id', '=', $member->sub_county)
                ->first();

            $get_county[$member->id] = ['county' => $countyDB, 'sub_county' => $subCountyDB];
        }

        //dd($all_members);
        return view('backend.user.all-members', compact('all_members', 'get_county'));
    }

    // AddUser
    // InsertUser
    public function AddUserIndex()
    {
        return view('backend.user.add-user');
    }

    public function InsertUser(Request $request)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role'] = $request->role;
        $data['password'] = Hash::make($request->password);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $insert = DB::table('users')->insert($data);


        if($insert)
        {          
            $notification = array(
                'messege'=>'Succesfull User Updated',
                'alert-type'=>'success'
            );
            return redirect()->route('payment')->with($notification);
        }
        else{
            $notification = array(
                'messege'=>'Something is Wrong, please try User update again!',
                'alert-type'=>'error'
            );
            return redirect()->route('payment')->with($notification);
        }
    }

    public function addAllMembers(){
        return view('backend.user.add-all');
    }

    public function insertAllMembers(Request $request){
        // Check if a file was uploaded
        if (!$request->hasFile('fileDocs')) {
            return redirect()->back()->withErrors(['message' => 'No file was uploaded.']);
        }

        $file = $request->file('fileDocs');

        //

        //$data = Excel::load($file)->get();
        $data = Excel::toArray([], $file);
        //  0 => "S/NO"
        //   1 => "NAME (S)"
        //   2 => "phone"
        //   3 => "ID NUMBER"
        //   4 => "EMAIL"
        //   5 => "COUNTY OF RESIDENCE"
        //   6 => "SUB COUNTY"
        //   7 => "PROFESSIONAL/OCCUPATION/SKILLS"
        //   8 => "INREST IN "
        //   9 => "NAME OF SPOUSE"
        //   10 => "SPOUSE SVC NO"
        //   11 => "RANK"
        //   12 => "STATUS"
        //   13 => "DATE REGISTERED"
        //   14 => null
        //   15 => "REGISTERED"
        if (count($data) > 0) {
            $values = [];

            $passport  = 'update';
            $idcard = 'update';
            foreach ($data[0] as $key => $value) {
                if ($key == 0) {
                    continue; // Skip header row
                }
                $values[] = [
                    'first_name' => $value[1],
                    'second_name' => $value[2],
                    'maiden_name' => $value[3],
                    'phone' => $value[4],
                    'id_number' => $value[5],
                    'email' => $value[6],
                    'county' => $value[7],
                    'sub_county' => $value[8],
                    'skills' => $value[9],
                    'pillar' => $value[10],
                    'spouse_name' => $value[11],
                    'spouse_maiden_name' => $value[12],
                    'service_number' => $value[13],
                    'class' => $value[14],
                    'spouse_status' => $value[15],
                    'id_card'=> $idcard,
                    'passport_photo'=> $passport

             
                   
                ];
            }

            if (count($values) > 0) {
             
                

                $OTP = random_int(111111, 999999);
                $user_val = array(
                    "name" => $value[1],
                    "email" => $value[6],                    
                    "role" => "Unverified",
                    "password" => Hash::make($OTP), //$OTP
                );
                
                $insert = MemberRegistartion::insert($values);
        
                User::insert($user_val);

                $date = date('Y-m-d H:i:s');
                $newDateFormate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y');
                //insert into payment
                if ($value[14] == 'General' || $value[14] == 'Lieutenant General' || $value[14] == 'Major General' || $value[14] == 'Brigadier' || $value[14] == 'Colonel' || $value[14] == 'Lieutenant Colonel' || $value[14] == 'Major' || $value[14] == 'Captain' || $value[14] == 'Lieutenant' || $value[14] == 'Second Lieutenant') {
                    //dd($this->class . ' xxx');
                    $member_fee = 5000;
                    $annual_fee = 3000;
                } else {
                    //dd($this->class.' xx');
                    $member_fee = 2000;
                    $annual_fee = 1000;
                }

                $pay_var = array(
                    "payment_description" => "MWAK Membership Fees",
                    "phone" => $value[4],
                    "amount" => $member_fee,
                    "tx_number" => "Pending",
                    "status" => "Pending",
                    "date" => $newDateFormate
                );
                Payment::insert($pay_var);

                $pay2_var = array(
                    "payment_description" => "MWAK Annual Subscription Fees",
                    "phone" => $value[4],
                    "amount" => $annual_fee,
                    "tx_number" => "Pending",
                    "status" => "Pending",
                    "date" => $newDateFormate
                );
                Payment::insert($pay2_var);
                $message = 'Dear ' . $value[1] . ' Welcome to MWAK. Your registation is received pending verification. Please sign in after verification with your email to add your passport photo and ID copy. Your one time password is ' . $OTP;

                $this->sendSMS($OTP, $value[1], $value[4], $message);
                //$this->sendEmail(); 
                $mailData = [
                    'recipient' => $value[6],
                    'fromEmail' => 'info@mwak.co.ke',
                    'fromName' => 'MWAK',
                    'title' => 'Mail from MWAK',
                    'body' => $message
                ];
                Mail::send('email-template', $mailData, function ($message) use ($mailData) {
                    $message->to($mailData['recipient'])
                    ->from($mailData['fromEmail'], $mailData['fromName'])
                    ->subject($mailData['title']);
                });

                //$this->reset();



                return redirect('/add-all');

                if ($insert) {
                    $notification = array(
                        'messege' => 'Succesfull Document Updated',
                        'alert-type' => 'success'
                    );
                    return redirect('/add-all')->with($notification);
                } else {
                    $notification = array(
                        'messege' => 'Something is Wrong, please try Document update again!',
                        'alert-type' => 'error'
                    );
                    return redirect('/add-all')->with($notification);
                }

            }
        }
    }

    public function SendSMS($OTP, $first_name, $phone, $message)
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
        //print_r($result);
    }

    public function EditUser($id)
    {
        $edit = DB::table('users')->where('id', $id)->first();
        return view('backend.user.edit-user', compact('edit'));
    }

    public function viewMember($id)
    {
        // $edit = DB::table('users')->where('id',$id)->first();
        // return view('backend.user.view-member', compact('edit'));

        $view_member = DB::table('member_registartions')->where('id', $id)->first();
        //dd($view_member);
        $countyDB = DB::table('counties')
        ->where('id', '=', $view_member->county)
        ->first();
        $subCountyDB = DB::table('constituencies')
        ->where('county_id', '=', $view_member->sub_county)
        ->first();
        $status_role = DB::table('users')
            ->where('email', '=', $view_member->email)
            ->first();
        $paymentDB = DB::table('payments')
            ->where('phone', '=', $view_member->phone)
            ->first();
        $photo_str = substr($view_member->passport_photo, 6);
        $id_photo_str = substr($view_member->id_card, 6);
        return view('backend.user.view-member', compact('view_member', 'status_role','photo_str','id_photo_str','paymentDB','countyDB','subCountyDB'));
    }//http://www.mwakportal.mwak.co.ke/

    public function updateMember(Request $request, $id)
    {
        $date = date('m-Y');
        //
        $dateMWAK = date('Y-m-d H:i:s');
        $values = array(
            "member_id" => $request->id,            
            "date" => $dateMWAK
        );        

        $mwak_id = DB::table('mwak_regs')->insertGetId($values);

        

        $mwak_no = 'MWAK-'.$date.'-'. $mwak_id;
      
        $data = array();
        $data['member_location'] = $request->chapter;
        $data['member_no'] = $mwak_no;
        $data['status'] = "Active";
        $data['updated_at'] = date('Y-m-d H:i:s');

        //dd($data);
        $update = DB::table('member_registartions')
            ->where('id', $id)
            ->update($data);
        if ($update) {
           // echo "Data Updated Succesfully";
            $view_member = DB::table('member_registartions')->where('id', $id)->first();
            // Set your app credentials
            $username = 'MWAK'; // use 'sandbox' for development in the test environment
            $apiKey   = 'e5ea09562f3ad404503a38c8e3f3ef3cdaf3efa89193b27268b954a3f6bf7694'; // use your sandbox app API key for development in the test environment
            $AT       = new AfricasTalking($username, $apiKey);

            // // Get one of the services
            $sms      = $AT->sms();
            $output = preg_replace("/^0/", "+254", $view_member->phone);
            // // Use the service
            $result   = $sms->send([
                'to'      => $output,
                'message' => 'Dear ' . $view_member->first_name.' '.$view_member->maiden_name. ' Welcome to MWAK. You have been assigned '.$view_member->member_no.' You will be notified when to visit your chapter to collect your MWAK ID Card. Your Membership No. is ' . $mwak_no.' Thank you for being a member and supporting MWAK pillars.',
                'from' => $username
            ]);
            $paymentDB = DB::table('payments')
                ->where('phone', '=', $view_member->phone)
                ->first();

            $countyDB = DB::table('counties')
            ->where('id', '=', $view_member->county)
            ->first();

       
            $notification = array(
                'messege'=>'Succesfull Activated Updated',
                'alert-type'=>'success'
            );    
            return redirect()->route('allmembers')->with($notification);
            //return view('backend.user.view-member', compact('view_member', 'paymentDB','countyDB'))->with($notification);
        } else {
            $notification = array(
                'messege'=>'Something is Wrong, please try Activate again!',
                'alert-type'=>'error'
            );
            return redirect()->route('allmembers')->with($notification);
            //return view('backend.user.view-member', compact('view_member', 'paymentDB','countyDB'))->with($notification);
        }
    }

    public function approveMember(Request $request, $email)
    {
        $view_member = DB::table('member_registartions')->where('email', $email)->first();
        if($request->status_role == 'Verified'){
            $data['role'] = "Member";
            $msg = 'Dear ' . $view_member->first_name . ' ' . $view_member->maiden_name . ' Welcome to MWAK. You have been succesfully verified. Log in and proceed to make payments and upload photos. Thank you for being a member and supporting MWAK pillars.';
        }else{
            $data['role'] = "Rejected";
            $msg = 'Dear ' . $view_member->first_name . ' ' . $view_member->maiden_name . 'Kindly contact MWAK regarding your Member Verification. phone: +254718111186 email: info@mwak.ke';
        }
        
        $data['updated_at'] = date('Y-m-d H:i:s');

        $update = DB::table('users')
        ->where('email', $email)
            ->update($data);
        if ($update) {
            
            $username = 'MWAK'; // use 'sandbox' for development in the test environment
            $apiKey   = 'e5ea09562f3ad404503a38c8e3f3ef3cdaf3efa89193b27268b954a3f6bf7694'; // use your sandbox app API key for development in the test environment
            $AT       = new AfricasTalking($username, $apiKey);

            // // Get one of the services
            $sms      = $AT->sms();
            $output = preg_replace("/^0/", "+254", $view_member->phone);
            // // Use the service
            $result   = $sms->send([
                'to'      => $output,
                'message' => $msg,
                'from' => $username
            ]);
            $paymentDB = DB::table('payments')
                ->where('phone', '=', $view_member->phone)
                ->first();

            $countyDB = DB::table('counties')
                ->where('id', '=', $view_member->county)
                ->first();


            $notification = array(
                'messege' => 'Succesfull Activated Updated',
                'alert-type' => 'success'
            );
            return redirect()->route('allmembers')->with($notification);
            //return view('backend.user.view-member', compact('view_member', 'paymentDB','countyDB'))->with($notification);
        } else {
            $notification = array(
                'messege' => 'Something is Wrong, please try Activate again!',
                'alert-type' => 'error'
            );
            return redirect()->route('allmembers')->with($notification);
            //return view('backend.user.view-member', compact('view_member', 'paymentDB','countyDB'))->with($notification);
        }
    }

    public function updateMemberDets(Request $request, $id)
    {
        $view_member = DB::table('member_registartions')->where('id', $id)->first();
        $newFile = $request->file('id_card');
        if($newFile == null)
        {
            $idcard = $view_member->id_card;
        }else{
            $idcard = $newFile->store('public/member_id_docs');
        }
        

        $passportFile = $request->file('passport');

        if($passportFile == null)
        {
            $passport = $view_member->passport_photo;
        }else{
            $passport = $passportFile->store('public/member_passport_docs');
        }
        
       
        $data = array();
        $data['member_location'] = $request->chapter;
        $data['first_name']=$request->f_name;
        $data['second_name']=$request->m_name;
        $data['maiden_name']=$request->l_name;
        $data['member_location']=$request->chapter;
        $data['id_number']=$request->id_no;
        $data['email']=$request->email;
        $data['spouse_name']=$request->sp_f_name;
        $data['spouse_maiden_name']=$request->sp_l_name;
        $data['spouse_status']=$request->sp_status;
        $data['class']=$request->sp_class;
        $data['id_card']=$idcard;
        $data['passport_photo']=$passport;

       // dd($data);

        $update = DB::table('member_registartions')
            ->where('id', $id)
            ->update($data);
        if ($update) {
           // echo "Data Updated Succesfully";
       

       
            $notification = array(
                'messege'=>'Succesfull Deleted',
                'alert-type'=>'success'
            );    
            return redirect()->route('allmembers')->with($notification);
            //return view('backend.user.view-member', compact('view_member', 'paymentDB','countyDB'))->with($notification);
        } else {
            $notification = array(
                'messege'=>'Something is Wrong, please try Update again!',
                'alert-type'=>'error'
            );
            return redirect()->route('allmembers')->with($notification);
            //return view('backend.user.view-member', compact('view_member', 'paymentDB','countyDB'))->with($notification);
        }
    }

    public function userUpdateMemberDets(Request $request, $id)
    {
        $view_member = DB::table('member_registartions')->where('id', $id)->first();
        $newFile = $request->file('id_card');
        if ($newFile == null) {
            $idcard = $view_member->id_card;
        } else {
            $idcard = $newFile->store('public/member_id_docs');
        }


        $passportFile = $request->file('passport');

        if ($passportFile == null) {
            $passport = $view_member->passport_photo;
        } else {
            $passport = $passportFile->store('public/member_passport_docs');
        }


        $userData = array();
        $userData['password'] =  Hash::make($request->password);
        $userData['updated_at'] = date('Y-m-d H:i:s');

        $updateUser = DB::table('users')
            ->where('email', $view_member->email)
            ->update($userData);

        $data = array();
        $data['id_card'] = $idcard;
        $data['passport_photo'] = $passport;



        // dd($data);

        $update = DB::table('member_registartions')
        ->where('id', $id)
            ->update($data);
        if ($update) {
            // echo "Data Updated Succesfully";



            $notification = array(
                'messege' => 'Succesfull Deleted',
                'alert-type' => 'success'
            );
            return redirect()->route('allmembers')->with($notification);
            //return view('backend.user.view-member', compact('view_member', 'paymentDB','countyDB'))->with($notification);
        } else {
            $notification = array(
                'messege' => 'Something is Wrong, please try Update again!',
                'alert-type' => 'error'
            );
            return redirect()->route('allmembers')->with($notification);
            //return view('backend.user.view-member', compact('view_member', 'paymentDB','countyDB'))->with($notification);
        }
    }

    public function genMwak(){

    }




    public function UpdateUser(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role'] = $request->role;
        
        $data['password'] = Hash::make($request->password);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $update = DB::table('users')
            ->where('id', $id)
            ->update($data);
        if ($update) {
            echo "Data Updated Succesfully";
        } else {
            echo "Something wnet wrong";
        }
    }

    public function DeleteUser($email)
    {
        # code...
        $deleteUser = DB::table('users')
            ->where('email', $email)
            ->delete();

        $delete = DB::table('member_registartions')
        ->where('email', $email)
        ->delete();



        if ($delete) {
            echo "Data Removed Succesfully";
            $notification = array(
                'messege' => 'Succesfull Updated',
                'alert-type' => 'success'
            );
            return redirect()->route('allmembers')->with($notification);
        } else {
            echo "Something whet wrong";
            $notification = array(
                'messege' => 'Something is Wrong, please try Update again!',
                'alert-type' => 'error'
            );
            return redirect()->route('allmembers')->with($notification);
        }
    }

        /**
     * Import Users 
     * @param Null
     * @return View File
     */
     public function importUsers()
     {
        echo "Something wnet wrong";
    }

    public function uploadUsers(Request $request)
    {
        //Excel::import(new CountyImport, $request->file);

        //dd('Data Imported Successfully');
        
        //return redirect()->route('users.index')->with('success', );
    }

   
}
