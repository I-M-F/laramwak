<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use DB;

class FullCalenderController extends Controller
{
    //
    public function addEvent()
    {
        return view('backend.user.add-event');
    }

      public function uploadEvent(Request $request)
    {
        $data = array();
       
        $data['event_name'] = $request->event_title;
        $data['event_url'] = $request->event_url;
        $data['event_start'] = $request->event_start;
        $data['event_end'] = $request->event_end;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

       /// dd($data);

        $insert = DB::table('events')->insert($data);


        if ($insert) {
            $notification = array(
                'messege' => 'Succesfull User Updated',
                'alert-type' => 'success'
            );
            return redirect()->route('add-event')->with($notification);
        } else {
            $notification = array(
                'messege' => 'Something is Wrong, please try User update again!',
                'alert-type' => 'error'
            );
            return redirect()->route('add-event')->with($notification);
        }


    }
    public function getEvents(Request $request)
    {
        // Fetch events from your data source (e.g., a database)
        //$events = DB::table('events')->get();

        //$events = Event::select(['event_name', 'event_start', 'event_end'])->get();
        $events = Event::select(['event_name as title', 'event_url as url', 'event_start as start', 'event_end as end'])->get();

        // Convert the events to a JSON response
        return response()->json($events);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::whereDate('event_start', '>=', $request->start)
                ->whereDate('event_end',   '<=', $request->end)
                ->get(['id', 'event_name', 'event_start', 'event_end']);
            return response()->json($data);
        }
        return view('welcome');
    }

    public function calendarEvents(Request $request)
    {

        switch ($request->type) {
            case 'create':
                $event = Event::create([
                    'event_name' => $request->event_name,
                    'event_start' => $request->event_start,
                    'event_end' => $request->event_end,
                ]);

                return response()->json($event);
                break;

            case 'edit':
                $event = Event::find($request->id)->update([
                    'event_name' => $request->event_name,
                    'event_start' => $request->event_start,
                    'event_end' => $request->event_end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # ...
                break;
        }
    }
}
