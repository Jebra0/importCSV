<?php

namespace App\Http\Controllers;

use App\Jobs\ImportCsvJob;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    public function upload(){
        return view('upload');
    }
    public function store(Request $request){
        $csv = file($request->file);

        //chunking to small files
        $chunks = array_chunk($csv, 1000);

        $header = [];
        foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);

            if($key == 0){
                $header = $data[0];
                unset($data[0]);
            }
            ImportCsvJob::dispatch($data, $header);
        }
        return 'Done';
    }
}
