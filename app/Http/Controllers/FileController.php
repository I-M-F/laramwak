<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;

use DB;

class FileController extends Controller
{
    //
    public function addDocs()
    {
        return view('backend.user.add-docs');
    }

    public function uploadDocs(Request $request){

         
        if($request->fileDocs){            
            $mwakDocs = 'MWAKDocs_'.time().$request->fileDocs->getClientOriginalName();
            $upload_docs = $request->fileDocs->storeAs('mwak_docsx', $mwakDocs);
        }   

        if($mwakDocs){
            
            $date = date('Y-m-d H:i:s');

          
            $values = array(           
                "description"=>$request->description,
                "docs_data"=>$mwakDocs,
                "date"=>$date
            );

           
        
            $insert = DB::table('mwakfiles')->insert($values);
            if ($insert) {
                echo "Succesfull Data Submission";
            } else {
                echo "Something went wrong";
            }
            
      
        }
        
       // dd($values);

    }
    public function allDocs()
    {

        $all = DB::table('mwakfiles')->get();
        return view('backend.user.all-docs', compact('all'));
    }

    public function viewDocs($id)
    {
        $view = DB::table('mwakfiles')->where('id', $id)->first();
        return view('backend.user.view-docs', compact('view'));
    }

}


