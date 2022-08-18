<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\MemberRegistartion;
use App\Models\User;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Hash;

class MemberRegistartionForm extends Component
{

    use WithFileUploads;
    public $first_name;
    public $second_name;
    public $maiden_name;
    public $email;    
    public $phone;    
    public $id_number;
    public $member_location;
    public $service_number;
    public $spouse_name;    
    public $spouse_maiden_name;
    public $class;
    public $id_card;
    public $passport_photo;
    public $marriage_cert;

    public $totalSteps = 3;
    public $currentStep = 1;

    public function mount(){
        $this->currentStep =1;
    }

    public function render()
    {
        return view('livewire.member-registartion-form');
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
                'phone'=>'required|digits:10|unique:member_registartions',
            ]);
        } elseif($this->currentStep == 2){
            $this->validate([
                'spouse_name'=>'required|string',
                'spouse_maiden_name'=>'required|string',
                'id_number'=>'required|string|unique:member_registartions',
                'service_number'=>'required|string|unique:member_registartions',
                'member_location'=>'required|string',
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

    public function SendSMS(){
                
        $username = 'mwak'; // use 'sandbox' for development in the test environment
        $apiKey   = 'bf4568279c3cd735799bac377c01cfc22b882f6c52be7d74a1610f78630c7486'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms      = $AT->sms();

        // Use the service
        $result   = $sms->send([
            'to'      => '+254720478650',
            'message' => 'Hello World!'
        ]);

        print_r($result);
    }

    public function member_register(){
        $this->resetErrorBag();
        if($this->currentStep == 3){
           $this->validate([
                'id_card'=>'required|mimes:doc,docx,pdf,jpg,jpeg,png|max:1024',
                'passport_photo'=>'required|mimes:pdf,jpg,jpeg,png|max:1024',
                'marriage_cert'=>'required|mimes:doc,docx,pdf,jpg,jpeg,png|max:1024',
                
            ]);
        }

        

        $idcard = 'IDCard_'.time().$this->id_card->getClientOriginalName();
        $upload_docs = $this->id_card->storeAs('member_id_docs', $idcard);

        $passport = 'PASSPORTPHOTO_'.time().$this->passport_photo->getClientOriginalName();
        $upload_passport = $this->passport_photo->storeAs('member_passport_docs', $passport);

        $cert = 'CERT_'.time().$this->marriage_cert->getClientOriginalName();
        $upload_cert = $this->marriage_cert->storeAs('member_cert_docs', $cert);


        if($upload_docs){
            $values = array(
                "first_name"=>$this->first_name,
                "second_name"=>$this->second_name,
                "maiden_name"=>$this->maiden_name,
                "email"=>$this->email,        
                "phone"=>$this->phone,        
                "id_number"=>$this->id_number,
                "member_location"=>$this->member_location,
                "service_number"=>$this->service_number,
                "spouse_name"=>$this->spouse_name,        
                "spouse_maiden_name"=>$this->spouse_maiden_name,
                "class"=>$this->class,
                "id_card"=>$idcard,
                "passport_photo"=>$passport,
                "marriage_cert"=>$cert,
            );

            $OTP = random_int(111111, 999999);
            $user_val = array(
                "name"=>$this->first_name,
                "email"=>$this->email,
                "role"=>"Member",
                "password"=>Hash::make("password"),//$OTP
            );
            //SendSMS($OTP);
            MemberRegistartion::insert($values);
            User::insert($user_val);
            $this->reset();
            //
            $this->currentStep = 1;
        }
        
    }

}
