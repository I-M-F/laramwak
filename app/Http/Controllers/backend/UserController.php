<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;


use AfricasTalking\SDK\AfricasTalking;

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
        return view('backend.user.all-user', compact('all'));
    }

    public function AllMembers()
    {
        //SELECT * FROM member_registartions, payments WHERE member_registartions.phone 
        $all_members = DB::table('member_registartions')->get();

        // DB::table(DB::raw('phpbb_topics t, phpbb_posts p, phpbb_users u')) 
        // ->select(DB::raw('p.post_text, p.bbcode_uid, u.username, t.forum_id, t.topic_title, t.topic_time, t.topic_id, t.topic_poster'))
        // ->where('phpbb_topics.topic_first_post_id', '=', 'phpbb_posts.post_id')
        // ->where('phpbb_users', 'phpbb_topics.topic_poster', '=', 'phpbb_users.user_id')
        // ->order_by('topic_time', 'desc')->take(10)->get();

        return view('backend.user.all-members', compact('all_members'));
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
        if ($insert) {
            echo "Succesfull";
        } else {
            echo "Something wnet wrong";
        }
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
        $countyDB = DB::table('counties')
        ->where('id', '=', $view_member->county)
        ->first();
        $subCountyDB = DB::table('constituencies')
        ->where('county_id', '=', $view_member->sub_county)
        ->first();
        $paymentDB = DB::table('payments')
            ->where('phone', '=', $view_member->phone)
            ->first();
        return view('backend.user.view-member', compact('view_member', 'paymentDB','countyDB','subCountyDB'));
    }

    public function updateMember(Request $request, $id)
    {
        $date = date('m-Y');

        $mwak_no = 'MWAK-'.$date.'-'.$id;
        
        $data = array();
        //$data['chapter'] = $request->chapter;
        $data['member_no'] = $mwak_no;
        $data['status'] = "Active";
        $data['updated_at'] = date('Y-m-d H:i:s');

        $update = DB::table('member_registartions')
            ->where('id', $id)
            ->update($data);
        if ($update) {
            echo "Data Updated Succesfully";
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
                'message' => 'Dear ' . $view_member->first_name.' '.$view_member->maiden_name. ' Welcome to MWAK. You have been assigned chapter'.$mwak_no.' visit your chapter to collect your MWAK ID Card. Your Membership No. is ' . $mwak_no.' Thank you for being a member and supporting our pillars.',
                'from' => $username
            ]);
            $paymentDB = DB::table('payments')
                ->where('phone', '=', $view_member->phone)
                ->first();


            return view('backend.user.view-member', compact('view_member', 'paymentDB'));
        } else {
            echo "Something wnet wrong";
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

    public function DeleteUser($id)
    {
        # code...
        $delete = DB::table('users')
            ->where('id', $id)
            ->delete();

        if ($delete) {
            echo "Data Removed Succesfully";
        } else {
            echo "Something wnet wrong";
        }
    }
}
