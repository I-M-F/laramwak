<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;

use DB;
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;
use AfricasTalking\SDK\AfricasTalking;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class FileController extends Controller
{
    //
    public function addDocs()
    {
        return view('backend.user.add-docs');
    }

    public function uploadDocs(Request $request)
    {

        $file = $request->hasFile('fileDocs');
        if($file){

            $newFile = $request->file('fileDocs');
            $file_path = $newFile->store('public/mwak_docs');

            //dd(asset('/storage/'.$file_path));
            // File::create([
            //     'description' => $request->description,
            //     'docs_data' => $file_path,
            //     'date' => $date
            // ]);
            //
        // }

        // if ($request->fileDocs) {
        //     $mwakDocs = 'MWAKDocs_' . time() . $request->fileDocs->getClientOriginalName();
        //     $upload_docs = $request->fileDocs->storeAs('mwak_docsx', $mwakDocs);
        // }

        // if ($mwakDocs) {

            $date = date('Y-m-d H:i:s');


            $values = array(
                "description" => $request->description,
                "docs_data" => $file_path,
                "date" => $date
            );

            //dd($values);

            $insert = DB::table('mwakfiles')->insert($values);
            if($insert)
            {          
                $notification = array(
                    'messege'=>'Succesfull Document Updated',
                    'alert-type'=>'success'
                );
                return redirect()->route('allDocs')->with($notification);
            }
            else{
                $notification = array(
                    'messege'=>'Something is Wrong, please try Document update again!',
                    'alert-type'=>'error'
                );
                return redirect()->route('allDocs')->with($notification);
            }
        }

        // dd($values);

    }

    public function bulkSMS()
    {
        return view('backend.user.bulk-sms');
    }



    // public function allBulkSMS(Request $request)
    // {

    //     // Check if a file was uploaded
    //     if (!$request->hasFile('fileDocs')) {
    //         return redirect()->back()->withErrors(['message' => 'No file was uploaded.']);
    //     }

    //     $file = $request->file('fileDocs');
    //     $numbers = [];

    //     // Check if the uploaded file is an Excel file
    //     if ($file->getClientOriginalExtension() === 'xlsx') {
    //         $data = Excel::toArray([], $file);
    //        //  dd($data);
    //         //$numbers = array_column($data[0][2], 'phone');
    //         $numbers = collect($data[0])->skip(1)->pluck('2')->toArray();
    //     }
    //     // Check if the uploaded file is a CSV file
    //     else if ($file->getClientOriginalExtension() === 'csv') {
    //         $file = fopen($file, 'r');
    //         while (($row = fgetcsv($file)) !== false) {
    //             $numbers[] = $row[2];
    //         }
    //         fclose($file);
    //     } else {
    //         return redirect()->back()->withErrors(['message' => 'The uploaded file must be an Excel or CSV file.']);
    //     }

    //     if (empty($numbers)) {
    //         return redirect()->back()->withErrors(['message' => 'The uploaded file does not contain any phone numbers.']);
    //     }



    //     //$this->SendNotifySMS(implode(', ', $numbers), $request->smsdets);
    //     foreach ($numbers as $number) {
    //        $this->SendNotifySMS($number, $request->smsdets);

    //     }


    //     //return redirect()->route('payment')->with($notification);
    //     // return view('backend.user.bulk-sms', compact('numbers'));
    //     return redirect()->back()->with(['message' => 'Bulk SMS send successfully.']);

    //     //return redirect()->back()->withErrors(['message' => 'Bulk SMS sent successfully']);
    // }

    public function allBulkSMS(Request $request)
    {
        if (!$request->hasFile('fileDocs')) {
            return redirect()->back()->withErrors(['message' => 'No file was uploaded.']);
        }

        $file = $request->file('fileDocs');
        $numbers = $this->extractPhoneNumbersFromFile($file);

        if (empty($numbers)) {
            return redirect()->back()->withErrors(['message' => 'The uploaded file does not contain any phone numbers.']);
        }

        //$this->sendSMSNotifications($numbers, $request->smsdets);

        $this->SendNotifySMS($numbers, $request->smsdets);

        return redirect()->back()->with(['message' => 'Bulk SMS sent successfully.']);
    }

    private function extractPhoneNumbersFromFile($file)
    {
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'xlsx') {
            return $this->extractPhoneNumbersFromExcel($file);
        } elseif ($extension === 'csv') {
            return $this->extractPhoneNumbersFromCSV($file);
        } else {
            return [];
        }
    }

    private function extractPhoneNumbersFromExcel($file)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $numbers = [];

        foreach ($sheet->toArray() as $row) {
            $numbers[] = $row[2] ?? null;
        }

        return array_filter($numbers);
    }

    private function extractPhoneNumbersFromCSV($file)
    {
        $numbers = [];
        $handle = fopen($file, 'r');

        while (($row = fgetcsv($handle)) !== false) {
            $numbers[] = $row[2] ?? null;
        }

        fclose($handle);

        return array_filter($numbers);
    }





    public function allDocs()
    {

        $all = DB::table('mwakfiles')->get();

        return view('backend.user.all-docs', compact('all'));
    }

    public function viewDocs($id)
    {
        $view = DB::table('mwakfiles')->where('id', $id)->first();
        $str = substr($view->docs_data, 6);
        return view('backend.user.view-docs', compact('str','view'));
    }

    public function SendNotifySMS($phone, $message)
    {
       // print_r($message);

        //dd($message);
  
        $username = 'MWAK'; // use 'sandbox' for development in the test environment
        $apiKey   = 'e5ea09562f3ad404503a38c8e3f3ef3cdaf3efa89193b27268b954a3f6bf7694'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);

        // // Get one of the services
        $sms      = $AT->sms();
        //$output = preg_replace("/^0/", "+254", $phone);
        $output = '+254' .  $phone;
        // Use the service
        $result   = $sms->send([
            'to'      => $output,
            'message' => $message,
            'from' => $username
        ]);
        print_r($result);
    }
}
