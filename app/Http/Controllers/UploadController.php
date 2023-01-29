<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class UploadController extends Controller
{
    public function FileUpload(Request $request){

        $files = $request->file('files');
        if(count($files)){
            foreach($files as $file){
                // Store the file in the disk 
                Storage::disk('local')->put('documents/',$file,'public');
            }
        }
        return response()->json(['status'=>'OK']);
    }
}
