<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all = DB::table('users')->get();
        // Aproved payments, Pending Pay, New member, Total reve
               
        if (Auth::user()->role == 'Admin') {
        $approved_members = DB::table('member_registartions')                            
                            ->where('status','=','Approved')
                            ->count();
        $new_member = DB::table('member_registartions')                            
                        ->where('status','=','Pending')
                        ->count();
        
        $approved_payments = DB::table('payments')                            
                            ->where('status','=','Paid')
                            ->count();
        $pending_payments = DB::table('payments')                            
                            ->where('status','=','Pending')
                            ->count();
        
        $total_rev = DB::table('payments')->where('payment_description','=','MWAK Membership Fees')->sum('amount');

        $total_card_rev = DB::table('payments')->where('payment_description','=','Membership Card Fees')->sum('amount');
        
        
        return view('backend.layouts.dashboard', compact('total_rev','pending_payments','approved_payments','new_member','approved_members'));
        } else {
        
         return view('backend.layouts.member-dashboard');

        }
    }
}
