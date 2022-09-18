<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\MemberRegistartion;
use App\Models\Payment;
use App\Models\User;
use AfricasTalking\SDK\AfricasTalking;
use App\Mail\DemoMail;
use App\Models\County;
use App\Models\Constituency;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mail;


class MemberRegistartionForm extends Component
{

    use WithFileUploads;
    public $first_name;
    public $second_name;
    public $maiden_name;
    public $email;    
    public $phone;    
    public $id_number;   

    public $service_number;
    public $spouse_name;  
        
    public $spouse_maiden_name;
    public $class;
    public $id_card;
    public $passport_photo;
    public $marriage_cert;

    public $totalSteps = 3;
    public $currentStep = 1;

    public $selectedClass = null;
    public $selectedSection = null;
    public $sections = null;
    public $spouseStatus= null; 

    public function mount(){
        $this->currentStep =1;
    }

    public function render()
    {
        return view('livewire.member-registartion-form',[
            'county' => County::all(),
        ]);
    }


    public function updatedSelectedClass($class_id)
    {
        $this->sections = Constituency::where('county_id', $class_id)->get();
    }


    public function increaseStep(){
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if($this->currentStep > $this->totalSteps){
            $this->currentStep = $this->totalSteps;
        }
    }

    
    public function decreaseStep(){
        $this->resetErrorBag();
        $this->currentStep--;
        if($this->currentStep < 1){
            $this->currentStep =1;
        }
    }

  

    public function validateData(){
        if($this->currentStep == 1){
            $this->validate([
                'first_name'=>'required|string',
                'second_name'=>'required|string',
                'maiden_name'=>'required|string',
                'email'=>'required|email|unique:member_registartions',
                'id_number'=>'required|string|unique:member_registartions',
                'phone'=>'required|digits:10|unique:member_registartions',
                'selectedClass'=>'required|string',
                'selectedSection'=>'required|string',
            ]);
        } elseif($this->currentStep == 2){
            $this->validate([
                'spouse_name'=>'required|string',
                'spouse_maiden_name'=>'required|string',                
                'service_number'=>'required|string|unique:member_registartions',
                'spouseStatus'=>'required|string',//spousestatus              
                'class'=>'required|string',
            ]);

        } 
        // elseif($this->currentStep == 3){
        //     $this->validate([
        //         'id_card'=>'required',
        //         'passport_photo'=>'required',
        //         'marriage_cert'=>'required',
        //     ]);
        // }
    }

    public function sendEmail(){
        $mailData = [

            'title' => 'Mail from MWAK',
            'body' => 'This is for testing email using smtp.'
        ];
        Mail::send('email-temp',$mailData, function($message) use ($mailData){
            $message->to($mailData['recipient'])
            ->from($mailData['fromEmail'],$mailData['fromName'])
            ->subject($mailData['subject']);
         });

         
        
    }

    public function SendSMS($OTP, $first_name,$phone,$message){
                
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
            'from' =>$username
        ]);
        //print_r($result);
    }

    public function member_register(){
        $this->resetErrorBag();
        if($this->currentStep == 3){

        //    $this->validate([
        //         'id_card'=>'required|mimes:doc,docx,pdf,jpg,jpeg,png|max:1024',
        //         'passport_photo'=>'required|mimes:jpg,jpeg,png|max:1024',
        //         'marriage_cert'=>'required|mimes:doc,docx,pdf,jpg,jpeg,png|max:1024',
                
        //     ]);
        }
        $idcard = 'IDCard_'.time().$this->id_card->getClientOriginalName();
        $upload_id = $this->id_card->storeAs('member_id_docs', $idcard);

        $passport = 'PASSPORTPHOTO_'.time().$this->passport_photo->getClientOriginalName();
        $upload_passport = $this->passport_photo->storeAs('member_passport_docs', $passport);

        if($this->marriage_cert == null){
           // dd('null');
            $cert = 'No Cert';
        }else{
            
            $cert = 'CERT_'.time().$this->marriage_cert->getClientOriginalName();
            $upload_cert = $this->marriage_cert->storeAs('member_cert_docs', $cert);
        
        }


        if($upload_id){
            $values = array(
                "first_name"=>$this->first_name,
                "second_name"=>$this->second_name,
                "maiden_name"=>$this->maiden_name,
                "email"=>$this->email,        
                "phone"=>$this->phone,        
                "id_number"=>$this->id_number,
                "county"=>$this->selectedClass,
                "sub_county"=>$this->selectedSection,
                "service_number"=>$this->service_number,
                "spouse_name"=>$this->spouse_name,        
                "spouse_maiden_name"=>$this->spouse_maiden_name,
                "spouse_status"=>$this->spouseStatus,
                "class"=>$this->class,
                "id_card"=>$idcard,
                "passport_photo"=>$passport,
                "marriage_cert"=>$cert,
            );

            //dd($values);

 


            $OTP = random_int(111111, 999999);
            $user_val = array(
                "name"=>$this->first_name,
                "email"=>$this->email,
                "photo"=>$idcard,
                "role"=>"Member",
                "password"=>Hash::make($OTP),//$OTP
            );
          
            MemberRegistartion::insert($values);
            User::insert($user_val);
            $date = date('Y-m-d H:i:s');
            $newDateFormate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y');
            //insert into payment
            $pay_var = array(
                "payment_description"=>"MWAK Membership Fees",    
                "phone"=>$this->phone,     
                "amount"=>"5000",        
                "tx_number"=>"Pending",
                "status"=>"Pending",  
                "date"=>$newDateFormate
            );
            Payment::insert($pay_var); 
            
            $message = 'Dear ' . $this->first_name . ' Welcome to MWAK. Registation pending wait approval, Please sign up with your email and make member payment. Your password is ' . $OTP;

            $this->sendSMS($OTP,$this->first_name,$this->phone,$message);
            //$this->sendEmail(); 
            $mailData = [
                'recipient'=>$this->email,
                'fromEmail'=>'info@mwak.co.ke',
                'fromName'=>'MWAK',
                'title' => 'Mail from MWAK',
                'body' => $message
            ];
            Mail::send('email-template',$mailData, function($message) use ($mailData){
                $message->to($mailData['recipient'])
                ->from($mailData['fromEmail'],$mailData['fromName'])
                ->subject($mailData['title']);
             });  

            $this->reset();
            //
            $this->currentStep = 1;
        }
        
    }

}
