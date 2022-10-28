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
        $allDocs = DB::table('mwakfiles')->get();
        
        $total_rev = DB::table('payments')->where('payment_description','=','MWAK Membership Fees')->sum('amount');

        $total_card_rev = DB::table('payments')->where('payment_description','=','Membership Card Fees')->sum('amount');
        
        
        return view('backend.layouts.dashboard', compact('total_rev','allDocs','pending_payments','approved_payments','new_member','approved_members'));
        } else {
        $all = DB::table('mwakfiles')->get();
        
        $status_role = DB::table('users')->first();

        if($status_role->role == 'Unverified' ){
            return view('backend.user.unverified',compact('status_role'));
        } elseif($status_role->role == 'Rejected') {
            return view('backend.user.rejected',compact('status_role'));
        }
         return view('backend.user.all-docs',compact('all')); 
         //check if verified status 
         //return redirect()->route('backend.user.all-docs');
         //return redirect('all-docs');

        }
    }
}
