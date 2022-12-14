<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;

use DB;
use Illuminate\Support\Facades\Storage;

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
}
