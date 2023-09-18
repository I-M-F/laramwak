<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

            $totalMembers = DB::table('member_registartions')
            ->count();

            // Get the current month and year using Carbon
            //$currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $currentMonth = date('m');

            // Build the query to count events within the current month and year
            $totalEvents = DB::table('events')
            ->whereYear('event_start', $currentMonth)
            ->whereMonth('event_start', $currentMonth)
            ->count();
dd($totalEvents);
            //$phone = DB::table('member_registartions')->where('email', '=', Auth::user()->email)->value('phone');
            $paymentDB = DB::table('payments')
                ->where('phone', '=', $member_dets->phone)
            ->count();

            $pendingPayments = DB::table('payments')
            ->where('phone', $member_dets->phone)
            ->where('status', 'pending')
            ->count();

           // dd($member_dets);

            if ($member_dets->role == 'Unverified') {
                return view('backend.user.unverified', compact('member_dets'));
            } elseif ($member_dets->role == 'Rejected') {
                return view('backend.user.rejected', compact('member_dets'));
            } 
            return view('backend.user.all-docs', compact('member_dets', 'totalMembers', 'totalEvents', 'paymentDB', 'pendingPayments'));
            //check if verified status 
            //return redirect()->route('backend.user.all-docs');
            //return redirect('all-docs');

        }
    }
}
