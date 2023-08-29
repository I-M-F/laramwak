<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;

//use Abraham\TwitterOAuth\TwitterOAuth;
//use Thujohn\Twitter\Twitter;

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
                ->where('status', '=', 'Approved')
                ->count();
            $new_member = DB::table('member_registartions')
                ->where('status', '=', 'Pending')
                ->count();

            $approved_payments = DB::table('payments')
                ->where('status', '=', 'Paid')
                ->count();
            $pending_payments = DB::table('payments')
                ->where('status', '=', 'Pending')
                ->count();
            $allDocs = DB::table('mwakfiles')->get();

            $total_rev = DB::table('payments')->where('payment_description', '=', 'MWAK Membership Fees')->sum('amount');

            $total_card_rev = DB::table('payments')->where('payment_description', '=', 'Membership Card Fees')->sum('amount');

            //twitter 


            // $tweets = Twitter::getUserTimeline([
            //     'screen_name' => 'kdfinfo',
            //     'count' => 10,
            //     'format' => 'array'
            // ]);

            // Create an instance of the Twitter class
            //$twitter = new Twitter();

            //dd($twitter);
            // Call the getUserTimeline() method on the $twitter instance
            //$tweets = $twitter->getUserTimeline(['screen_name' => '@kdfinfo', 'count' => 3]);
            //dd($tweets);

            // Loop through the tweets and display each one
            // foreach ($tweets as $tweet) {
            //     print_r($tweet->text . '<br>') ;
            // }


            return view('backend.layouts.dashboard', compact( 'total_rev', 'allDocs', 'pending_payments', 'approved_payments', 'new_member', 'approved_members'));
        } else {
            $all = DB::table('mwakfiles')->get();

            $status_role = DB::table('users')->first();

            $email = Auth::user()->email;

            // $all_members = DB::table('member_registartions')
            // ->join('users', 'member_registartions.email', '=', 'users.email')
            // ->get();

            $member_dets = DB::table('member_registartions')
            ->join('users', 'member_registartions.email', '=', 'users.email')
            ->where('member_registartions.email', $email)
            ->first();

           // dd($member_dets);

            if ($member_dets->role == 'Unverified') {
                return view('backend.user.unverified', compact('status_role'));
            } elseif ($member_dets->role == 'Rejected') {
                return view('backend.user.rejected', compact('status_role'));
            }
            return view('backend.user.member-dashboard', compact('member_dets'));
            //check if verified status 
            //return redirect()->route('backend.user.all-docs');
            //return redirect('all-docs');

        }
    }
}
